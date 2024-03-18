<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'favicon_path' => '/favicon.ico',
            'url' => $this->faker->unique()->url,
            'title' => $this->faker->company,
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => $this->faker->sentence
        ];
    }
}
