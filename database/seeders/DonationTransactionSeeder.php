<?php

namespace Database\Seeders;

use App\Models\DonationTransaction;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $donations = Donation::all();
        $users = User::all();

        foreach ($donations as $donation) {
            // Create 10-20 transactions per donation
            $transactionCount = rand(10, 20);

            for ($i = 1; $i <= $transactionCount; $i++) {
                $amount = $this->getRandomAmount($donation->category);
                $isAnonymous = rand(0, 10) < 3; // 30% anonymous
                $status = $this->getRandomStatus();

                $transaction = DonationTransaction::create([
                    'donation_id' => $donation->id,
                    'user_id' => rand(0, 1) ? $users->random()->id : null,
                    'donor_name' => $isAnonymous ? 'Hamba Allah' : $this->getRandomName(),
                    'donor_email' => $isAnonymous ? null : 'donor' . $i . '@example.com',
                    'donor_phone' => $isAnonymous ? null : '0812345678' . sprintf('%02d', $i),
                    'amount' => $amount,
                    'payment_method' => $this->getRandomPaymentMethod(),
                    'payment_proof' => 'proof-' . uniqid() . '.jpg',
                    'status' => $status,
                    'notes' => rand(0, 1) ? 'Semoga berkah dan bermanfaat' : null,
                    'is_anonymous' => $isAnonymous,
                    'paid_at' => now()->subDays(rand(1, 60)),
                    'verified_at' => $status === 'verified' ? now()->subDays(rand(1, 50)) : null,
                    'verified_by' => $status === 'verified' ? 1 : null,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }

        // Create some pending transactions
        for ($i = 1; $i <= 5; $i++) {
            DonationTransaction::create([
                'donation_id' => $donations->random()->id,
                'donor_name' => $this->getRandomName(),
                'donor_email' => 'pending' . $i . '@example.com',
                'donor_phone' => '0856789012' . $i,
                'amount' => rand(100000, 1000000),
                'payment_method' => 'bank_transfer',
                'payment_proof' => 'proof-pending-' . $i . '.jpg',
                'status' => 'pending',
                'notes' => 'Menunggu verifikasi',
                'is_anonymous' => false,
                'paid_at' => now(),
                'created_at' => now(),
            ]);
        }
    }

    private function getRandomAmount($category): int
    {
        return match ($category) {
            'renovation' => rand(100000, 10000000),
            'zakat' => rand(50000, 500000),
            'qurban' => [2500000, 3000000, 21000000][array_rand([2500000, 3000000, 21000000])],
            'program' => rand(500000, 5000000),
            default => rand(50000, 1000000),
        };
    }

    private function getRandomStatus(): string
    {
        $statuses = ['verified', 'verified', 'verified', 'verified', 'pending', 'rejected'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomPaymentMethod(): string
    {
        $methods = ['bank_transfer', 'bank_transfer', 'qris', 'cash'];
        return $methods[array_rand($methods)];
    }

    private function getRandomName(): string
    {
        $names = [
            'Ahmad Fauzi',
            'Siti Aminah',
            'Muhammad Rizki',
            'Fatimah Zahra',
            'Abdullah Rahman',
            'Khadijah Azzahra',
            'Umar Faruq',
            'Aisyah Putri',
            'Ali Hasan',
            'Maryam Binti Ahmad',
            'Yusuf Ibrahim',
            'Zainab Khalid',
        ];
        return $names[array_rand($names)];
    }
}
