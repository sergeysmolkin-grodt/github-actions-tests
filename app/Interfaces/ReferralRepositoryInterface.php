<?php

namespace App\Interfaces;

use App\DataTransferObjects\ReferralData;
use App\Models\Referral;
use Illuminate\Database\Eloquent\Collection;

interface ReferralRepositoryInterface
{
    public function getReferralsUsingFilters(array $filters): Collection;
    public function create(ReferralData $referralData): Referral|null;
}
