<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => '<p>' . $this->faker->paragraph() . '</p>',
            'thumbnail' => null,
            'status' => 'published',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
