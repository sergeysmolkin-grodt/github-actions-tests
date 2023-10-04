<?php

namespace App\Repositories;

use App\DataTransferObjects\HolidayData;
use App\Interfaces\AvailabilityExceptionRepositoryInterface;
use App\Models\AvailabilityException;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityExceptionRepository implements AvailabilityExceptionRepositoryInterface
{
    public function updateOrCreate(array $data, string $type): void
    {
        AvailabilityException::updateOrCreate(
            ['teacher_id' => $data['teacher_id'], 'date' => $data['date'], 'type' => $type],
            [
                'teacher_id' => $data['teacher_id'],
                'date' => $data['date'],
                'from_time' => $data['from_time'],
                'to_time' => $data['to_time'],
                'type' => $type
            ]
        );
    }

    public function getExceptionsForTeacher(int $teacherId): Collection|null
    {
        return AvailabilityException::where('teacher_id', $teacherId)
            ->whereIn('type', ['BREAK_TIME', 'AVAILABILITIES'])
            ->select('teacher_id', 'date', 'from_time', 'to_time', 'type')
            ->get();
    }

    public function deleteIrregularTeacherScheduleByDate(int $teacherId, string $date): void
    {
        AvailabilityException::where('teacher_id', $teacherId)
            ->where('date', $date)
            ->whereIn('type', ['BREAK_TIME', 'AVAILABILITIES'])
            ->delete();
    }

    public function getHolidaysForTeacher(int $teacherId): Collection|null
    {
        return AvailabilityException::where('teacher_id', $teacherId)->where('type', 'HOLIDAY')->get();
    }

    public function firstOrCreateHoliday(HolidayData $holidayData): AvailabilityException|null
    {
        return AvailabilityException::firstOrCreate([
            'teacher_id' => $holidayData->teacher_id,
            'date' => $holidayData->date,
            'type' => config('app.availability_exceptions.holidays')
        ]);
    }
}
