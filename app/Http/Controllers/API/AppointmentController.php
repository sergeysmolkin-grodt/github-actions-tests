<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\AppointmentData;
use App\Exceptions\CouldNotBookAppointment;
use App\Exceptions\CouldNotCancelAutoScheduledAppointments;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BookAppointmentRequest;
use App\Interfaces\AppointmentRepositoryInterface;
use App\Services\AppointmentService;
use App\Traits\DateTimeTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\API\IfalApiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    use DateTimeTrait;

    public function __construct(
        protected AppointmentService $appointmentService,
        protected AppointmentRepositoryInterface $appointmentRepository
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
     * Store a newly created resource in storage.
     */
    public function store(BookAppointmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $appointmentId = $this->appointmentService->bookAppointment(
                new AppointmentData(
                    userId: Auth::user()->id,
                    teacherId: $validated['teacherId'],
                    date: $validated['date'],
                    startTime: $validated['startTime'],
                    isAutoScheduleSession: false
                )
            );
        } catch (CouldNotBookAppointment $e) {
            Log::error($e->getMessage());
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess([
            'message' => __('Your session booked successfully'),
            'appointmentId' => $appointmentId
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if (!$this->appointmentRepository->cancelAppointment($id)) {
            return response()->json(['error' => "Appointment with ID $id not found"], 404);
        }
        return $this->respondWithSuccess([
            'message' => __('Your session cancelled successfully'),
            'id' => $id
        ]);
    }

    public function cancelAutoScheduled(IfalApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $studentId = $validated['userId'];

        try {
            $this->appointmentService->cancelAutoScheduledAppointments(
                studentId: $studentId
            );
        } catch (CouldNotCancelAutoScheduledAppointments $e) {
            Log::error("Could Not Cancel AutoScheduled Appointments for student ID $studentId due error: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess([
            'message' => __('Sessions Cancelled'),
        ]);
    }
}
