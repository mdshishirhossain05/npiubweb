<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => null,
            'title' => fake()->unique()->sentence(5),
            'excerpt' => fake()->optional()->sentence(),
            'body' => fake()->paragraphs(4, true),
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ContentStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function inCategory(Category|int|null $category = null): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $category instanceof Category
                ? $category->id
                : ($category ?? Category::factory()),
        ]);
    }
}
