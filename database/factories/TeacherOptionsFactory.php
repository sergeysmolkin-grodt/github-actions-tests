<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherOptions>
 */
class TeacherOptionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bio' => $this->faker->text,
            'attainment' => $this->faker->text,
            'allows_trial' => 1,
            'can_be_booked' => 1,
            'verification_status' => 'pending',
        ];
    }
}
