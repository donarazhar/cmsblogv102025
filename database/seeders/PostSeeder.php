<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $author = User::first() ?? User::factory()->create();
        
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Berita & Artikel',
                'slug' => 'berita-artikel',
                'description' => 'Kategori umum untuk berita dan artikel'
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $title = $faker->sentence(6);
            Post::create([
                'title' => rtrim($title, '.'),
                'slug' => Str::slug($title) . '-' . Str::random(4),
                'excerpt' => $faker->paragraph(2),
                'content' => '<p>' . implode('</p><p>', $faker->paragraphs(4)) . '</p>',
                'category_id' => $category->id,
                'author_id' => $author->id,
                'status' => 'published',
                'post_type' => 'article',
                'is_featured' => $i < 3, // 3 featured posts
                'allow_comments' => true,
                'views_count' => $faker->numberBetween(10, 500),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('✅ Berita/Artikel berhasil di-seed! (10 data)');
    }
}
