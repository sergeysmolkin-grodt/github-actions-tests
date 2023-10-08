<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ScheduleTimeRequest;
use App\Interfaces\AutoScheduleRepositoryInterface;
use App\Jobs\Cron\ProcessStudentAutoSchedule;
use App\Services\AutoScheduleService;
use App\Traits\DateTimeTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Subscription;

class AutoScheduleController extends Controller
{
    use DateTimeTrait;

    public function __construct(
        protected AutoScheduleService $autoScheduleService,
        protected AutoScheduleRepositoryInterface $autoScheduleRepository,
    )
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleTimeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $this->autoScheduleService->setAutoScheduleTime($validated);

           // $this->createUpcomingSubscription();

            $processors = config('processors');
            $processor = app($processors['processStudentAutoSchedule']);
            $processor::dispatch($request);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess(['message' => __("Auto schedule set successfully")]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleTimeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->autoScheduleService->logAndRemoveAutoScheduleTime($validated['userId']);

        try {
            $this->autoScheduleService->setAutoScheduleTime($validated);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess(['message' => __("Auto schedule update successfully")]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId): JsonResponse
    {
        if (! is_null($deletedResponse = $this->autoScheduleRepository->remove($userId))) {
            return $this->respondError($deletedResponse);
        }

        return $this->respondWithSuccess(['message' => __('Auto schedule removed successfully.')]);
    }
}
