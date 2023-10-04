<?php

namespace App\Services;

use App\DataTransferObjects\SubscriptionData;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CouldNotCreateUpcomingSubscription;

class SubscriptionService
{
    use DateTimeTrait;

    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepository,
    ) {}

    public function createUpcomingSubscription(): Subscription|CouldNotCreateUpcomingSubscription
    {
        $currentSubscription = Auth::user()->subscription;

        $startDate = $this->getCarbonInstance($currentSubscription->end_date)->addDay();
        $key = 'subscription.days_of_type.' . $currentSubscription->type;
        $endDate = $startDate->addDays(config($key));

        // Create a new subscription model
        $newSubscription = $this->subscriptionRepository->create(
            new SubscriptionData(
                userId: Auth::user() ,
                planId: $currentSubscription->plan_id,
                isActive: false,
                isPause: false,
                startDate: $startDate,
                endDate: $endDate
            )
        );

        if(! $newSubscription instanceof Subscription) {
            throw new CouldNotCreateUpcomingSubscription();
        }

        return $newSubscription;
    }
}
