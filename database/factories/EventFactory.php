<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = Carbon::instance(fake()->dateTimeBetween('now', '+2 months'));

        return [
            'title' => fake()->unique()->sentence(4),
            'description' => fake()->paragraph(),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->addHours(3),
            'location' => fake()->city(),
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ];
    }
}
