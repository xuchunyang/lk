<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Topic;
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
        $categories = Category::factory(5)
            ->has(Topic::factory(20))
            ->create();
        $categories->each(function (Category $category) {
            $category
                ->addMediaFromUrl('https://picsum.xuchunyang.cn/image/400')
                ->toMediaCollection();
        });
    }
}
