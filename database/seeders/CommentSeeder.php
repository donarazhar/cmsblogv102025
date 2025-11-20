<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::published()->limit(5)->get();
        $users = User::all();

        foreach ($posts as $post) {
            // Create 3-5 comments per post
            $commentCount = rand(3, 5);

            for ($i = 1; $i <= $commentCount; $i++) {
                $user = $users->random();

                $comment = Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => $this->getRandomComment(),
                    'status' => 'approved',
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subDays(rand(1, 10)),
                ]);

                // Add 1-2 replies
                if (rand(0, 1)) {
                    $replyUser = $users->random();
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $replyUser->id,
                        'parent_id' => $comment->id,
                        'content' => $this->getRandomReply(),
                        'status' => 'approved',
                        'ip_address' => '127.0.0.1',
                        'created_at' => now()->subDays(rand(1, 10)),
                    ]);
                }
            }
        }
    }

    private function getRandomComment(): string
    {
        $comments = [
            'MasyaAllah, artikel yang sangat bermanfaat. Jazakallahu khairan.',
            'Terima kasih atas sharingnya, sangat menginspirasi.',
            'Alhamdulillah, semoga kita semua bisa mengamalkannya.',
            'Barakallahu fiik, penjelasannya mudah dipahami.',
            'Subhanallah, semoga menjadi amal jariyah untuk penulisnya.',
        ];

        return $comments[array_rand($comments)];
    }

    private function getRandomReply(): string
    {
        $replies = [
            'Aamiin ya rabbal alamin.',
            'Wa iyyakum, semoga bermanfaat.',
            'Sama-sama, mari kita saling mengingatkan.',
            'Alhamdulillah, senang bisa berbagi.',
        ];

        return $replies[array_rand($replies)];
    }
}
