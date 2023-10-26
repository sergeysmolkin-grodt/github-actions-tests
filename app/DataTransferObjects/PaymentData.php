<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;

class PaymentData
{
    public function __construct(
        public readonly string $status,
        public readonly float $amount,
        public readonly string $paymentDate,
        public readonly int $userId,
        public readonly int $planId
    ) {
    }

    public static function fromArrays(array $subscriptionStatus, array $planData): self
    {
        return new self(
            $subscriptionStatus['status'],
            $subscriptionStatus['billing_info']['last_payment']['amount']['value'],
            Carbon::parse($subscriptionStatus['billing_info']['last_payment']['time'])->format('Y-m-d'),
            $planData['user_id'],
            $planData['plan_id']
        );
    }
}
