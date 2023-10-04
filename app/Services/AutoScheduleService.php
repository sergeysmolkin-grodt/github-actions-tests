<?php

namespace App\Services;

use App\Exceptions\CouldNotSetAutoScheduleTime;
use App\Models\StudentAutoScheduleTime;
use App\Models\StudentAutoScheduleTimeLog;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Interfaces\AutoScheduleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class AutoScheduleService
{
    use DateTimeTrait;

    public function __construct(
        protected AutoScheduleRepositoryInterface $autoScheduleRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function checkAvailabilityAutoScheduleTimeSlots(array $timesDetails): null|string
    {

        foreach ($timesDetails as $timeDetails) {
            $intersection = $this->autoScheduleRepository->getIntersections((object)$timeDetails);
            if ($intersection > 0) {
                return __('These slots are reserved by other student. Please select other slots.');
            }
        }

        return null;
    }

    public function setAutoScheduleTime(array $requestData): void
    {
        if ( ! is_null($availabilityResponse = $this->checkAvailabilityAutoScheduleTimeSlots($requestData['timeDetails']))) {
            throw new CouldNotSetAutoScheduleTime($availabilityResponse);
        }

        foreach($requestData['timeDetails'] as $timeDetail) {

            $createStudentAutoScheduleTimesResponse = $this->autoScheduleRepository->create(
                studentId: Auth::user()->id,
                teacherId: $timeDetail['teacherId'],
                day: $timeDetail['day'],
                time: $timeDetail['time'],
                scheduledDate: $requestData['autoScheduleDate']
            );

            if (!$createStudentAutoScheduleTimesResponse instanceof StudentAutoScheduleTime) {
                throw new CouldNotSetAutoScheduleTime($createStudentAutoScheduleTimesResponse);
            }
        }
    }

    public function logAndRemoveAutoScheduleTime(int $studentId): void
    {
        $log = json_encode($this->autoScheduleRepository->getStudentAutoSchedule($studentId)->toArray());

        if (! ($logResponse = $this->autoScheduleRepository->log($studentId, 'Update Auto Schedule', $log) instanceof StudentAutoScheduleTimeLog)) {
            Log::error("An error occurred during logging auto schedule time: $logResponse");
        }

        if (! is_null($removedResponse = $this->autoScheduleRepository->remove($studentId))) {
            Log::error("An error occurred during removing auto schedule time: $removedResponse");
        }
    }

    public function resetAutoScheduleBookingExpiry(int $teacherId, int $studentId): void
    {
        $this->autoScheduleRepository->resetAutoScheduleBookingExpiry($teacherId, $studentId);
    }
}
