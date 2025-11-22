<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupController extends Controller
{
    /**
     * Display backup list
     */
    public function index()
    {
        $disk = Storage::disk('local');
        $backups = [];
        $backupPath = config('backup.backup.name');

        if ($disk->exists($backupPath)) {
            $files = $disk->allFiles($backupPath);

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                    $backups[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes($disk->size($file)),
                        'size_bytes' => $disk->size($file),
                        'date' => Carbon::createFromTimestamp($disk->lastModified($file)),
                    ];
                }
            }
        }

        // Sort by date descending
        usort($backups, function ($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });

        // Calculate total storage used
        $totalStorage = array_sum(array_column($backups, 'size_bytes'));

        return view('admin.backups.index', compact('backups', 'totalStorage'));
    }

    /**
     * Create new backup
     */
    public function create()
    {
        try {
            // Run backup
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--disable-notifications' => true,
            ]);

            $output = Artisan::output();

            // Log activity if using spatie/laravel-activitylog
            if (class_exists('\Spatie\Activitylog\Models\Activity')) {
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['output' => $output])
                    ->log('Created database backup');
            }

            return redirect()
                ->route('admin.backups.index')
                ->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            \Log::error('Backup failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Create full backup (database + files)
     */
    public function createFull()
    {
        try {
            // Run full backup
            Artisan::call('backup:run', [
                '--disable-notifications' => true,
            ]);

            $output = Artisan::output();

            // Log activity
            if (class_exists('\Spatie\Activitylog\Models\Activity')) {
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['output' => $output])
                    ->log('Created full backup (database + files)');
            }

            return redirect()
                ->route('admin.backups.index')
                ->with('success', 'Full backup berhasil dibuat! Proses mungkin memakan waktu beberapa menit.');
        } catch (\Exception $e) {
            \Log::error('Full backup failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal membuat full backup: ' . $e->getMessage());
        }
    }

    /**
     * Download backup
     */
    public function download($filename)
    {
        $disk = Storage::disk('local');
        $backupPath = config('backup.backup.name');
        $path = $backupPath . '/' . $filename;

        if (!$disk->exists($path)) {
            return redirect()
                ->back()
                ->with('error', 'File backup tidak ditemukan!');
        }

        // Log activity
        if (class_exists('\Spatie\Activitylog\Models\Activity')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['filename' => $filename])
                ->log('Downloaded backup');
        }

        return $disk->download($path);
    }

    /**
     * Delete backup
     */
    public function destroy($filename)
    {
        $disk = Storage::disk('local');
        $backupPath = config('backup.backup.name');
        $path = $backupPath . '/' . $filename;

        if (!$disk->exists($path)) {
            return redirect()
                ->back()
                ->with('error', 'File backup tidak ditemukan!');
        }

        $disk->delete($path);

        // Log activity
        if (class_exists('\Spatie\Activitylog\Models\Activity')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['filename' => $filename])
                ->log('Deleted backup');
        }

        return redirect()
            ->route('admin.backups.index')
            ->with('success', 'Backup berhasil dihapus!');
    }

    /**
     * Clean old backups
     */
    public function clean()
    {
        try {
            Artisan::call('backup:clean');
            
            $output = Artisan::output();

            // Log activity
            if (class_exists('\Spatie\Activitylog\Models\Activity')) {
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['output' => $output])
                    ->log('Cleaned old backups');
            }

            return redirect()
                ->route('admin.backups.index')
                ->with('success', 'Backup lama berhasil dibersihkan!');
        } catch (\Exception $e) {
            \Log::error('Cleanup failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal membersihkan backup: ' . $e->getMessage());
        }
    }

    /**
     * Restore backup
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,zip|max:102400', // max 100MB
        ]);

        try {
            $file = $request->file('backup_file');
            $extension = $file->getClientOriginalExtension();
            
            // For security, store in a separate restores directory
            $filename = time() . '_restore_' . $file->getClientOriginalName();
            $path = $file->storeAs('restores', $filename, 'local');

            // If it's a SQL file, restore directly
            if ($extension === 'sql') {
                $sqlContent = Storage::disk('local')->get($path);
                
                // Disable foreign key checks temporarily
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                
                // Execute SQL
                DB::unprepared($sqlContent);
                
                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                // Log activity
                if (class_exists('\Spatie\Activitylog\Models\Activity')) {
                    activity()
                        ->causedBy(auth()->user())
                        ->withProperties(['filename' => $filename])
                        ->log('Restored database from SQL backup');
                }

                // Clean up restore file
                Storage::disk('local')->delete($path);

                return redirect()
                    ->route('admin.backups.index')
                    ->with('success', 'Database berhasil direstore dari file SQL!');
            }

            // For ZIP files
            if ($extension === 'zip') {
                return redirect()
                    ->back()
                    ->with('error', 'Restore dari ZIP file belum didukung. Silakan extract manual dan upload file .sql');
            }

            return redirect()
                ->back()
                ->with('error', 'Format file tidak didukung!');

        } catch (\Exception $e) {
            \Log::error('Restore failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal restore database: ' . $e->getMessage());
        }
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}