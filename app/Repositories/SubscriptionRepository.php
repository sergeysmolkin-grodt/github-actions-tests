<?php

namespace App\Repositories;

use App\DataTransferObjects\PaymentData;
use App\DataTransferObjects\SubscriptionData;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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

    public function createSubscriptionFromPayPalResponse(SubscriptionData $subscriptionData)
    {
        return Subscription::create([
            'user_id' => $subscriptionData->userId,
            'plan_id' => $subscriptionData->planId,
            'type' => config('subscription.types.monthly'),
            'is_active' => $subscriptionData->isActive,
            'is_paused' => $subscriptionData->isPaused,
            'start_date' => $subscriptionData->startDate,
            'end_date' => $subscriptionData->endDate,
            'renewal_count' => $subscriptionData->renewalCount,
            'paypal_subscription_id' => $subscriptionData->paypalSubscriptionId,
        ]);
    }

    public function createPaymentFromPayPalData(PaymentData $paymentData, $transactionData)
    {
        return Payment::create([
            'user_id' => $paymentData->userId,
            'model_id' => $paymentData->planId,
            'model_type' => Plan::class,
            'payment_method' => config('app.payment_methods.paypal'),
            'payment_date' => $paymentData->paymentDate,
            'amount' => $paymentData->amount,
            'status' => $paymentData->status,
            'transaction_data' => json_encode($transactionData)
        ]);
    }

    public function cancelSubscription($userId): void
    {
        $subscription = Subscription::where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$subscription) {
            throw new \Exception("Active subscription not found for user ID: {$userId}");
        }

        $subscription->is_active = false;
        $subscription->save();
    }

    public function hasActiveSubscription($userId): void
    {
        if (DB::table('subscriptions')
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->where('end_date', '>', now())
            ->exists()) {
            throw new \Exception('The user already has an active subscription.');
        }
    }
}
