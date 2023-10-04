<?php

namespace App\Services;

use App\DataTransferObjects\AvailabilityData;
use App\DataTransferObjects\HolidayData;
use App\Repositories\AvailabilityExceptionRepository;

class AvailabilityExceptionService
{
    public function __construct(
        protected AvailabilityExceptionRepository $availabilityExceptionRepository
    ) {}

    /**
     * @param int $teacherId
     * @return array
     */
    public function getIrregularTeacherSchedule(int $teacherId): array
    {
        $availabilitiesExceptions = $this->availabilityExceptionRepository->getExceptionsForTeacher($teacherId);
        $resultExceptions = [];

        foreach ($availabilitiesExceptions as $exception) {
            $key = $exception["date"];

            if (!isset($resultExceptions[$key])) {
                $resultExceptions[$key] = [
                    'date' => $exception['date'],
                    'teacher_id' => $exception['teacher_id']
                ];
            }

            if ($exception['type'] === config('app.availability_exceptions.availabilities')) {
                $resultExceptions[$key]["from_time"] = $exception["from_time"];
                $resultExceptions[$key]["to_time"] = $exception["to_time"];
            } else {
                $resultExceptions[$key]["break_from_time"] = $exception["from_time"];
                $resultExceptions[$key]["break_to_time"] = $exception["to_time"];
            }
        }

        return array_values($resultExceptions);
    }

    /**
     * @param AvailabilityData $data
     * @return string|bool
     */
    public function basicChecks(AvailabilityData $data): string|bool
    {
        if (!$data->from_time && !$data->to_time && !$data->break_from_time && !$data->break_to_time) {
            return 'Please at least select any one start time and end time';
        }

        if ($data->from_time && !$data->to_time || !$data->from_time && $data->to_time) {
            return 'Please select both the Start Time and the End Time';
        }

        if ($data->break_from_time && !$data->break_to_time || !$data->break_from_time && $data->break_to_time) {
            return 'Please select both the Break Start Time and the Break End Time';
        }

        return 0;
    }

    /**
     * @param AvailabilityData $data
     * @return void
     */
    public function updateOrCreate(AvailabilityData $data): void
    {
        if ($data->from_time && $data->to_time) {
            $availabilityException = [
                'teacher_id' => $data->teacher_id,
                'date' => $data->date,
                'from_time' => $data->from_time,
                'to_time' => $data->to_time
            ];

            $this->availabilityExceptionRepository->updateOrCreate($availabilityException, 'AVAILABILITIES');
        }

        if ($data->break_from_time && $data->break_to_time) {
            $availabilityException = [
                'teacher_id' => $data->teacher_id,
                'date' => $data->date,
                'from_time' => $data->break_from_time,
                'to_time' => $data->break_to_time
            ];
            $this->availabilityExceptionRepository->updateOrCreate($availabilityException, 'BREAK_TIME');
        }
    }
}
