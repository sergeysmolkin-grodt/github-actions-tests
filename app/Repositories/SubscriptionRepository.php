<?php

namespace App\Repositories;

use App\DataTransferObjects\SubscriptionData;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use App\Traits\DateTimeTrait;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    use DateTimeTrait;

    public function __construct(
        private Subscription $model,
    ) {}

    public function create(SubscriptionData $subscriptionData): string|Subscription
    {
        try {
            $subscription = $this->model->create($subscriptionData->toArray());
        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                return $error . "\n";
            }
        } catch (QueryException $e) {
            // Handle database errors
            return "Database error: " . $e->getMessage();
        }

        return $subscription;
    }

    public function getUpcommingSubscription(Subscription $subscription): ?Subscription
    {
        return $this->model->where('start_date', $this->getCarbonInstance($subscription->start_date)->addDay())
            ->where('is_active', false)
            ->get();
    }
}
