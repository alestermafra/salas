<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $end = fake()->dateTimeThisMonth;
        return [
            'reservation' => fake()->word,
            'start' => $start,
            'end' => $end,
            'description' => fake()->text,
        ];
    }
}
