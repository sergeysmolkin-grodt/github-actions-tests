<?php

namespace App\DataTransferObjects;

class AppointmentData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $teacherId,
        public readonly string $date,
        public readonly string $startTime,
        public readonly bool $isAutoScheduleSession,
    ) {
    }
}
