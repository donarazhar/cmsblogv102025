<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DonationTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = DonationTransaction::with(['donation', 'user', 'verifier'])
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by donation
        if ($request->has('donation_id') && $request->donation_id != '') {
            $query->where('donation_id', $request->donation_id);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                    ->orWhere('donor_name', 'like', "%{$search}%")
                    ->orWhere('donor_email', 'like', "%{$search}%")
                    ->orWhere('donor_phone', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(15);
        $donations = Donation::active()->orderBy('campaign_name')->get();

        // Statistics
        $stats = [
            'total' => DonationTransaction::count(),
            'pending' => DonationTransaction::pending()->count(),
            'verified' => DonationTransaction::verified()->count(),
            'rejected' => DonationTransaction::rejected()->count(),
            'total_amount' => DonationTransaction::verified()->sum('amount'),
        ];

        return view('admin.donation-transactions.index', compact('transactions', 'donations', 'stats'));
    }

    public function create()
    {
        $donations = Donation::active()->orderBy('campaign_name')->get();
        return view('admin.donation-transactions.create', compact('donations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:bank_transfer,qris,cash,other',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
            'is_anonymous' => 'boolean',
            'status' => 'required|in:pending,verified,rejected',
        ], [
            'amount.min' => 'Jumlah donasi minimal Rp 10.000',
            'payment_proof.max' => 'Ukuran file maksimal 2MB',
            'payment_proof.image' => 'File harus berupa gambar',
        ]);

        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('donation-proofs', 'public');
        }

        $validated['is_anonymous'] = $request->has('is_anonymous');
        $validated['paid_at'] = now();

        // If status is verified, set verified data
        if ($validated['status'] === 'verified') {
            $validated['verified_at'] = now();
            $validated['verified_by'] = Auth::id();
        }

        $transaction = DonationTransaction::create($validated);

        // Update donation amount if verified
        if ($transaction->status === 'verified') {
            $transaction->donation->updateAmount($transaction->amount);
        }

        return redirect()->route('admin.donation-transactions.index')
            ->with('success', 'Transaksi donasi berhasil ditambahkan!');
    }

    public function show(DonationTransaction $donationTransaction)
    {
        $donationTransaction->load(['donation', 'user', 'verifier']);
        
        return view('admin.donation-transactions.show', [
            'transaction' => $donationTransaction
        ]);
    }

    public function edit(DonationTransaction $donationTransaction)
    {
        $donations = Donation::active()->orderBy('campaign_name')->get();
        
        return view('admin.donation-transactions.edit', [
            'transaction' => $donationTransaction,
            'donations' => $donations
        ]);
    }

    public function update(Request $request, DonationTransaction $donationTransaction)
    {
        $validated = $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:bank_transfer,qris,cash,other',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:pending,verified,rejected,cancelled',
            'notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'is_anonymous' => 'boolean',
        ], [
            'amount.min' => 'Jumlah donasi minimal Rp 10.000',
            'payment_proof.max' => 'Ukuran file maksimal 2MB',
            'payment_proof.image' => 'File harus berupa gambar',
        ]);

        // Store old data for reverting donation amount if needed
        $oldAmount = $donationTransaction->amount;
        $oldStatus = $donationTransaction->status;
        $oldDonationId = $donationTransaction->donation_id;

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            // Delete old file
            if ($donationTransaction->payment_proof) {
                Storage::disk('public')->delete($donationTransaction->payment_proof);
            }
            $validated['payment_proof'] = $request->file('payment_proof')->store('donation-proofs', 'public');
        }

        $validated['is_anonymous'] = $request->has('is_anonymous');

        // Handle status changes
        if ($validated['status'] === 'verified' && $oldStatus !== 'verified') {
            // Status changed to verified
            $validated['verified_at'] = now();
            $validated['verified_by'] = Auth::id();
            
            // Update donation amount
            $donationTransaction->donation->updateAmount($validated['amount']);
        } elseif ($oldStatus === 'verified' && $validated['status'] !== 'verified') {
            // Status changed from verified to other
            // Revert donation amount
            $donationTransaction->donation->updateAmount(-$oldAmount);
            
            // Clear verification data
            $validated['verified_at'] = null;
            $validated['verified_by'] = null;
        } elseif ($oldStatus === 'verified' && $validated['status'] === 'verified') {
            // Both old and new status are verified
            // Update amount if changed
            if ($oldAmount != $validated['amount']) {
                $difference = $validated['amount'] - $oldAmount;
                $donationTransaction->donation->updateAmount($difference);
            }
        }

        $donationTransaction->update($validated);

        return redirect()
            ->route('admin.donation-transactions.show', $donationTransaction)
            ->with('success', 'Transaksi donasi berhasil diupdate!');
    }

    public function destroy(DonationTransaction $donationTransaction)
    {
        // Revert donation amount if transaction was verified
        if ($donationTransaction->status === 'verified') {
            $donationTransaction->donation->updateAmount(-$donationTransaction->amount);
        }

        // Delete payment proof file
        if ($donationTransaction->payment_proof) {
            Storage::disk('public')->delete($donationTransaction->payment_proof);
        }

        $donationTransaction->delete();

        return redirect()
            ->route('admin.donation-transactions.index')
            ->with('success', 'Transaksi donasi berhasil dihapus!');
    }

    public function verify(DonationTransaction $donationTransaction)
    {
        if ($donationTransaction->status === 'verified') {
            return back()->with('info', 'Transaksi sudah diverifikasi sebelumnya.');
        }

        $donationTransaction->verify(Auth::id());

        return back()->with('success', 'Transaksi berhasil diverifikasi!');
    }

    public function reject(Request $request, DonationTransaction $donationTransaction)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:1000',
        ], [
            'admin_notes.required' => 'Alasan penolakan harus diisi',
            'admin_notes.min' => 'Alasan penolakan minimal 10 karakter',
            'admin_notes.max' => 'Alasan penolakan maksimal 1000 karakter',
        ]);

        if ($donationTransaction->status === 'rejected') {
            return back()->with('info', 'Transaksi sudah ditolak sebelumnya.');
        }

        // Revert donation amount if transaction was verified
        if ($donationTransaction->status === 'verified') {
            $donationTransaction->donation->updateAmount(-$donationTransaction->amount);
        }

        $donationTransaction->reject($validated['admin_notes']);

        return redirect()
            ->route('admin.donation-transactions.index')
            ->with('success', 'Transaksi berhasil ditolak!');
    }

    public function bulkVerify(Request $request)
    {
        $validated = $request->validate([
            'transaction_ids' => 'required|array|min:1',
            'transaction_ids.*' => 'exists:donation_transactions,id',
        ], [
            'transaction_ids.required' => 'Pilih minimal 1 transaksi',
            'transaction_ids.min' => 'Pilih minimal 1 transaksi',
        ]);

        $count = 0;
        $skipped = 0;

        foreach ($validated['transaction_ids'] as $id) {
            $transaction = DonationTransaction::find($id);
            if ($transaction && $transaction->status === 'pending') {
                $transaction->verify(Auth::id());
                $count++;
            } else {
                $skipped++;
            }
        }

        $message = "{$count} transaksi berhasil diverifikasi!";
        if ($skipped > 0) {
            $message .= " ({$skipped} transaksi dilewati karena sudah diverifikasi)";
        }

        return back()->with('success', $message);
    }

    public function export(Request $request)
    {
        $query = DonationTransaction::with(['donation', 'user', 'verifier'])
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('donation_id') && $request->donation_id != '') {
            $query->where('donation_id', $request->donation_id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                    ->orWhere('donor_name', 'like', "%{$search}%")
                    ->orWhere('donor_email', 'like', "%{$search}%")
                    ->orWhere('donor_phone', 'like', "%{$search}%");
            });
        }

        $transactions = $query->get();

        $filename = 'donation-transactions-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($file, [
                'Kode Transaksi',
                'Campaign',
                'Kategori',
                'Nama Donatur',
                'Email',
                'Telepon',
                'Jumlah (Rp)',
                'Metode Pembayaran',
                'Status',
                'Anonim',
                'Catatan Donatur',
                'Catatan Admin',
                'Tanggal Transaksi',
                'Tanggal Verifikasi',
                'Diverifikasi Oleh',
            ]);

            // Data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_code,
                    $transaction->donation->campaign_name,
                    ucfirst($transaction->donation->category),
                    $transaction->is_anonymous ? 'Hamba Allah (Anonim)' : $transaction->donor_name,
                    $transaction->is_anonymous ? '-' : $transaction->donor_email,
                    $transaction->is_anonymous ? '-' : $transaction->donor_phone,
                    number_format($transaction->amount, 0, ',', '.'),
                    ucfirst(str_replace('_', ' ', $transaction->payment_method)),
                    ucfirst($transaction->status),
                    $transaction->is_anonymous ? 'Ya' : 'Tidak',
                    $transaction->notes ?? '-',
                    $transaction->admin_notes ?? '-',
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->verified_at ? $transaction->verified_at->format('d/m/Y H:i') : '-',
                    $transaction->verifier ? $transaction->verifier->name : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}