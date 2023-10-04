<?php

namespace App\Jobs\Cron;

use App\DataTransferObjects\AppointmentData;
use App\Exceptions\CouldNotBookAppointment;
use App\Interfaces\AutoScheduleRepositoryInterface;
use App\Mail\Appointments\SessionScheduled;
use App\Mail\Appointments\FailedSendingMessageViaCommbox;
use App\Mail\Appointments\UnbookedSessions;
use App\Repositories\AutoScheduleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Illuminate\Http\Request;
use App\Services\AppointmentService;
use App\Services\CommboxService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ProcessStudentAutoSchedule extends ProcessCronJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DateTimeTrait;

    private $requestData;
    private $studentId = null;
    private $counter = 0;
    private $booked = 0;
    private $totalNotBookedSloats = [];
    /**
     * Create a new job instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->requestData = $request->all();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // ToDo: Refactoring: improve readability by breaking logic into smaller methods
        // ToDo: make dynamic resolver of dependencies via properties

        $autoScheduleRepository = app(AutoScheduleRepositoryInterface::class);
        $appointmentService = app(AppointmentService::class);

        $autoScheduleModels = $autoScheduleRepository->getAutoScheduleTimesForProcessing();

        // Loop through all received models of auto schedule
        foreach ($autoScheduleModels as $key => $autoScheduleModel) {
            $isLastIteration = ($key === $autoScheduleModels->count() - 1);
            $autoScheduleBookingExpiry = $this->addDaysToDateTime($autoScheduleModel->subscription->end_date, config('app.additional_auto_schedule_booking_days'));
            $student = User::findOrFail($autoScheduleModel->student_id);
            App::setLocale($student->userDetails->language);

            if ((! is_null($this->studentId) && $this->studentId !== $autoScheduleModel->student_id)) {
                if (! empty($this->totalNotBookedSloats)) {
                    $this->sendUnbookedSessionsNotifications($student, $this->totalNotBookedSloats);
                }
                $this->resetData();
            }
            $this->studentId = $autoScheduleModel->student_id;

            // Loop through all time slots on specific day of week
            foreach (explode(',', $autoScheduleModel->time) as $time) {
                $date = $this->nextDateOfDay($autoScheduleModel->day);
                $dates = [];

                while (strtotime($date) <= strtotime($autoScheduleBookingExpiry)) {
                    $dates[] = $date;
                    $date = $this->addWeekToDate($date);
                }

                // Loop through all dates on specific day of week
                foreach ($dates as $date) {
                    $this->counter++;
                    try {
                        $appointmentId = $appointmentService->bookAppointment(
                        // ToDo: create static method fromArray
                            new AppointmentData(
                                userId: $autoScheduleModel->student_id,
                                teacherId: $autoScheduleModel->teacher_id,
                                date: $date,
                                startTime: $time,
                                isAutoScheduleSession: true
                            )
                        );

                        $this->booked++;

                    } catch (CouldNotBookAppointment $e) {
                        $this->totalNotBookedSloats[] = $date . ' ' . $time;

                        $message = $e->getMessage();
                        Log::error('Auto schedule appointment for a date {date} {time} for a student ID {studentId} with a teacher ID {teacherId} was not booked due to an error {message}',
                           [
                               'date' => $date,
                               'time' => $time,
                               'studentId' => $autoScheduleModel->student_id,
                               'teacherId' => $autoScheduleModel->teacher_id,
                               'message' => $message
                           ]);
                    }
                }
            }

            if ($this->booked) {
                $autoScheduleModel->auto_schedule_booking_expiry = $autoScheduleBookingExpiry;
                $autoScheduleModel->push();
            }

            if ($isLastIteration) {
                if (! empty($this->totalNotBookedSloats)) {
                    $this->sendUnbookedSessionsNotifications($student, $this->totalNotBookedSloats);
                }
                $this->resetData();
            }
        }
    }

    private function sendUnbookedSessionsNotifications(User $student, array $totalNotBookedSloats): void
    {
        $commboxService = app(CommboxService::class);
        $userDetails = $student->userDetails;
        $phoneNumber = $userDetails->country_code . $userDetails->mobile;

        // Send unbooked Auto Schedule sessions to student email
        Mail::to($student->email)->send(new UnbookedSessions(
            notBookedSloats: $totalNotBookedSloats,
        ));

        // Send unbooked Auto Schedule sessions to student WhatsApp number
        $messageResponse = $commboxService->sendMessage(
            phoneNumber: $phoneNumber,
            language: $userDetails->language
        );

        if (! $messageResponse->successful()) {
            Mail::to($student->email)->send(new FailedSendingMessageViaCommbox(
                messageResponse: $messageResponse,
                messageType: 'wp_cancel_session_by_admin_panel_new',
                phoneNumber: $phoneNumber,
            ));
        }

        $this->resetData();
    }

    private function resetData(): void
    {
        $this->counter = 0;
        $this->booked = 0;
        $this->totalNotBookedSloats = [];
        $this->studentId = null;
    }
}
