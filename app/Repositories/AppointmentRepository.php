<?php

namespace App\Repositories;

use App\Interfaces\AppointmentRepositoryInterface;
use App\Models\Appointment;
use App\Models\AppointmentDetails;
use App\Models\Subscription;
use App\Models\Reminder;
use App\Models\TeacherSubscribers;
use App\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements AppointmentRepositoryInterface
{
  use DateTimeTrait;

    public function __construct(
        private Appointment $appointmentModel,
        private AppointmentDetails $appointmentDetailsModel,
        private TeacherSubscribers $teacherSubscribers
    ) {}

    public function findAppointment(int $id): ?Appointment
    {
        return $this->appointmentModel->find($id);
    }

    public function deleteAppointment(Appointment $id): int
    {
        return $this->appointmentModel->findOrFail($id)->delete();
    }

    public function deleteAppointmentDetails(Appointment $id): int
    {
        return $this->appointmentModel->findOrFail($id)->appointmentDetails->delete();
    }

    public function getUpcomingAutoScheduledStudentAppointments(int $studentId): Collection
    {
        $currentDateTime = $this->getCurrentDateTime();

        return $this->appointmentModel->with('appointmentDetails')
            ->whereHas('appointmentDetails', function ($query) use ($currentDateTime, $studentId) {
                $query->where('is_auto_schedule_session', '1')
                ->where('student_id', $studentId)
                ->where('status', config('app.appointment_statuses.pending'))
                ->where(function ($query) use ($currentDateTime) {
                    $query->where('date', '>', $currentDateTime)
                          ->orWhere(function ($query) use ($currentDateTime) {
                              $query->where('date', $currentDateTime)
                                    ->where('from', '>', $currentDateTime);
                          });
                });
            })
            ->get();
    }

    public function update(Appointment $appointment, array $data): int
    {
        return $appointment->update($data);
    }

    public function getDateTeacherSubscribers(int $teacherId, string $date): Collection
    {
        return $this->teacherSubscribers->where('teacher_id', $teacherId)
            ->where('date', $date)
            ->get();
    }

    public function getTotalCompletedSessionsForTeacher(int $id): int|null
    {
        return Appointment::where('teacher_id', $id)->where('status', config('app.appointment_statuses.completed'))->count();
    }

    public function getTotalAppointmentsIdsForTeacher(int $id): SupportCollection|null
    {
        return Appointment::where('teacher_id', $id)->pluck('id');
    }
    public function cancelAppointment(int $id, string $cancelledBy = 'STUDENT'): bool
    {
        if (!$appointment = $this->findAppointment($id)) {
            return false;
        }
        return DB::transaction(function () use ($appointment, $cancelledBy) {
            $isUpdated = $appointment->update([
                'status' => config('app.appointment_statuses.cancelled'),
                'cancelled_by' => $cancelledBy,
            ]);
            // TODO Add check if this session was trial session assigned by admin
            if ($isUpdated) {
                // Bulk delete the reminders within the same transaction
                Reminder::where('model_id', $appointment->id)
                        ->where('model_type', Appointment::class)
                        ->delete();
            }
            return $isUpdated;
        });
    }

    public function getSubscriptionAppointments(Subscription $subscription): Collection
    {
        return $subscription->appointments()
            ->where('status', '!==', config('app.appointment_statuses.cancelled'))
            ->get();
    }

    public function getUpcomingAppointmentsForTeacherByDayOfWeek(int $teacherId, int $dayOfWeek): Collection|null
    {
        $time = $this->getCurrentDateTime();
        return Appointment::where('teacher_id', $teacherId)
            ->whereRaw("DAYNAME(date) = ?", [$dayOfWeek-1])
            ->where('status', config('app.appointment_statuses.pending'))
            ->where(function ($query) use ($time) {
                $query->where(function ($query) use ($time) {
                    $query->where('date', '=', $this->getCurrentDate())
                        ->where('from', '>', $time);
                })->orWhere(function ($query) {
                    $query->where('date', '>', $this->getCurrentDate());
                });
            })
            ->get();
    }

    public function getAppointmentsForTeacherByDate(int $teacherId, string $date): Collection|null
    {
        return Appointment::where('teacher_id', $teacherId)
            ->where('date', $date)
            ->where('status', config('app.appointment_statuses.pending'))
            ->get();
    }
}
