<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
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
        $user = $users[0];
        $categories = Category::factory(5)
            ->for($user, 'author')
            ->has(Topic::factory(20)
                ->for($user, 'author')
                ->has(Comment::factory(10)
                    ->for($user, 'author')))
            ->create();
        $categories->each(function (Category $category) {
            $category
                ->addMediaFromUrl('https://picsum.xuchunyang.cn/image/400')
                ->toMediaCollection();
        });
    }
}
