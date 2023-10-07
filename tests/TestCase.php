<?php

namespace Tests;

use App\Models\Availability;
use App\Models\Plan;
use App\Models\StudentOptions;
use App\Models\Subscription;
use App\Models\TeacherOptions;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static function getUserData() : array {
        return [
            'id' => 1,
            'firstname' => fake()->name(),
            'lastname' => fake()->name(),
            'email' => fake()->regexify('^[A-Za-z0-9]{6}@(gmail\.com|email\.ua)$'),
            'password' => Str::random(10),
            'mobile' => fake()->phoneNumber(),
            'ageGroup' => Arr::random(['adult', 'teen', 'kid']),
            'birthDate' => fake()->date(),
            'gender' => Arr::random(['male','female']),
            'loginType' => 'NORMAL',
            'countryCode' => fake()->countryCode(),
            'role' => Arr::random(['student','teacher'])
        ];
    }

    protected static function getAppointmentData(User $teacher, User $student) : array {
        return [
            'id' => 1,
            'userId' => $student->id,
            'language' => fake()->languageCode(),
            'teacherId' => (string)$teacher->id,
            'deviceId' => (string)fake()->numberBetween(1,10),
            'student_id' => $student->id,
            'date' => '2023-12-30',
            'startTime' => "12:30",
        ];
    }

    protected static function addStudentForAppointment() : User {
        $user = User::factory()->create();
        $user->assignRole('teacher');

        $plan = Plan::factory()->create();
        StudentOptions::factory()->create(['user_id' => $user->id])->toArray();
        Subscription::factory()->create(['user_id' => $user->id,'plan_id' => $plan->id]);

        return $user;
    }

    protected static function addTeacherAvailableForBooking() : User {
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');

        UserDevice::factory()->create(['user_id' => $teacher->id]);
        TeacherOptions::factory()->create(['user_id' => $teacher->id]);
        Availability::factory()->create(['teacher_id' => $teacher->id, 'day' => 'monday']);

        return $teacher;
    }

    protected static function mockSocialUser(User $user) : \Laravel\Socialite\Two\User
    {
        $socialUser = Mockery::mock('Laravel\Socialite\Two\User');

        $socialUser->shouldReceive('getId')->andReturn(fake()->randomDigit());
        $socialUser->shouldReceive('getName')->andReturn(fake()->firstName);
        $socialUser->shouldReceive('getEmail')->andReturn($user->email);
        $socialUser->shouldReceive('getAvatar')->andReturn(fake()->imageUrl());

        return $socialUser;
    }

    protected static function mockSocialite($socialUser, $provider) : void {
        Socialite::shouldReceive('driver')
            ->once()
            ->with($provider)
            ->andReturnSelf();

        Socialite::shouldReceive('stateless')
            ->once()
            ->andReturnSelf();

        Socialite::shouldReceive('user')
            ->once()
            ->andReturn($socialUser);
    }


}
