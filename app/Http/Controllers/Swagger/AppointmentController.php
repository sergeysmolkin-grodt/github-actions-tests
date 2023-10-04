<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/appointments",
 *     summary="Create a new appointment",
 *     description="This endpoint creates a new appointment. The following are the conditions required to book an appointment.
 *     In the teacher_options table, the can_be_booked field for teacher must be set to 1
 *     In the users table, both the teacher and the student must have their is_active field set to 1
 *     The appointment date cannot be set to a time that has already passed
 *     The teacher must have an record in the availability table for the date being booked, also is_available field in that table must also be set to 1",
 *     tags={"Appointments"},
 * @OA\RequestBody(
 *         description="Appointment data that needs to be created",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="teacherId", type="integer", example=1, description="The ID of the teacher for the appointment. Must be a valid teacher ID."),
 *             @OA\Property(property="date", type="string", example="2023-09-15", description="The date of the appointment in YYYY-MM-DD format. Cannot be a past date."),
 *             @OA\Property(property="startTime", type="string", example="16:00", description="The start time of the appointment in HH:mm format. Must be during teacher's working hours.")
 *         )
 *     ),
 * @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Your session booked successfully", description="Success message"),
 *             @OA\Property(property="appointmentId", type="integer", example=1, description="The ID of the newly created appointment")
 *         )
 *     )
 * )
 */
class AppointmentController extends Controller
{
    //
}
