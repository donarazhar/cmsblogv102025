<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $categories = ['zakat', 'infaq', 'sedekah', 'wakaf', 'program'];

        for ($i = 0; $i < 10; $i++) {
            $name = 'Program Donasi ' . $faker->words(3, true);
            $target = $faker->randomElement([10000000, 50000000, 100000000, 200000000]);
            $current = $faker->numberBetween(0, $target);
            
            Donation::create([
                'campaign_name' => ucwords($name),
                'slug' => Str::slug($name) . '-' . Str::random(4),
                'description' => $faker->paragraph(2),
                'content' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>',
                'category' => $faker->randomElement($categories),
                'target_amount' => $target,
                'current_amount' => $current,
                'donor_count' => $faker->numberBetween(10, 500),
                'start_date' => now()->subDays(rand(1, 10)),
                'end_date' => now()->addDays(rand(10, 60)),
                'is_urgent' => $i < 2, // 2 urgent donations
                'is_featured' => $i < 3, // 3 featured donations
                'is_active' => true,
                'order' => $i + 1,
            ]);
        }

        $this->command->info('✅ Donasi berhasil di-seed! (10 data)');
    }
}
