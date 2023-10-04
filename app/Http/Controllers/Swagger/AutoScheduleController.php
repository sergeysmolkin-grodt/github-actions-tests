<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/auto-schedule-time",
 *     tags={"Auto Schedule"},
 *     summary="Create a new auto-schedule entry",
 *     description="Create a new auto-schedule entry with date and time details",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="autoScheduleDate",
 *                 type="string",
 *                 example="2023-09-21",
 *                 description="The date for which the auto-schedule is set"
 *             ),
 *             @OA\Property(
 *                 property="timeDetails",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(
 *                         property="teacherId",
 *                         type="integer",
 *                         example=1
 *                     ),
 *                     @OA\Property(
 *                         property="day",
 *                         type="string",
 *                         example="monday"
 *                     ),
 *                     @OA\Property(
 *                         property="time",
 *                         type="string",
 *                         example="12:00"
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Auto-schedule created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Auto schedule set successfully"
 *             )
 *         )
 *     ),
 * )
 */
class AutoScheduleController extends Controller
{
    //
}
