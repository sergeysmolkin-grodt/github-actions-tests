<?php

namespace Tests\Integration\API\Controllers;

use App\Jobs\Cron\ProcessStudentAutoSchedule;
use App\Models\StudentAutoScheduleTime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class AutoScheduleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected User $teacher;
    protected User $student;

    protected function setUp() : void
    {
        parent::setUp();
        Event::fake();
        Artisan::call('db:seed');

        $this->teacher = User::factory()->create()->assignRole('teacher');
        $this->student = self::addStudentForAppointment();
        Auth::login($this->student);
    }

    #[Test]
    public function testStoreAutoScheduleTimeSuccessfully()
    {
        $mock = \Mockery::mock(ProcessStudentAutoSchedule::class);
        $mock->shouldReceive('dispatch')->once();
        $this->app->instance(ProcessStudentAutoSchedule::class, $mock);

        $response = $this->postAutoScheduleTimeAsUser($data = $this->getAutoScheduleData());

        foreach ($this->getAutoScheduleData()['timeDetails'] as $timeDetail) {
            self::assertDatabaseHas('student_auto_schedule_times',[
                'teacher_id'     => $timeDetail['teacherId'],
                'day'            => $timeDetail['day'],
                'time'           => $timeDetail['time'],
            ]);
        }

        self::assertDatabaseHas('student_auto_schedule_times',['student_id' => $data['userId']]);
        self::assertDatabaseHas('student_auto_schedule_times',['scheduled_date' => $data['autoScheduleDate']]);

        $response->assertJson(['message' => 'Auto schedule set successfully']);
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testCantStoreAutoScheduleIfSlotsAreReserved()
    {
        $reservedAutoSchedule = StudentAutoScheduleTime::factory()->create([
            'day' => 'monday',
            'time' => '12:00',
            'teacher_id' => $this->teacher->id,
            'scheduled_date' => '2023-12-12'
        ]);

        $response = $this->postAutoScheduleTimeAsUser($this->getAutoScheduleData());

        $response->assertJson(['error' => 'These slots are reserved by other student. Please select other slots.']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

    }

    #[Test]
    public function testNonAuthUserCannotStoreAutoSchedule()
    {
        Auth::logout();
        $response = $this->postJson("api/auto-schedule-slots",$this->getAutoScheduleData());

        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    #[Test]
    public function testUpdateAutoScheduleTimeSuccessfully()
    {
        $autoSchedule = StudentAutoScheduleTime::factory()->create([
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'scheduled_date' => now()->addDays(10)->format('Y-m-d'),
            'day' => 'monday',
            'time' => '12:00'
        ]);

        $response = $this->actingAs($this->student)->putJson("api/auto-schedule-slots/{$this->student->id}",$data = $this->getAutoScheduleData());

        foreach ($this->getAutoScheduleData()['timeDetails'] as $timeDetail) {
            self::assertDatabaseHas('student_auto_schedule_times',[
                'teacher_id'     => $timeDetail['teacherId'],
                'day'            => $timeDetail['day'],
                'time'           => $timeDetail['time'],
            ]);
        }

        self::assertDatabaseHas('student_auto_schedule_times',['student_id' => $data['userId']]);
        self::assertDatabaseHas('student_auto_schedule_times',['scheduled_date' => $data['autoScheduleDate']]);

        $response->assertJson(['message' => 'Auto schedule update successfully']);
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testNonAuthUserCannotUpdateAutoScheduleTime()
    {
        Auth::logout();
        $autoSchedule = StudentAutoScheduleTime::factory()->create([
            'student_id' => $this->student->id,
        ]);

        $response = $this->putJson("api/auto-schedule-slots/{$this->student->id}",$this->getAutoScheduleData());

        $response->assertJson(['message' => 'Unauthenticated.']);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testDestroyAutoScheduleSuccessfully()
    {
        $autoSchedule = StudentAutoScheduleTime::factory()->create(['student_id' => $this->student->id]);

        $response = $this->actingAs($this->student)->deleteJson("api/auto-schedule-slots/{$this->student->id}");

        $response->assertJsonFragment(['Auto schedule removed successfully.']);
        self::assertDatabaseMissing('student_auto_schedule_times',$autoSchedule->toArray());
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testNonAuthUserCannotDestroyAutoSchedule()
    {
        Auth::logout();

        $autoSchedule = StudentAutoScheduleTime::factory()->create(['student_id' => $this->student->id]);

        $response = $this->deleteJson("api/auto-schedule-slots/{$this->student->id}");

        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }

    private function postAutoScheduleTimeAsUser(array $data, array $headers = []): TestResponse
    {
        return $this->actingAs($this->student)
            ->postJson(
                uri: "api/auto-schedule-slots",
                data: $data,
                headers: array_merge([
                    'Accept-Language' => 'en',
                    'Accept' => 'application/json',
                    'Content-Type: application/json', $headers
                ])
            );
    }
}
