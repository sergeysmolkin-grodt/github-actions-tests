<?php

namespace App\Services;
use App\Exceptions\CouldNotCreateProduct;
use App\Exceptions\CouldNotCreatePlan;
use App\Exceptions\CouldNotCreateSubscription;
use App\Exceptions\CouldNotGetAccessToken;
use App\Exceptions\CouldNotGetSubscriptionStatus;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\StudentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayPalService
{
    public function __construct(protected StudentRepository $studentRepository)
    {
        $this->PAYPAL_CLIENT_ID = config('services.paypal.client_id');
        $this->PAYPAL_SECRET = config('services.paypal.secret');
        $this->PAYPAL_BASE_URL = config('services.paypal.base_url');
    }

    private function getAccessToken() : string
    {
        $response = Http::withBasicAuth($this->PAYPAL_CLIENT_ID, $this->PAYPAL_SECRET)
            ->asForm()
            ->post("$this->PAYPAL_BASE_URL/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            throw new CouldNotGetAccessToken("Failed to get PayPal access token");
        }
        return $response->json()['access_token'];
    }

    public function checkPaypalSubscriptionStatus($subscriptionId) : array
    {
        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->get("$this->PAYPAL_BASE_URL/v1/billing/subscriptions/$subscriptionId");

        if (!$response->successful()) {
            throw new CouldNotGetSubscriptionStatus("Failed to get subscription status: " . $response->body());
        }
        return $response->json();
    }

    public function createProduct(): JsonResponse
    {
        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/catalogs/products", [
                    'name' => 'i-Fal Monthly Subscriptions',
                    'description' => 'Flexible one-month subscription plans for online classes. Choose the number of sessions per week that suits you best.',
                    'type' => 'DIGITAL',
                    'category' => 'SOFTWARE',
                    'image_url' => config('services.paypal.redirect_url.image_url'),
                    'home_url' => config('services.paypal.redirect_url.home_url')
                ]);

        if (!$response->successful()) {
            throw new CouldNotCreateProduct("Failed to create product: " . $response->body());
        }
        return response()->json($response->json());
    }

    public function createSubscriptionPlan($planId): JsonResponse
    {
        $plan = Plan::findOrFail($planId);

        $product = $this->createProduct()->getData(true);
        $productId = $product['id'];

        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/billing/plans", [
                'product_id' => $productId,
                'name' => $plan->name,
                'description' => $plan->type,
                'status' => 'ACTIVE',
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => 'MONTH',
                            'interval_count' => 1
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 2,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $plan->price,
                                'currency_code' => 'USD'
                            ]
                        ]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => [
                        'value' => 0,
                        'currency_code' => 'USD'
                    ],
                    'setup_fee_failure_action' => 'CONTINUE'
                ]
            ]);

        if (!$response->successful()) {
            throw new CouldNotCreatePlan("Failed to create subscription plan: " . $response->body());
        }
        return response()->json($response->json());
    }

    public function createSubscription($planId): array
    {
        $payPalPlan = $this->createSubscriptionPlan($planId)->getData(true);
        $payPalPlanId = $payPalPlan['id'];

        $studentData = $this->studentRepository->getStudent(Auth::user()->id);
        $locale = $this->getLocaleByCountryCode($studentData->userDetails->country_code);

        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/billing/subscriptions", [
                'plan_id' => $payPalPlanId,
                'custom_id' => json_encode(
                    [
                        'plan_id' => $planId,
                        'user_id' => Auth::user()->id
                    ]
                ),
                'application_context' => [
                    'brand_name' => 'i-Fal',
                    'locale' => $locale,
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'return_url' => config('services.paypal.redirect_url.return_url'),
                    'cancel_url' => config('services.paypal.redirect_url.cancel_url')
                ]
            ]);

        if (!$response->successful()) {
            throw new CouldNotCreateSubscription("Failed to create subscription: " . $response->body());
        }
        $approvalUrl = collect($response['links'])->where('rel', 'approve')->first()['href'];

        return [
            'paypal_subscription_id' => $response['id'],
            'approval_url' => $approvalUrl,
        ];
    }

    public function cancelSubscription($paypalSubscriptionId): void
    {
        $subscription = Subscription::where('paypal_subscription_id', $paypalSubscriptionId)
            ->where('is_active', true)
            ->firstOrFail();

        $subscription->update(['is_active' => false]);
    }

    public function validateWebhookEvent($webhookEventId) : bool
    {
        $response = Http::withToken($this->getAccessToken())
            ->get("https://api.paypal.com/v1/notifications/webhooks-events/{$webhookEventId}");

        return $response->successful();
    }

    function getLocaleByCountryCode($countryCode) {
        $mapping = config('locale.country_to_locale', []);
        $default = config('locale.default', 'en-US');

        return $mapping[$countryCode] ?? $default;
    }
}
