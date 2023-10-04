<?php

namespace App\DataTransferObjects;

class SubscriptionData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $planId,
        public readonly bool $isActive,
        public readonly bool $isPause,
        public readonly string $startDate,
        public readonly string $endDate,
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'plan_id' => $this->planId,
            'is_active' => $this->isActive,
            'is_pause' => $this->isPause,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
    }
}
