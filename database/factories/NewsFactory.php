<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'slug' => null,
            'content' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'published_at' => fake()->optional()->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
