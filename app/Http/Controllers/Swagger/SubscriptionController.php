<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *       path="/api/subscription",
 *       summary="Create a new subscription",
 *       tags={"Subscription"},
 *       security={{"uniqueBearerAuth":{}}},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               @OA\Property(property="plan_id", type="string", example="1", description="The ID of the subscription plan")
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Subscription created successfully",
 *           @OA\JsonContent(
 *                @OA\Property(property="message", type="string", example="Subscription created successfully"),
 *                @OA\Property(property="paypal_subscription_id", type="string", example="I-4MJXMAR5RBVT"),
 *                @OA\Property(property="approval_url", type="string", example="https://www.sandbox.paypal.com/webapps/billing/subscriptions?ba_token=BA-7JH701934E382752P")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Invalid input",
 *           @OA\JsonContent(
 *                @OA\Property(property="message", type="string", example="The selected plan id is invalid."),
 *                @OA\Property(property="errors", type="object",
 *                    @OA\Property(property="planId", type="array", @OA\Items(type="string", example="The selected plan id is invalid."))
 *                )
 *           )
 *       )
 *   )
 */
class SubscriptionController extends Controller
{
    //
}
