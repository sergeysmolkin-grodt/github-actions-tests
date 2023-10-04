<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\SecurityScheme(
 *      type="http",
 *      description="Laravel Sanctum Bearer Token",
 *      name="Bearer",
 *      in="header",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      securityScheme="bearerAuth"
 *  )
 *
 * @OA\Get(
 *     path="/api/users",
 *     summary="Get list of users with optional filters",
 *     tags={"Users"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         description="Filter users by email",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="phone",
 *         in="query",
 *         description="Filter users by phone",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="role",
 *         in="query",
 *         description="Filter users by role (e.g., teacher)",
 *         @OA\Schema(type="string", enum={"teacher", "student", "manager"})
 *     ),
 *     @OA\Parameter(
 *         name="time_availability",
 *         in="query",
 *         description="Filter teachers by time of day. Applicable if role is 'teacher'.",
 *         @OA\Schema(type="string", enum={"morning", "afternoon", "evening"})
 *     ),
 *     @OA\Parameter(
 *         name="day_availability",
 *         in="query",
 *         description="Filter teachers by availability days. Applicable if role is 'teacher'.",
 *         @OA\Schema(type="array", @OA\Items(type="string", enum={"monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"}))
 *     ),
 *     @OA\Parameter(
 *         name="gender",
 *         in="query",
 *         description="Filter teachers by gender. Applicable if role is 'teacher'.",
 *         @OA\Schema(type="string", enum={"male", "female"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
 *     )
 * )
 */
class UserController extends Controller
{
    //
}
