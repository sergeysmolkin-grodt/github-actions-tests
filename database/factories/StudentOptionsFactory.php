<?php

namespace Database\Factories;

use App\Models\StudentOptions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentOptions>
 */
class StudentOptionsFactory extends Factory
{
    protected $model = StudentOptions::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'has_free_unlimited_sessions' => 1,
            'has_free_sessions_for_company' => 1,
            'has_free_recurring_sessions_for_company' => 1,
            'has_gift_sessions' => 1,
            'has_recurring_gift_sessions' => 1,
            'has_email_notification' => 1,
            'count_trial_sessions' => 5,
            'count_company_sessions' => 5,
            'count_gift_sessions' => 5,
            'count_recurring_gift_sessions' => 4,
        ];
    }
}
