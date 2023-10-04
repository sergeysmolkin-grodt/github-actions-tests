<?php

namespace App\Interfaces;

use App\DataTransferObjects\AvailabilityData;
use Illuminate\Support\Collection;

interface AvailabilityRepositoryInterface
{
    public function getAvailabilityByTeacherId(int $teacherId): ?Collection;

    public function updateOrCreate(AvailabilityData $availability): void;
}
