<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3),
            'description' => fake()->text,
            'start_time' => fake()->dateTimeBetween('+2 months', '+3 month'),
            'end_time' => fake()->dateTimeBetween('+3 months', '+4 months'),
            'location' => fake()->city(),
            'max_attendees' => fake()->optional()->numberBetween(1, 4) ? fake()->numberBetween(1, 20) * 50 : null,
            'price' => fake()->randomElement(array_merge(
                [0, 0], // in 2/10 cases a 0
                array_fill(0, 8, fake()->randomFloat(2, 5, 100)) // in 8/10 cases a number between 5-100, with 2 decimals
            ))
        ];
    }
}
