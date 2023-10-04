<?php

namespace App\Interfaces;

use App\DataTransferObjects\SubscriptionData;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionRepositoryInterface
{
    public function create(SubscriptionData $subscriptionData): string|Subscription;
    public function getUpcommingSubscription(Subscription $subscription): ?Subscription;
}
