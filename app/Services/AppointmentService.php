<?php

namespace App\Services;

use App\DataTransferObjects\AvailabilityData;
use App\Exceptions\CouldNotBookAppointment;
use App\Exceptions\CouldNotCancelAutoScheduledAppointments;
use App\Exceptions\CouldNotCreateZoomMeeting;
use App\Exceptions\CouldNotDeleteZoomMeeting;
use App\Exceptions\CouldNotSendPushNotification;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\AppointmentRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Mail\Appointments\SessionScheduled;
use App\Models\Appointment;
use App\Models\AppointmentDetails;
use App\Models\Availability;
use App\Models\AvailabilityException;
use App\Models\Reminder;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\DateTimeTrait;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\DataTransferObjects\AppointmentData;
use Illuminate\Support\Facades\DB;

class AppointmentService
{

    use DateTimeTrait;

    private AppointmentData $appointmentData;

    public function __construct(
        protected AppointmentServicesAggregator $appointmentServicesAggregator,
        protected UserRepositoryInterface $userRepository,
        protected AppointmentRepositoryInterface $appointmentRepository,
        protected SubscriptionRepositoryInterface $subscriptionRepository
    ) {}


    public function checkTeacherAvailability(int $teacherId, string $appointmentDate, string $appointmentTime): null|string
    {
        if (! empty(AvailabilityException::where('teacher_id', $teacherId)
                                         ->whereDate('date', $appointmentDate)
                                         ->where('type', 'HOLIDAY')
                                         ->first()
        )) {
            return __('Teacher is on holiday on this day please try another date');
        }

        $appointmentDayName = strtolower($this->getDayNameFromDate($appointmentDate));

        if (empty(Availability::where('teacher_id', $teacherId)
                                ->where('day', $appointmentDayName)
                                ->where('is_available', 1)
                                ->first()
        )) {
            return __('Teacher is not available on this date');
        }

        if (! empty(Appointment::where('teacher_id', $teacherId)
                                 ->whereDate('date', $appointmentDate)
                                 ->whereTime('from', $appointmentTime)
                                 ->first()
        )) {
            return __('The teacher has an appointment for this time with another student');
        }

        return null;
    }

