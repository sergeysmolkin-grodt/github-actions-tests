<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * @param AppointmentService $appointmentService
     */
    public function __construct(protected AppointmentService $appointmentService)
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMonthWiseSessions(Request $request) : JsonResponse
    {
        if (!$request->teacherId) {
            return response()->json([
                'status' => 0,
                'message' => 'Error: teacherId is required',
            ], 400);
        }
        $chartData = $this->appointmentService->getMonthCompletedSessionsForTeacher($request->teacherId);

        return response()->json([
            'status' => '1',
            'message' => 'Chart data listed successfully',
            'data' => $chartData,
        ]);
    }
}
