<?php

namespace Database\Factories;

use App\Models\StudentAutoScheduleTime;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentAutoScheduleTimeFactory extends Factory
{
    protected $model = StudentAutoScheduleTime::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = User::factory()->create()->assignRole('student');
        $teacher = User::factory()->create()->assignRole('teacher');

        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'day' => $this->faker->date,
            'time' => $this->faker->time,
            'scheduled_date' => $this->faker->time(format: 'Y-m-d H:i:s')
        ];
    }
}
