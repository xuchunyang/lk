<?php

namespace Database\Factories;

use App\Models\Category;
use Identicon\Identicon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(2, true),
            'title' => fake()->words(3, true),
            'color' => fake()->hexColor(),
            'description' => fake()->paragraph(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            $category
                ->addMediaFromBase64((new Identicon())->getImageDataUri($category->name))
                ->usingFileName(Str::uuid() . '.png')
                ->toMediaCollection();
        });
    }
}
