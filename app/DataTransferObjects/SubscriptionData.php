<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;

class SubscriptionData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $planId,
        public readonly string $type,
        public readonly bool $isActive,
        public readonly bool $isPaused,
        public readonly string $startDate,
        public readonly string $endDate,
        public readonly int $renewalCount,
        public readonly ?string $paypalSubscriptionId
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'plan_id' => $this->planId,
            'type' => $this->type,
            'is_active' => $this->isActive,
            'is_paused' => $this->isPaused,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'renewal_count' => $this->renewalCount,
            'paypal_subscription_id' => $this->paypalSubscriptionId,
        ];
    }

    public static function fromArrays(array $subscriptionStatus, array $planData): self
    {
        return new self(
            $planData['user_id'],
            $planData['plan_id'],
            $subscriptionStatus['status'] === 'ACTIVE',
            false,
            Carbon::parse($subscriptionStatus['start_time'])->format('Y-m-d'),
            Carbon::parse($subscriptionStatus['billing_info']['final_payment_time'])->format('Y-m-d'),
            $subscriptionStatus['renewal_count'] ?? 0,
            $subscriptionStatus['id'] ?? null
        );
    }
}
