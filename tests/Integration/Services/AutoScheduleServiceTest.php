<?php

namespace Tests\Integration\Services;

use App\Exceptions\CouldNotSetAutoScheduleTime;
use App\Models\StudentAutoScheduleTime;
use App\Models\StudentAutoScheduleTimeLog;
use App\Models\User;
use App\Repositories\AutoScheduleRepository;
use App\Repositories\UserRepository;
use App\Services\AutoScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AutoScheduleServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AutoScheduleService $autoScheduleService;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $this->teacher = User::factory()->create()->assignRole('teacher');
        $this->student = User::factory()->create()->assignRole('student');

        $this->autoScheduleService = new AutoScheduleService(
            new AutoScheduleRepository(new StudentAutoScheduleTime(), new StudentAutoScheduleTimeLog()),
            $this->createMock(UserRepository::class),
        );
    }

    #[Test]
    public function testNoIntersectionWithOtherSlots()
    {
        $result = $this->autoScheduleService->checkAvailabilityAutoScheduleTimeSlots($this->getAutoScheduleData($this->teacher,$this->student)['timeDetails']);

        $this->assertNull($result);
    }

    #[Test]
    public function testIntersectionWithOtherSlots()
    {

        $reservedAutoSchedule = StudentAutoScheduleTime::factory()->create([
            'day' => 'monday',
            'time' => '12:00',
            'teacher_id' => $this->teacher->id,
            'student_id' => $this->student->id,
            'scheduled_date' => '2023-12-12'
        ]);

        $result = $this->autoScheduleService->checkAvailabilityAutoScheduleTimeSlots($this->getAutoScheduleData($this->teacher,$this->student)['timeDetails']);

        $this->assertEquals(__('These slots are reserved by other student. Please select other slots.'), $result);

        $this->assertDatabaseHas('student_auto_schedule_times',$reservedAutoSchedule->toArray());
    }

    #[Test]
    public function testEmptyTimeSlotsReturnsNull()
    {
        $result = $this->autoScheduleService->checkAvailabilityAutoScheduleTimeSlots([]);

        $this->assertNull($result);
    }

    /**
     * @throws CouldNotSetAutoScheduleTime
     */
    #[Test]
    public function testSetAutoScheduleTimeWithAvailableSlots()
    {
        Auth::login($this->student);

        $this->autoScheduleService->setAutoScheduleTime($data = $this->getAutoScheduleData(), $this->student->id);

        foreach ($data['timeDetails'] as $timeDetail) {
            self::assertDatabaseHas('student_auto_schedule_times',[
                'teacher_id'     => $timeDetail['teacherId'],
                'day'            => $timeDetail['day'],
                'time'           => $timeDetail['time'],
            ]);
        }

        $this->assertDatabaseHas('student_auto_schedule_times', [
            'student_id' => $data['userId'],
            'scheduled_date' => $data['autoScheduleDate']
        ]);
    }

    #[Test]
    public function testLogAndRemoveAutoScheduleTime()
    {
        $this->assertDatabaseMissing('student_auto_schedule_times', ['student_id' => $this->student->id]);

        $this->autoScheduleService->logAndRemoveAutoScheduleTime($this->student->id);

        Log::shouldReceive('error')
            ->with("An error occurred during logging auto schedule time: Update Auto Schedule")
            ->andReturn(null);

        $this->assertDatabaseMissing('student_auto_schedule_times', ['student_id' => $this->student->id]);

    }

    #[Test]
    public function testResetAutoScheduleBookingExpiry()
    {
        $result = $this->autoScheduleService->resetAutoScheduleBookingExpiry($this->teacher->id, $this->student->id);

        $this->assertNull($result);

        $this->assertDatabaseMissing('student_auto_schedule_times', [
            'teacher_id' => $this->teacher->id,
            'student_id' => $this->teacher->id,
            'auto_schedule_booking_expiry' => null
        ]);
    }

}
