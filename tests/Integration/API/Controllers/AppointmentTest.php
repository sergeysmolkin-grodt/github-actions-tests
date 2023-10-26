<?php

namespace Tests\Integration\API\Controllers;

use App\Mail\Appointments\SessionScheduled;
use App\Models\Appointment;
use App\Models\AppointmentDetails;
use App\Models\AvailabilityException;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $teacher;

    #[After]
    protected function setUp() : void
    {
        parent::setUp();

        Artisan::call('db:seed');

        $this->user = TestCase::addStudentForAppointment();
        $this->teacher = TestCase::addTeacherAvailableForBooking();
    }

    #[Test]
    public function testUserWhenStoresDoesntPassTheDateIsAlreadyPastCheck()
    {
        $appointment = array_merge(
            self::getAppointmentData($this->teacher,$this->user),[
                'date' => '2020-12-30',
        ]);

        Auth::login($this->user);

        $response = $this->postAppointmentAsUser($appointment);

        $response->assertJson([
            'error' => 'This date has already past, choose another'
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    #[Test]
    public function testUserWhenStoresDoesntPassTeacherExistenceInTheSystemCheck()
    {
        $appointment = array_merge(
            TestCase::getAppointmentData($this->teacher,$this->user),[
            'teacherId' => rand()
        ]);

        $teacherId  = $appointment['teacherId'];

        $response = $this->postAppointmentAsUser($appointment);

        $response->assertJson([
            'error' => "Teacher with this ID $teacherId does not exist in the system or not active"
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

    }

    #[Test]
    public function testUserWhenStoresDoesntPassThatTeacherCanBeBookedCheck()
    {
        $teacherNoOptions = User::factory()->create()->assignRole('teacher');

        $appointment = array_merge(
            TestCase::getAppointmentData($this->teacher,$this->user),[
            'teacherId' => $teacherNoOptions->id
        ]);

        $response = $this->postAppointmentAsUser($appointment);

        $response->assertJsonFragment([
            "error" => "We are updating this teacher's schedule, therefore, we are unable to schedule for you a lesson at this time. Please try again within a few hours :) Thank you for understanding."
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

    }

    #[Test]
    public function testCantStoreAppointmentIfTeacherIsNotAvailableOnCertainDate() {

        $appointment = TestCase::getAppointmentData($this->teacher,$this->user);

        $response = $this->postAppointmentAsUser(array_merge($appointment, [
            'date' => now()->addDay()->format('Y-m-d')
        ]));

        $response->assertJson([
            "error" => "Teacher is not available on this date"
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

    }

    #[Test]
    public function testCantStoreAppointmentWhenTeacherIsOnHoliday() {

        AvailabilityException::create([
            'teacher_id' => $this->teacher->id,
            'date' => '2023-12-30',
            'from_time' => '12:30',
            'to_time' => '13:00',
            'type' => 'HOLIDAY'
        ]);

        $appointment = TestCase::getAppointmentData($this->teacher,$this->user);

        $response = $this->postAppointmentAsUser($appointment);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response->assertJson([
            "error" => "Teacher is on holiday on this day please try another date"
        ]);

    }

    #[Test]
    public function testStoreAppointmentWithAllTheNeedsSuccessfully() {
        Mail::fake();

        $appointment = array_merge(
            TestCase::getAppointmentData($this->teacher,$this->user), [
            'date' => '2024-12-28',

        ]);

        $response = $this->postAppointmentAsUser($appointment);

        $response->assertJson([
            'message' => __('Your session booked successfully'),
            'appointmentId' => $appointment['id']
        ]);

        self::assertDatabaseHas('appointments',[
            'id' => $appointment['id'],
            'teacher_id' => (int) $appointment['teacherId'],
            'student_id' => $appointment['student_id'],
            'date' => $appointment['date'],
            'from' => $appointment['startTime'] . ':00'
        ]);

        self::assertDatabaseHas('appointment_details',[
           'appointment_id' => $appointment['id']
        ]);


        Mail::assertSent(SessionScheduled::class, function ($mail) use ($appointment) {
            return $mail->hasTo(config('app.admin_email')) &&
                $mail->student->id === $this->user->id &&
                $mail->appointment->id === $appointment['id'];
        });

        self::assertIsString(implode(',',AppointmentDetails::where('appointment_id', $appointment['id'])->pluck('zoom_data')->toArray()));
        self::assertStringContainsString("start_time",implode(',',AppointmentDetails::where('appointment_id', $appointment['id'])->pluck('zoom_data')->toArray()));

        self::assertDatabaseHas('reminders',[
            'model_id' => $appointment['id']
        ]);

        $reminder = Reminder::where('model_id', $appointment['id'])->get();

        $this->assertCount(count(config('reminders.reminders.appointment')), $reminder);

        self::assertEquals($appointment['id'],$response->json('appointmentId'));

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testStoreAppointmentWithUnlimitedFreeSessionsAppointmentType()
    {
        Mail::fake();

        $appointment = array_merge(
            self::getAppointmentData($this->teacher,$this->user), [
                'date' => '2024-12-28'
            ]);

        $response = $this->postAppointmentAsUser($appointment);

        self::assertEquals(1, implode(',',$this->user->studentOptions()->pluck('has_free_unlimited_sessions')->toArray()));

        self::assertDatabaseHas('student_options',[
            'user_id' => $this->user->id,
            'has_free_unlimited_sessions' => 1
        ]);

        $response->assertJson([
            'message' => __('Your session booked successfully'),
            'appointmentId' => $appointment['id']
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    #[Test]
    public function testDeleteAppointmentSuccessfully()
    {
        $appointment = Appointment::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson("api/appointments/{$appointment->id}");

        $response->assertExactJson([
            'message' => 'Your session cancelled successfully',
            'id' => $appointment->id
        ]);

        self::assertDatabaseMissing('appointments',$appointment->toArray());

        $response->assertStatus(Response::HTTP_OK);
    }

    private function postAppointmentAsUser(array $data, array $headers = []): TestResponse
    {
        return $this->actingAs($this->user)
            ->postJson(
                uri: "api/appointments",
                data: $data,
                headers: array_merge(['Accept-Language' => 'en'], $headers)
            );
    }


}


