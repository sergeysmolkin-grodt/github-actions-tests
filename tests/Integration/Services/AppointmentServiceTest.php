<?php

namespace Tests\Integration\Services;

use App\DataTransferObjects\AppointmentData;
use App\DataTransferObjects\AvailabilityData;
use App\Models\Appointment;
use App\Models\AppointmentDetails;
use App\Models\Availability;
use App\Models\AvailabilityException;
use App\Models\Plan;
use App\Models\Reminder;
use App\Models\StudentOptions;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserDetails;
use App\Repositories\AppointmentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use App\Services\AppointmentService;
use App\Services\AppointmentServicesAggregator;
use DateInterval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionClass;
use Tests\TestCase;


final class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AppointmentService $appointmentService;
    private User $teacher;
    private User $student;

    /**
     * @throws Exception
     */
    #[Before]
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $userRepository = new UserRepository(new User());
        $appointmentRepository = $this->createMock(AppointmentRepository::class);
        $subscriptionRepository = $this->createMock(SubscriptionRepository::class);
        $appointmentServiceAggregator = $this->createMock(AppointmentServicesAggregator::class);
        $teacherRepository = $this->createMock(TeacherRepository::class);


        $this->appointmentService = new AppointmentService(
            $appointmentServiceAggregator,
            $userRepository,
            $teacherRepository,
            $appointmentRepository,
            $subscriptionRepository
        );

        $this->student = User::factory()->create()->assignRole('student');
        $this->teacher = User::factory()->create()->assignRole('teacher');
    }

    #[Test]
    public function testNotAvailableToBookIfTeacherIsOnHoliday()
    {
        $exception = AvailabilityException::create([
            'teacher_id' => $this->teacher->id,
            'date' => now()->toDateString(),
            'type' => 'HOLIDAY',
        ]);

        $result = $this->appointmentService->checkTeacherAvailability($this->teacher->id, now()->toDateString(), '09:00:00');

        $this->assertEquals(__('Teacher is on holiday on this day please try another date'), $result);
        $this->assertEquals('HOLIDAY', $exception->type);
    }

    #[Test]
    public function testTeacherIsNotAvailableOnCertainDate()
    {
        $availability = Availability::create([
            'teacher_id' => $this->teacher->id,
            'day' => 'saturday',
            'is_available' => 0,
            'from_time' => $from = fake()->dateTime(),
            'to_time' => $from->add(new DateInterval('PT1H')),
        ]);

        $result = $this->appointmentService->checkTeacherAvailability($this->teacher->id, now()->toDateString(), '09:00:00');

        $this->assertEquals(__('Teacher is not available on this date'), $result);
        $this->assertEquals(0, $availability->is_available);
    }

    #[Test]
    public function testNotAvailableIfTeacherHasAnotherAppointment()
    {
        Availability::factory()->create([
            'teacher_id' => $this->teacher->id,
            'day' => strtolower(now()->format('l')),
        ]);

        $from = fake()->dateTime()->format('H:i:s');

        Appointment::factory()->create([
            'teacher_id' => $this->teacher->id,
            'date' => now()->toDateString(),
            'from' => $from,
        ]);

        $result = $this->appointmentService->checkTeacherAvailability($this->teacher->id, now()->toDateString(), $from);

        $this->assertEquals(__('The teacher has an appointment for this time with another student'), $result);
    }

    #[Test]
    public function testTeacherIsAvailable()
    {
        Availability::factory()->create([
            'teacher_id' => $this->teacher->id,
            'day' => $day = strtolower(now()->format('l')),
            'is_available' => 1,
        ]);

        $result = $this->appointmentService->checkTeacherAvailability($this->teacher->id, now()->toDateString(), '09:00:00');

        $this->assertNull($result);

        $this->assertEquals($day, implode(',', $this->teacher->availability->pluck('day')->toArray()));

    }

    #[Test]
    public function testCreateAppointmentSuccessfully()
    {
        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, now()->toDateString(), '09:00:00', false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->createAppointment();

        $this->assertInstanceOf(Appointment::class, $result);
        $this->assertNotEmpty($result->id);
        $this->assertEquals('PENDING', $result->status);
        $this->assertEquals($validAppointmentData->date, $result->date);
        $this->assertDatabaseHas('appointments',[
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'date' => $validAppointmentData->date,
            'from' => $validAppointmentData->startTime,
            'status' => 'PENDING',
        ]);
    }

    #[Test]
    public function testCouldNotCreateAppointmentWithInvalidUserId()
    {
        $appointmentData = new AppointmentData(
            999,
            $this->teacher->id,
            now()->toDateString(),
            '09:00:00',
            false
        );

        $this->stubAppointmentData($appointmentData);

        $result = $this->appointmentService->createAppointment();
        $this->assertStringContainsString('Database error',$result);

    }

    #[Test]
    public function testCreateAppointmentDetailsSuccessfully()
    {
        $appointment = Appointment::factory()->create([
            'teacher_id' => $this->teacher->id,
            'student_id' => $this->student->id
        ]);

        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, now()->toDateString(), '09:00:00', false);
        $this->stubAppointmentData($validAppointmentData);
        $zoomMeetingData = ['startDate' => fake()->date(), 'password' => fake()->password(8)];

        $result = $this->appointmentService->createAppointmentDetails($appointment, $zoomMeetingData, 'unlimited');

        $this->assertInstanceOf(AppointmentDetails::class, $result);
        $this->assertDatabaseHas('appointment_details', [
            'appointment_id' => $appointment->id
        ]);
    }

    #[Test]
    public function testUpdateStudentOptionsForTrialSession()
    {
        $studentOptions = StudentOptions::factory()->create(['count_trial_sessions' => 5, 'user_id' => $this->student->id]);

        $result = $this->appointmentService->updateStudentOptions($this->student, 'trial_session');

        $this->assertEquals(1, $result);
        $updatedStudentOptions = StudentOptions::find($studentOptions->id);
        $this->assertEquals(4, $updatedStudentOptions->count_trial_sessions);
    }

    #[Test]
    public function testUpdateRecurringGiftSession()
    {
        $studentOptions = StudentOptions::factory()->create(['count_recurring_gift_sessions' => 5, 'user_id' => $this->student->id]);

        $result = $this->appointmentService->updateStudentOptions($this->student, 'count_recurring_gift_sessions');

        $this->assertEquals(1, $result);
        $updatedStudentOptions = StudentOptions::find($studentOptions->id);
        $this->assertEquals(5, $updatedStudentOptions->count_recurring_gift_sessions);

    }

    #[Test]
    public function testBasicCheckThatDateInPast()
    {
        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, '2020-10-10', '09:00:00', false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->basicChecks();

        $this->assertEquals('This date has already past, choose another', $result);
    }

    #[Test]
    public function testBasicCheckNonExistentStudent()
    {
        $validAppointmentData = new AppointmentData($id = rand(), $this->teacher->id, now()->toDateString(), now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->basicChecks();

        $this->assertEquals("Student with this ID $id does not exist in the system or not active", $result);
    }

    #[Test]
    public function testBasicCheckNonExistentTeacher()
    {
        $validAppointmentData = new AppointmentData($this->student->id,  $id = rand(), now()->toDateString(), now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->basicChecks();

        $this->assertEquals("Teacher with this ID $id does not exist in the system or not active", $result);
    }

    #[Test]
    public function testBasicCheckTeacherCannotBeBooked()
    {
        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, now()->toDateString(), now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->basicChecks();

        $this->assertEquals("We are updating this teacher's schedule, therefore, we are unable to schedule for you a lesson at this time. Please try again within a few hours :) Thank you for understanding.", $result);
    }

    #[Test]
    public function testValidateSubscriptionThatSessionIsReached()
    {
        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, now()->toDateString(), now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);
        $plan = Plan::factory()->create();

        $subscription = Subscription::create([
            'plan_id' => $plan->id,
            'user_id' => $this->student->id,
            'start_date' => now()->subDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'type' => 'regular',
        ]);

        $result = $this->appointmentService->validateSubscription($subscription);

        $this->assertEquals('The session limit for this subscription has been reached', $result);
    }

    #[Test]
    public function testValidateSubscriptionOutsideValidDate()
    {

        $validAppointmentData = new AppointmentData($this->student->id, $this->teacher->id, '2023-11-15', now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);

        $subscription = Subscription::factory()->create([
            'start_date' => '2023-10-01',
            'end_date' => '2023-11-01',
            'plan_id' => 1,
            'user_id' => $this->student->id,
        ]);

        $result = $this->appointmentService->validateSubscription($subscription);

        $this->assertEquals('Appointment date is not within the subscription time', $result);
    }

    #[Test]
    public function testGetUnlimitedFreeSessionTypeForStudent()
    {
        $this->student->studentOptions()->create(['has_free_unlimited_sessions' => true]);

        $teacher = User::factory()->create()->assignRole('teacher');

        $validAppointmentData = new AppointmentData($this->student->id, $teacher->id, '2023-11-15', now()->addMinutes()->format('H:i:s'), false);
        $this->stubAppointmentData($validAppointmentData);

        $result = $this->appointmentService->getAppointmentTypeForStudent($this->student);

        $this->assertEquals('unlimited_free_session', $result);
    }

    #[Test]
    public function testGetAppointmentEmailSubjectWithCountry()
    {
        $user = User::factory()->create();
        UserDetails::create(['user_id' => $user->id,'country_code' => '+34']);

        $appointment = Appointment::factory()->create([
            'date' => '2023-10-15',
            'from' => '10:00',
            'to' => '11:00',
        ]);

        $subject = $this->appointmentService->getAppointmentEmailSubject($user, $appointment);

        $expectedSubject = "New free session scheduled from Spain by $user->firstname $user->lastname to 15/10/2023 and 10:00-11:00";
        $this->assertEquals($expectedSubject, $subject);
    }

    #[Test]
    public function testGetAppointmentEmailSubjectWithoutCountry()
    {
        $user = User::factory()->create([]);
        UserDetails::create(['user_id' => $user->id,'country_code' => 'xx']);

        $appointment = Appointment::factory()->create([
            'date' => '2023-10-15',
            'from' => '10:00',
            'to' => '11:00',
        ]);

        $subject = $this->appointmentService->getAppointmentEmailSubject($user, $appointment);

        $expectedSubject = "New free session scheduled by $user->firstname $user->lastname to 15/10/2023 and 10:00-11:00";
        $this->assertEquals($expectedSubject, $subject);
    }

    #[Test]
    public function testSetAppointmentRemindersSuccessfully()
    {
        $appointment = Appointment::factory()->create([
            'date' => '2023-10-15',
            'from' => '10:00',
            'to' => '11:00',
        ]);

        $result = $this->appointmentService->setAppointmentReminders($appointment);

        $this->assertNull($result);
    }

    #[Test]
    public function testCreateReminderSuccessfully()
    {
        $appointment = Appointment::factory()->create([
            'date' => '2023-10-15',
            'from' => '10:00',
            'to' => '11:00',
        ]);

        $reminder = $this->appointmentService->createReminder(
            appointment: $appointment,
            type: fake()->title,
            messageType: fake()->word,
            note: fake()->title,
            dateTime: fake()->dateTime->format('Y-m-d H:i:s')
        );

        $this->assertInstanceOf(Reminder::class, $reminder);
    }

    #[Test]
    public function testGetMonthCompletedSessionsForTeacher()
    {
        Appointment::factory()->create([
            'teacher_id' => $this->teacher->id,
            'status' => 'COMPLETED',
            'date' => now()->subMonths(1)
        ]);

        Appointment::factory()->create([
            'teacher_id' => $this->teacher->id,
            'status' => 'COMPLETED',
            'date' => now()->subMonths(2)
        ]);

        $result = $this->appointmentService->getMonthCompletedSessionsForTeacher($this->teacher->id);

        $this->assertCount(12, $result['chartLabel']);
        $this->assertCount(12, $result['chartData']);

        $lastMonthIndex = 11;
        $this->assertEquals(0, $result['chartData'][$lastMonthIndex]);

        $twoMonthsAgoIndex = 10;
        $this->assertEquals((string)1, $result['chartData'][$twoMonthsAgoIndex]);

    }

    #[Test]
    public function testCancelAutoScheduledAppointments()
    {
        $student = User::factory()->create()->assignRole('student');
        $result = $this->appointmentService->cancelAutoScheduledAppointments($student->id);

        $this->assertNull($result);

    }

    #[Test]
    public function testCheckAppointmentIsCompatibleWithAppointment()
    {
        $teacher = User::factory()->create()->assignRole('teacher');
        $appointment = Appointment::factory()->create(['from' => '10:00', 'to' => '11:00']);
        $availability = new AvailabilityData($teacher->id,'09:00','12:00',null, null);

        $result = $this->appointmentService->checkAppointmentCompatibility($appointment, $availability);
        $this->assertTrue($result);
    }

    #[Test]
    public function testAppointmentIsIncompatibleDueToBreak()
    {

        $appointment = new Appointment(['from' => '10:00', 'to' => '11:00']);
        $availability = new AvailabilityData($this->teacher->id,'09:00',  '12:00',  '10:30',  '10:45');

        $result = $this->appointmentService->checkAppointmentCompatibility($appointment, $availability);
        $this->assertFalse($result);
    }

    public function stubAppointmentData($appointmentData): \ReflectionProperty
    {
        $reflection = new ReflectionClass(AppointmentService::class);
        $appointmentDataProperty = $reflection->getProperty('appointmentData');
        $appointmentDataProperty->setAccessible(true);
        $appointmentDataProperty->setValue($this->appointmentService, $appointmentData);

        return $appointmentDataProperty;
    }

}


