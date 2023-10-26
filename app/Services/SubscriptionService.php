<?php

namespace App\Services;

use App\DataTransferObjects\PaymentData;
use App\DataTransferObjects\SubscriptionData;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use App\Traits\DateTimeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CouldNotCreateUpcomingSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    use DateTimeTrait;

    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepository,
        protected PayPalService $payPalService
    ) {}

    public function createUpcomingSubscription(int $userId): Subscription|CouldNotCreateUpcomingSubscription
    {
        $currentSubscription = Auth::user()->subscription;
        $startDate = $this->getCarbonInstance($currentSubscription->end_date)->addDay();
        $endDate = clone $startDate;
        $key = 'subscription.days_of_type.' . $currentSubscription->type;
        $endDate->addDays(config($key));

        // Create a new subscription model
        $newSubscription = $this->subscriptionRepository->create(
            new SubscriptionData(
                userId: $userId,
                planId: $currentSubscription->plan_id,
                type: $currentSubscription->type,
                isActive: false,
                isPaused: false,
                startDate: $startDate,
                endDate: $endDate,
                renewalCount: $currentSubscription->renewal_count,
                paypalSubscriptionId: $currentSubscription->paypal_subscription_id
            )
        );

        if(! $newSubscription instanceof Subscription) {
            throw new CouldNotCreateUpcomingSubscription($newSubscription);
        }

        return $newSubscription;
    }

    public function activateOrRenewSubscription(string $paypalSubscriptionId): void
    {
        $subscription = Subscription::where('paypal_subscription_id', $paypalSubscriptionId)->first();

        if (!$subscription) {
            $this->activateNewSubscription($paypalSubscriptionId);
        } else {
            $this->renewSubscription($subscription);
        }
    }

    protected function renewSubscription($subscription): void
    {
        $subscription->update([
            'end_date' => now()->addMonth(),
            'renewal_count' => $subscription->renewal_count + 1,
        ]);
    }

    protected function activateNewSubscription(string $paypalSubscriptionId): void
    {
        DB::transaction(function () use ($paypalSubscriptionId) {
            $subscriptionStatus = $this->payPalService->checkPaypalSubscriptionStatus($paypalSubscriptionId);
            $planData = json_decode($subscriptionStatus['custom_id'], true);

            $this->subscriptionRepository->hasActiveSubscription($planData['user_id']);

            $subscriptionData = SubscriptionData::fromArrays($subscriptionStatus, $planData);
            $this->subscriptionRepository->createSubscriptionFromPayPalResponse($subscriptionData);

            $paymentData = PaymentData::fromArrays($subscriptionStatus, $planData);
            $this->subscriptionRepository->createPaymentFromPayPalData($paymentData, $subscriptionStatus);
        });
    }

    public function handleUnknownEvent(Request $request): void
    {
        Log::warning('Received unknown PayPal webhook event', [
            'event_type' => $request->input('event_type'),
            'full_request' => $request->all()
        ]);
    }
}
