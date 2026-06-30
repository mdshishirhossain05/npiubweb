<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notice>
 */
class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(6),
            'body' => fake()->paragraph(),
            'notice_date' => fake()->dateTimeBetween('-1 year')->format('Y-m-d'),
            'is_pinned' => false,
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ];
    }

    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
        ]);
    }
}
