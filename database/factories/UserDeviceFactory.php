<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserDeviceFactory extends Factory
{
    protected $model = UserDevice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => rand(1,10),
            'device_type' => $this->faker->title,
            'device_token' => Str::random(10),
            'os_version' => $this->faker->title,
            'brand' => $this->faker->title,
            'model' => Str::random(10)
        ];
    }
}
