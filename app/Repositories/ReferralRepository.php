<?php

namespace App\Repositories;

use App\DataTransferObjects\ReferralData;
use App\Interfaces\ReferralRepositoryInterface;
use App\Models\Referral;
use Illuminate\Database\Eloquent\Collection;

class ReferralRepository implements ReferralRepositoryInterface
{
    public function __construct(private Referral $model) {}
    public function getReferralsUsingFilters(array $filters): Collection
    {
        $query = $this->model->query();

        if (isset($filters['from_date'])) {
            $query->where('date', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date'])) {
            $query->where('date', '<=', $filters['to_date']);
        }

        if (isset($filters['is_gift_sessions_assigned'])) {
            $query->where('is_gift_sessions_assigned', $filters['is_gift_sessions_assigned']);
        }

        return $query->get();
    }

    public function create(ReferralData $referralData): Referral|null
    {
        return $this->model->create([
            'user_id' => $referralData->userId,
            'referral_id' => $referralData->referralId,
            'is_gift_sessions_assigned' => $referralData->is_gift_sessions_assigned,
            'date' => $referralData->date
        ]);
    }
}
