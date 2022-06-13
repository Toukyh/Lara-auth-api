<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        $users->each(function($user)use($users){
            Article::factory(rand(1,5))->create([
                'user_id'=>$user->id,
            ])->each(function($article) use ($users){
                Comment::factory(rand(2,8))->create([
                    'article_id'=>$article->id,
                    'user_id'=>($users->random(1)->first())->id
                ]);
            });
        });

    }
}
