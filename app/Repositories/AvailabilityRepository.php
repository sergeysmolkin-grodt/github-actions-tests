<?php

namespace App\Repositories;

use App\DataTransferObjects\AvailabilityData;
use App\Interfaces\AvailabilityRepositoryInterface;
use App\Models\Availability;
use Illuminate\Support\Collection;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    public function getAvailabilityByTeacherId(int $teacherId): ?Collection
    {
        return Availability::where('teacher_id', $teacherId)->get();
    }

    public function updateOrCreate(AvailabilityData $availability): void
    {
        Availability::updateOrCreate(
            ['day' => $availability->day, 'teacher_id' => $availability->teacher_id],
            [
                'day' => $availability->day,
                'teacher_id' => $availability->teacher_id,
                'is_available' => $availability->is_available,
                'from_time' => $availability->from_time,
                'to_time' => $availability->to_time,
                'break_from_time' => $availability->break_from_time,
                'break_to_time' => $availability->break_to_time,
            ]
        );
    }
}