    public function createAppointment(): Appointment|string
    {
        $appointmentStatuses = array_values(config('app.appointment_statuses'));
        try {
            $appointment = Appointment::create([
                'student_id' => $this->appointmentData->userId,
                'teacher_id' => $this->appointmentData->teacherId,
                'date' => $this->appointmentData->date,
                'from' => $this->getCarbonInstance($this->appointmentData->startTime)->toTimeString(),
                'to' => $this->getCarbonInstance($this->appointmentData->startTime)->addMinutes(config('app.lesson_min_duration'))->toTimeString(),
                'status' => reset($appointmentStatuses)
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                return $error . "\n";
            }
        } catch (QueryException $e) {
            // Handle database errors
            return "Database error: " . $e->getMessage();
        }

        return $appointment;
    }

    public function createAppointmentDetails(Appointment $appointment, array $zoomMeetingData, string $appointmentType): AppointmentDetails|string
    {
        $student = User::find($appointment->student_id);

        try {
            $appointmentDetails = AppointmentDetails::create([
                'appointment_id' => $appointment->id,
                'auto_complete_time' => $this->addMinutesToDateTime("{$appointment->date} {$appointment->from}", 60),
                'is_summary_session' => 0,
                'zoom_data' => serialize($zoomMeetingData),
                'is_free_unlimited_session' => $appointmentType == config('subscription_types.types.unlimited_free_session') ? 1 : 0,
                'is_trial_session' => $appointmentType == config('subscription_types.types.trial_session') ? 1 : 0,
                'subscription_id' => $appointmentType == config('subscription_types.types.regular_package_session') ? $student->studentSubscription->id : null,
                'is_company_session' => $appointmentType == config('subscription_types.types.company_session') ? 1 : 0,
                'is_company_recurring_session' => $appointmentType == config('subscription_types.types.recurring_company_session') ? 1 : 0,
                'is_gift_session' => $appointmentType == config('subscription_types.types.gift_session') ? 1 : 0,
                'is_gift_recurring_session' => $appointmentType == config('subscription_types.types.gift_recurring_session') ? 1 : 0,
                'is_auto_schedule_session' => $this->appointmentData->isAutoScheduleSession
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                return $error . "\n";
            }
        } catch (QueryException $e) {
            // Handle database errors
            return "Database error: " . $e->getMessage();
        }

        return $appointmentDetails;
    }

    public function updateStudentOptions(User $student, string  $appointmentType): int
    {
        $studentOptions = $student->studentOptions;
        $values = [];

        switch ($appointmentType) {
            case 'trial_session':
                $values['count_trial_sessions'] = $studentOptions->count_trial_sessions - 1;
                break;
            case 'regular_package_session':
                $subscription = $student->studentSubscription;
                break;
            case 'company_session':
                $values['count_company_sessions'] = $studentOptions->count_company_sessions - 1;
                break;
        // ToDo: update count of 'company_recurring_session' if need it:
            case 'gift_session':
                $values['count_gift_sessions'] = $studentOptions->count_gift_sessions - 1;
                break;
            case 'gift_recurring_session':
                $values['count__recurring_gift_sessions'] = $studentOptions->count__recurring_gift_sessions - 1;
                break;
        }

        return $studentOptions->update($values);
    }

    public function basicChecks(): string|User
    {
        // Check if date is not past
        if ($this->getCarbonInstance("{$this->appointmentData->date} {$this->appointmentData->startTime}")->isPast()) {
            return __('This date has already past, choose another');
        }

        // Check if exists active student
        if (empty($user = $this->userRepository->getActiveUserById($this->appointmentData->userId))) {
            return __('Student with this ID '. $this->appointmentData->userId .' does not exist in the system or not active');
        }

        // Check if exists active teacher
        if (empty($this->userRepository->getActiveUserById($this->appointmentData->teacherId))) {
            return __('Teacher with this ID '. $this->appointmentData->teacherId .' does not exist in the system or not active');
        }

        // Check if Teacher can be booked
        if (! $this->userRepository->teacherCanBeBooked($this->appointmentData->teacherId)) {
            return __("We are updating this teacher's schedule, therefore, we are unable to schedule for you a lesson at this time. Please try again within a few hours :) Thank you for understanding.");
        }

        return $user;
    }

    public function validateSubscription(Subscription $subscription): null|string
    {
        $endDate = $this->getCarbonInstance($subscription->end_date);
        $appointmentSubscription = $subscription;

        if ($this->appointmentData->isAutoScheduleSession) {
            $upcomingSubscription = $this->subscriptionRepository->getUpcommingSubscription($subscription);
            $endDate = $this->getCarbonInstance($upcomingSubscription->end_date);

            if ($this->getCarbonInstance($this->appointmentData->date)->between($this->getCarbonInstance($upcomingSubscription->start_date), $upcomingSubscription->end_date)) {
                $appointmentSubscription = $upcomingSubscription;
            }
        }

        if (! $this->getCarbonInstance($this->appointmentData->date)->between($this->getCarbonInstance($subscription->start_date), $endDate)) {
            return __('Appointment date is not within the subscription time');
        }

        // Сheck the number of created sessions within subscription
        $countSubscriptionAppointments = $this->appointmentRepository->getSubscriptionAppointments($appointmentSubscription);
        if ($appointmentSubscription->plan->count_session <= $countSubscriptionAppointments->count()) {
            return __('The session limit for this subscription has been reached');
        }

        return null;
    }

    public function getAppointmentTypeForStudent(User $student): string|CouldNotBookAppointment
    {
        $studentOptions = $student->studentOptions;

        // Free unlimited sessions
        if ($studentOptions->has_free_unlimited_sessions) {
            return 'unlimited_free_session';
        }

        // Trial first free session
        if ($studentOptions->count_trial_sessions > 0) {
            if (! $this->userRepository->teacherAllowsTrial($this->appointmentData->teacherId)) {
                throw new CouldNotBookAppointment(__('This teacher is not for trial lesson! Please try to book with another teacher.'));
            }
            return 'trial_session';
        }

        // Subscription paid session
        if (! empty($subscription = $student->studentSubscription)) {
            if ( ($validationSubscriptionResponse = $this->validateSubscription($subscription)) !== null) {
                throw new CouldNotBookAppointment($validationSubscriptionResponse);
            }
            return 'regular_package_session';
        }

        // Company session
        if ($studentOptions->has_free_limited_sessions_for_company && $studentOptions->count_free_sessions_for_company > 0) {
            return 'company_session';
        }

        // Company recurring session
        if ($studentOptions->has_free_recurring_sessions_for_company) {
            return 'recurring_company_session';
        }

        // Gift session
        if ($studentOptions->has_gift_sessions && $studentOptions->count_gift_sessions > 0) {
            return 'gift_session';
        }

        // Gift recurring sessions
        if ($studentOptions->has_gift_recurring_sessions && $studentOptions->count_gift_recurring_sessions > 0) {
            return 'gift_recurring_session';
        }

        throw new CouldNotBookAppointment(__('You need to purchase membership in order to book session'));
    }

    public function createZoomMeetingLink(): string|array
    {
        try {
            if (false){
                $teacherZoomUserId = User::findOrFail($this->appointmentData->teacherId)->teacherOptions->zoom_user_id;

                $zoomData = $this->appointmentServicesAggregator->getZoomService()->createMeeting(
                    config('app.lesson_default_topic'),
                    $this->appointmentData->startTime,
                    config('app.lesson_min_duration'),
                    $teacherZoomUserId,
                    $this->appointmentData->teacherId
                );
            }
        } catch(CouldNotCreateZoomMeeting $e) {
            return $e->getMessage();
        }

        return $zoomData;
    }

    public function sendPushNotificationsToTeacher(User $student, int $appointmentId, int $teacherId): ?string
    {
        $teacher = $this->userRepository->getActiveUserById($teacherId);
        try {
            $title = __('New Session');
            $message = __('You got a new session from ') . "{$student->firstname} {$student->lastname}";
            $payload = [
                'appointmentId' => $appointmentId,
                'notificationType' => config('app.notifications_types.appointment')
            ];
            $deviceTokens = $teacher->userDevices->pluck('device_token')->toArray();

            $this->appointmentServicesAggregator->getFCMService()->sendPushNotifications(
                deviceTokens: $deviceTokens,
                title: $title,
                body: $message,
                payload: $payload,
                userId: $teacherId
            );

        } catch(CouldNotSendPushNotification $e) {
            return $e->getMessage();
        }

        return null;
    }

    public function getAppointmentEmailSubject(User $user, Appointment $appointment): string
    {
        match($user->country_code) {
            '+34' => $country = 'Spain',
            '+49' => $country = 'Germany',
            '+48' => $country = 'Poland',
            default => $country = '',
        };

        if (! $country) {
            return 'New free session scheduled by ' . $user->firstname . ' ' . $user->lastname . ' to ' . $this->getDMYSlashFormat($appointment->date) . ' and ' . $appointment->from . '-' . $appointment->to;
        }

        return "New free session scheduled from $country by " . $user->firstname . ' ' . $user->lastname . ' to ' . $this->getDMYSlashFormat($appointment->date) . ' and ' . $appointment->from . '-' . $appointment->to;
    }

    public function setAppointmentReminders(Appointment $appointment): null|array
    {
        $logNotes = [];
        foreach (config('app.appointment_reminders') as $reminder) {
            if (!($this->createReminder(
                appointment: $appointment,
                type: $reminder['type'],
                note: $reminder['note'],
                dateTime: $this->getCarbonInstance("{$appointment->date} {$appointment->from}")->subMinutes($reminder['minutes'])->subSeconds(2)
            )) instanceof Reminder) {
                $logNotes[] = $reminder['note'];
            }
        }

        if (! empty($logNotes)) {
            return $logNotes;
        }

        return null;
    }

    public function createReminder(Appointment $appointment, string $type, string $note, string $dateTime): Reminder|string
    {
        try {
            $reminder = Reminder::create([
                'model_id' => $appointment->id,
                'model_type' => get_class($appointment),
                'date_time' => $dateTime,
                'type' => $type,
                'note' => $note
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                return $error . "\n";
            }
        } catch (QueryException $e) {
            // Handle database errors
            return "Database error: " . $e->getMessage();
        }

        return $reminder;
    }

    public function bookAppointment(AppointmentData $appointmentData): CouldNotBookAppointment|int
    {
        $this->appointmentData = $appointmentData;
        // Basic checks
        if( ! ($basicChecksResponse = $this->basicChecks()) instanceof User) {
            throw new CouldNotBookAppointment($basicChecksResponse);
        } else {
            $user = $basicChecksResponse;
        }

        // Check Teacher availability
        if (! is_null($teacherAvailabilityResponse = $this->checkTeacherAvailability($appointmentData->teacherId, $appointmentData->date, $appointmentData->startTime))) {
            throw new CouldNotBookAppointment($teacherAvailabilityResponse);
        }

        // Get Appointment type based on student options
        try {
            $appointmentType = $this->getAppointmentTypeForStudent($user);
        } catch(CouldNotBookAppointment $e) {
            throw new CouldNotBookAppointment($e->getMessage());
        }

        // Create Zoom meeting link
        if (! is_array($responseDataZoom = $this->createZoomMeetingLink())) {
            Log::error("Zoom meeting has not been created due error: {$responseDataZoom}");

            throw new CouldNotBookAppointment(__('Zoom meeting has not been created due error: ' . $responseDataZoom));
        }

        // Create Appointment
        if (! ($appointment = $this->createAppointment()) instanceof Appointment) {
            Log::error("Appointment has not been created due error: {$appointment}");

            throw new CouldNotBookAppointment(__("Appointment has not been created due error: {$appointment}"));
        }

        // Create Appointment details
        if (! ($appointmentDetails = $this->createAppointmentDetails(
                appointment: $appointment,
                zoomMeetingData: $responseDataZoom,
                appointmentType: $appointmentType,
            )) instanceof AppointmentDetails)
        {
            Log::error("Appointment details has not been created due error: {$appointmentDetails}");

            $this->appointmentRepository->deleteAppointment($appointment->id);
            $this->appointmentRepository->deleteAppointmentDetails($appointment->id);

            throw new CouldNotBookAppointment(__("Appointment details has not been created due error: {$appointmentDetails}"));
        }

        // Update Student options
        if (! $this->updateStudentOptions($user, $appointmentType)) {
            Log::error("Student options has not been updated during booking Appointment {$appointment->id}");

            $this->appointmentRepository->deleteAppointment($appointment->id);
            $this->appointmentRepository->deleteAppointmentDetails($appointment->id);

            throw new CouldNotBookAppointment(__("Student options has not been updated during booking Appointment {$appointment->id}"));
        }

        // Send Android Push Notifications via Firebase Cloud Messaging
        if (config('app.push_notification')) {
            $this->sendPushNotificationsToTeacher(
                student:       $user,
                appointmentId: $appointment->id,
                teacherId:     $appointmentData->teacherId
            );
        }

        // Send Session Scheduled email to admin
        Mail::to(config('app.admin_email'))->send(new SessionScheduled(
            student: $user,
            appointment: $appointment,
            emailSubject: $this->getAppointmentEmailSubject($user, $appointment)
        ));

        // Create Reminders
        if($createRemindersResponse = $this->setAppointmentReminders($appointment)) {
            Log::error("Next reminders has not been set for Appointment Id {$appointment->id}:" . PHP_EOL . implode(PHP_EOL, $createRemindersResponse));
        }

        return $appointment->id;
    }

    /**
     * @param string $teacherId
     * @return array
     */
    public function getMonthCompletedSessionsForTeacher(string $teacherId) : array
    {
        $chartLabel = [];
        $chartData = [];

        $currentDate = now();

        for ($i = 0; $i < 12; $i++) {
            $monthYear = $currentDate->format('M, Y');
            $chartLabel[] = $monthYear;

            $completedAppointmentsCount = Appointment::where('teacher_id', $teacherId)
                ->where('status', 'COMPLETED')
                ->whereYear('date', $currentDate->year)
                ->whereMonth('date', $currentDate->month)
                ->count();

            $chartData[] = (string)$completedAppointmentsCount;

            $currentDate->subMonth();
        }

        return [
            'chartLabel' => array_reverse($chartLabel),
            'chartData' => array_reverse($chartData),
        ];
    }
    public function cancelAutoScheduledAppointments(int $studentId): ?CouldNotCancelAutoScheduledAppointments
    {
        // ToDo: add limit of CANCELLED appointments for student if need it

        if (($appointments = $this->appointmentRepository->getUpcomingAutoScheduledStudentAppointments($studentId))->isNotEmpty()) {
            foreach ($appointments as $appointment) {
                DB::transaction(function () use($appointment) {
                    if (! $this->appointmentRepository->cancelAppointment($appointment->id, 'Auto Schedule')) {
                        throw new CouldNotCancelAutoScheduledAppointments(__("Could not change the appointment status to CANCEL for Appointment ID ") . $appointment->id);
                    }

                    // Reset auto_schedule_booking_expiry in the student_auto_schedule_times
                    $this->appointmentServicesAggregator->getAutoScheduleService()->resetAutoScheduleBookingExpiry(
                        teacherId: $appointment->teacher_id,
                        studentId: $appointment->student_id,
                    );

                    // ToDo: if it was gift session, add count of gift sessions
                    // ToDo: if it was trial session, add count of trial sessions
                    // ToDo: Handle logic of feature months subscriptions (feature_months_subscriptions table)
                    // ToDo: if need update session_used_every_month table (method sessionCountCurrentMemberShip)

                    // Push notifications to students that in the waiting list of teacher
                    if (config('app.push_notification')) {
                        if (($teacherSubscribers = $this->appointmentRepository->getDateTeacherSubscribers(
                                teacherId: $appointment->teacher_id,
                                date:      $appointment->date
                            )) !== null) {
                            foreach ($teacherSubscribers as $teacherSubscriber) {
                                if ($teacherSubscriber->student_id === $appointment->student_id) {
                                    continue;
                                }

                                // Send Android Push Notifications via Firebase Cloud Messaging
                                if (! is_null($pushResponse = $this->sendPushNotificationsToTeacherSubscribers(
                                    teacherId: $teacherSubscriber->teacher_id,
                                    studentId: $teacherSubscriber->student_id,
                                    date:      $teacherSubscriber->date
                                ))) {
                                    Log::error("Push notification to the student ID $teacherSubscriber->student_id regarding the timeslot on the date $teacherSubscriber->date for the teacher ID $teacherSubscriber->teacher_id was not sent");
                                }
                            }
                        }
                    }

                    // ToDo: update old_membership table for student

                    // Cancel Zoom meeting
                    try {
                        if (config('services.zoom.is_enable')) {
                            $meetingId = unserialize($appointment->appointmentDetails->zoom_data,
                                                     ['allowed_classes' => false])['id'];
                            $this->appointmentServicesAggregator->getZoomService()->deleteMeeting($meetingId);
                        }
                    } catch (CouldNotDeleteZoomMeeting $e) {
                        Log::error("Zoom meeting for Appointment ID $appointment->id was not deleted due error: " . $e->getMessage());
                    }
                });
            }
        }
        return null;
    }

    public function sendPushNotificationsToTeacherSubscribers(int $teacherId, int $studentId, string $date): ?string
    {
        $teacher = $this->userRepository->getActiveUserById($teacherId);
        $student = $this->userRepository->getActiveUserById($studentId);
        try {
            $title = __('Your teacher got an open window due to a Canceled session.');
            $message = __('messages.waitlist_notification', [
                'name' => "$teacher->firstname $teacher->lastname",
                'date' => $date,
            ]);
            $payload = [
                'teacherId' => $teacherId,
                'notificationType' => config('app.notifications_types.session_notify_users')
            ];
            $deviceTokens = $student->userDevices->pluck('device_token');

            $this->appointmentServicesAggregator->getFCMService()->sendPushNotifications(
                deviceTokens: $deviceTokens,
                title: $title,
                body: $message,
                payload: $payload,
                userId: $teacherId
            );

        } catch(CouldNotSendPushNotification $e) {
            return $e->getMessage();
        }

        return null;
    }

    /**
     * @param Appointment $appointment
     * @param string $cancelledBy
     * @param AvailabilityData $availability
     * @return void
     */
    public function checkAppointmentWithAvailability(Appointment $appointment, string $cancelledBy, AvailabilityData $availability): void
    {
            if ($this->checkAppointmentCompatibility($appointment, $availability)) {
                return;
            }

            $this->appointmentRepository->cancelAppointment($appointment->id, $cancelledBy);
    }

    /**
     * @param Appointment $appointment
     * @param AvailabilityData $availability
     * @return bool
     */
    public function checkAppointmentCompatibility(Appointment $appointment, AvailabilityData $availability): bool
    {
        $appointmentTo = $appointment->to ? $this->getTimestamp($appointment->to) : null;
        $appointmentFrom = $appointment->from ? $this->getTimestamp($appointment->from) : null;
        $availabilityToTime = $availability->to_time ? $this->getTimestamp($availability->to_time) : null;
        $availabilityFromTime = $availability->from_time ? $this->getTimestamp($availability->from_time) : null;
        $availabilityBreakToTime = $availability->break_to_time ? $this->getTimestamp($availability->break_to_time) : null;
        $availabilityBreakFromTime = $availability->break_from_time ? $this->getTimestamp($availability->break_from_time) : null;

        if (!empty($availabilityBreakFromTime)) {
            if ($appointmentFrom <= $availabilityBreakFromTime && $appointmentTo > $availabilityBreakFromTime) {
                return false;
            }

            if (!empty($availabilityBreakToTime)) {
                if ($appointmentFrom >= $availabilityBreakFromTime && $appointmentFrom < $availabilityBreakToTime) {
                    return false;
                }

                if ($appointmentFrom > $availabilityBreakFromTime && $appointmentTo < $availabilityBreakToTime) {
                    return false;
                }
            }
        }

        if (!empty($availabilityFromTime) && $appointmentFrom < $availabilityFromTime) {
            return false;
        }

        if (!empty($availabilityToTime) && $appointmentTo > $availabilityToTime) {
            return false;
        }

        return true;
    }
}
