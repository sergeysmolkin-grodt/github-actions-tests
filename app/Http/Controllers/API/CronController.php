<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

use function PHPUnit\Framework\isInstanceOf;

class CronController extends Controller
{
    public function __invoke(Request $request, string $route): Response|JsonResponse
    {
        $token = $request->bearerToken();
        if (!$token || ! PersonalAccessToken::findToken($token)) {
            return $this->respondUnAuthenticated('Unauthorized');
        }

        $processors = config('processors');
        if (! isset($processors[$route])) {
            Log::error("Job was not found for route $route");

            return $this->respondNotFound(__('Job was not found'));
        }

        /** @var App\Interfaces\ProcessCron $processor */
        $processor = app($processors[$route]);

        $processor::dispatch($request);

        Log::info("Job of processing student auto schedule (route $route) was dispatched");

        return $this->respondWithSuccess(['message' => __('Job of processing student auto schedule was dispatched')]);
    }
}
