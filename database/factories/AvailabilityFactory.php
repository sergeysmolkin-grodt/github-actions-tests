<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teacher = User::factory()->create()->assignRole('teacher');

        return [
            'teacher_id' => $teacher,
            'day' => strtolower($this->faker->dayOfWeek),
            'is_available' => 1,
            'from_time' => '12:00',
            'to_time' => '13:00',
            'break_from_time' => null,
            'break_to_time' => null,
        ];
    }
}
