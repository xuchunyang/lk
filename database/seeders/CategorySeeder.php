<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::factory(10)->create();
        $categories->each(function (Category $category) {
            $category
                ->addMediaFromUrl('https://picsum.xuchunyang.cn/image/400')
                ->toMediaCollection();
        });
    }
}
