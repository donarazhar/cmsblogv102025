<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567890',
                'subject' => 'Pertanyaan tentang Pendaftaran Tahfidz',
                'message' => 'Assalamualaikum, saya ingin menanyakan tentang pendaftaran program tahfidz untuk anak usia 8 tahun. Apakah masih ada kuota? Terima kasih.',
                'status' => 'new',
                'ip_address' => '192.168.1.1',
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nur@example.com',
                'phone' => '082345678901',
                'subject' => 'Informasi Kajian Muslimah',
                'message' => 'Assalamualaikum warahmatullah, saya tertarik mengikuti kajian muslimah. Mohon info jadwal dan tempatnya. Jazakillah khair.',
                'status' => 'read',
                'ip_address' => '192.168.1.2',
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Ahmad Fauzan',
                'email' => 'ahmad.fauzan@example.com',
                'phone' => '083456789012',
                'subject' => 'Donasi untuk Renovasi Masjid',
                'message' => 'Assalamualaikum, saya ingin berdonasi untuk renovasi masjid. Bagaimana caranya? Mohon info rekening dan prosedurnya.',
                'status' => 'replied',
                'admin_reply' => 'Waalaikumsalam warahmatullahi wabarakatuh. Terima kasih atas niat baiknya. Untuk donasi renovasi masjid, Bapak dapat transfer ke:\n\nBank Syariah Indonesia\nNo. Rek: 1234567890\nA/N: YPI Al Azhar - Renovasi\n\nSetelah transfer mohon konfirmasi melalui WhatsApp 081234567890. Barakallahu fiik.',
                'replied_at' => now()->subDays(4),
                'replied_by' => 1,
                'ip_address' => '192.168.1.3',
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'Rahma Widya',
                'email' => 'rahma.widya@example.com',
                'phone' => '084567890123',
                'subject' => 'Kerjasama Kegiatan Sosial',
                'message' => 'Assalamualaikum, kami dari organisasi sosial XYZ ingin mengajukan kerjasama untuk kegiatan bakti sosial. Apakah bisa? Terima kasih.',
                'status' => 'read',
                'ip_address' => '192.168.1.4',
                'created_at' => now()->subWeek(),
            ],
            [
                'name' => 'Dedi Hermawan',
                'email' => 'dedi.h@example.com',
                'phone' => '085678901234',
                'subject' => 'Jadwal Kajian Ramadhan',
                'message' => 'Assalamualaikum, apakah ada jadwal kajian khusus ramadhan? Saya ingin mengikutinya. Jazakallah.',
                'status' => 'new',
                'ip_address' => '192.168.1.5',
                'created_at' => now()->subHours(12),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        // Create archived contacts
        Contact::create([
            'name' => 'Lama User',
            'email' => 'old@example.com',
            'phone' => '086789012345',
            'subject' => 'Pertanyaan Lama',
            'message' => 'Ini pesan lama yang sudah diarsipkan.',
            'status' => 'archived',
            'ip_address' => '192.168.1.6',
            'created_at' => now()->subMonths(6),
        ]);
    }
}
