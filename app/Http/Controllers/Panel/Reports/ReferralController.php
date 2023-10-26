<?php

namespace App\Http\Controllers\Panel\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ReferralIndexRequest;
use App\Repositories\ReferralRepository;
use App\Traits\DateTimeTrait;

class ReferralController extends Controller
{
    use DateTimeTrait;
    public function __construct(protected ReferralRepository $referralRepository)
    {
        //
    }

    public function index(ReferralIndexRequest $request)
    {
        $filters = $request->validated();

        $formattedFilters = $filters;

        $formattedFilters['to_date'] = isset($filters['to_date']) ? $this->getYMDHyphenFormat($filters['to_date']) : null;
        $formattedFilters['from_date'] = isset($filters['from_date']) ? $this->getYMDHyphenFormat($filters['from_date']) : null;
        $referrals = $this->referralRepository->getReferralsUsingFilters($formattedFilters);

        return view('panel.reports.referrals_view', compact('referrals', 'filters'));
    }
}
