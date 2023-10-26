<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateSubscriptionRequest;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use App\Services\PayPalService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class PayPalController extends Controller
{
    public function __construct(
        protected PayPalService $payPalService,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionService $subscriptionService,
    ){}

    public function createSubscription(CreateSubscriptionRequest $request)
    {
        try {
            $this->subscriptionRepository->hasActiveSubscription(Auth::user()->id);

            $subscriptionData = $this->payPalService->createSubscription($request->validated()['planId']);
        } catch (\Exception $e) {
            Log::error('PayPal processPayment error: ' . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return $this->respondWithSuccess([
                'message' => __('Subscription created successfully')
            ] + $subscriptionData);
    }

    public function handlePayPalWebhook(Request $request)
    {
        try {
            $subscriptionId = $request->input('resource.id');

            switch ($request->input('event_type')) {
                case config('webhooks.paypal_events.payment_completed'):
                    $this->subscriptionService->activateOrRenewSubscription($request->input('resource.billing_agreement_id'));
                    break;
                case config('webhooks.paypal_events.cancelled'):
                    $this->payPalService->cancelSubscription($subscriptionId);
                    break;
                default:
                    $this->subscriptionService->handleUnknownEvent($request);
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Failed to handle webhook: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return $this->respondWithSuccess([
            'message' => __('Webhook has been received')
        ]);
    }
}
