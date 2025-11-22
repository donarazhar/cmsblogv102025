<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Backup database setiap hari jam 02:00 WIB
        $schedule->command('backup:run --only-db')
            ->dailyAt('02:00')
            ->timezone('Asia/Jakarta')
            ->onSuccess(function () {
                \Log::info('Daily database backup completed successfully');
            })
            ->onFailure(function () {
                \Log::error('Daily database backup failed');
            });

        // Full backup (database + files) setiap minggu pada hari Minggu jam 03:00 WIB
        $schedule->command('backup:run')
            ->weeklyOn(0, '03:00') // 0 = Sunday
            ->timezone('Asia/Jakarta')
            ->onSuccess(function () {
                \Log::info('Weekly full backup completed successfully');
            })
            ->onFailure(function () {
                \Log::error('Weekly full backup failed');
            });

        // Clean old backups setiap hari jam 04:00 WIB
        $schedule->command('backup:clean')
            ->dailyAt('04:00')
            ->timezone('Asia/Jakarta')
            ->onSuccess(function () {
                \Log::info('Old backups cleaned successfully');
            })
            ->onFailure(function () {
                \Log::error('Failed to clean old backups');
            });

        // Monitor backup health setiap jam
        $schedule->command('backup:monitor')
            ->hourly()
            ->timezone('Asia/Jakarta');

        // Alternatif: Backup setiap 6 jam
        // $schedule->command('backup:run --only-db')
        //     ->cron('0 */6 * * *') // Setiap 6 jam
        //     ->timezone('Asia/Jakarta');

        // Alternatif: Backup setiap hari Senin-Jumat (hari kerja)
        // $schedule->command('backup:run --only-db')
        //     ->weekdays()
        //     ->at('02:00')
        //     ->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
