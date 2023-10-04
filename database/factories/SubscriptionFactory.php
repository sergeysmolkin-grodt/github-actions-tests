<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'regular_package_session',
            'is_active' => 1,
            'is_paused' => 1,
            'start_date' => '2020-12-12',
            'end_date' => '2030-12-12',
            'count_used_sessions' => '4'
        ];
    }
}
