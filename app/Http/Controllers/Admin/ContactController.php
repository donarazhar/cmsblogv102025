<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('replier');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->latest()->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        // Mark as read when opening
        $contact->markAsRead();
        $contact->load('replier');

        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact->reply($request->admin_reply, Auth::id());

        // Optional: Send email reply to user
        // Mail::to($contact->email)->send(new ContactReplyMail($contact));

        return redirect()->back()
            ->with('success', 'Balasan berhasil dikirim!');
    }

    public function archive(Contact $contact)
    {
        $contact->archive();

        return redirect()->back()
            ->with('success', 'Pesan berhasil diarsipkan!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
            'action' => 'required|in:archive,delete,mark_read',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts);

        switch ($request->action) {
            case 'archive':
                $contacts->update(['status' => 'archived']);
                $message = 'Pesan berhasil diarsipkan!';
                break;
            case 'delete':
                $contacts->delete();
                $message = 'Pesan berhasil dihapus!';
                break;
            case 'mark_read':
                $contacts->update(['status' => 'read']);
                $message = 'Pesan ditandai sebagai sudah dibaca!';
                break;
        }

        return redirect()->back()
            ->with('success', $message);
    }

    public function exportCsv(Request $request)
    {
        $query = Contact::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $contacts = $query->latest()->get();

        $filename = 'contacts_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($contacts) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Message', 'Status', 'Date']);

            // Data
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->subject,
                    $contact->message,
                    $contact->status,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
