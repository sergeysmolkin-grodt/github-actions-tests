<?php

namespace App\DataTransferObjects;

class ReferralData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $referralId,
        public readonly ?bool $is_gift_sessions_assigned = false,
        public readonly ?string $date = null,
    ) {
    }

}
