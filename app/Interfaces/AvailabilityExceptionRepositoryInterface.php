<?php

namespace App\Interfaces;

use App\DataTransferObjects\HolidayData;
use App\Models\AvailabilityException;
use Illuminate\Database\Eloquent\Collection;

interface AvailabilityExceptionRepositoryInterface
{
    public function updateOrCreate(array $data, string $type): void;
    public function getExceptionsForTeacher(int $teacherId): Collection|null;
    public function deleteIrregularTeacherScheduleByDate(int $teacherId, string $date): void;
    public function getHolidaysForTeacher(int $teacherId): Collection|null;
    public function firstOrCreateHoliday(HolidayData $holidayData): AvailabilityException|null;
}
