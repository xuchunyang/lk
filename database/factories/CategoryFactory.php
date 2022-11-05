<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'slug' => fake()->slug(1, true),
            'title' => fake()->words(3, true),
            'color' => fake()->hexColor(),
            'description' => fake()->paragraph(),
        ];
    }
}
