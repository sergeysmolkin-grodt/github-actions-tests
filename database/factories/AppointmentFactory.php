<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $teacher = User::factory()->create()->assignRole('teacher');
        $student = User::factory()->create()->assignRole('student');

        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'date' => '2025-08-10',
            'from' => "12:30",
            'to' => "13:00",
            'status' => 'PENDING',
        ];
    }
}
