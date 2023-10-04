<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Provider;
use App\Models\StudentAutoScheduleTime;
use App\Models\StudentAutoScheduleTimeLog;
use App\Models\Subscription;
use App\Models\TeacherOptions;
use App\Models\StudentOptions;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\PasswordResetToken;
use App\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Traits\HasRoles;
use App\Interfaces\AutoScheduleRepositoryInterface;

class AutoScheduleRepository implements AutoScheduleRepositoryInterface
{
    use DateTimeTrait;

    public function __construct(
        private StudentAutoScheduleTime $model,
        private StudentAutoScheduleTimeLog $logModel
    ) {}

    public function create(...$data): StudentAutoScheduleTime|string
    {
        try {
            $studentAutoScheduleTime = $this->model->create([
                'student_id' => $data['studentId'],
                'teacher_id' => $data['teacherId'],
                'day' => $data['day'],
                'time' => $data['time'],
                'scheduled_date' => $data['scheduledDate']
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

        return $studentAutoScheduleTime;
    }

    public function remove(int $studentId): string|null
    {
        $deleted = $this->model->where('student_id', $studentId)->delete();

        if ($deleted === 0) {
            return __("Auto schedule didn't remove successfully due to an error");
        }

        return null;
    }

    public function log(int $userId, string $cause, string $details): StudentAutoScheduleTimeLog|string|null
    {
        try {
            $log = $this->logModel->create([
                'student_id' => $userId,
                'cause' => $cause,
                'details' => $details
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

        return $log;
    }

    public function getStudentAutoSchedule(int $studentId): Collection|null
    {
        return $this->model->where('student_id', $studentId)->get();
    }

    public function getIntersections(object $timeDetails): int|null
    {
        dd($timeDetails);
        $timeSlots = explode(',', $timeDetails->time);

        return $this->model->where('teacher_id', $timeDetails->teacherId)
                               ->where('day', $timeDetails->day)
                               ->whereIn('time', $timeSlots)
                               ->count();
    }

    public function getAutoScheduleTimesForProcessing(): Collection
    {
        $currentDate = $this->getCurrentDate();

        // ToDo: set count limit if need it
        // ToDo: ->select('student_auto_schedule_times.*', 'subscription.end_date') instead of whole subscription
        return $this->model->with('subscription')
            ->whereHas('subscription', function ($query) use ($currentDate) {
                $query->where('is_active', true)
                      ->where(function ($query) use ($currentDate) {
                          $query->whereNull('auto_schedule_booking_expiry')
                                ->orWhere('auto_schedule_booking_expiry', '<', $this->addDaysToDateTime($currentDate, config('app.additional_auto_schedule_booking_days')));
                      });
            })
            //->limit(50)
            ->get();
    }

    public function resetAutoScheduleBookingExpiry(int $teacherId, int $studentId): void
    {
        $modelsToUpdate = $this->model->where('teacher_id', $teacherId)
                                      ->where('student_id', $studentId)
                                      ->get();

        $modelsToUpdate->each(function ($model) {
            $model->update(['auto_schedule_booking_expiry' => null]);
        });
    }
}
