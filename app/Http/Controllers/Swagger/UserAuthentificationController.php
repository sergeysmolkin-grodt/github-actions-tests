<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     summary="Register Users",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="firstname", type="string", example="Anna"),
 *             @OA\Property(property="lastname", type="string", example="Ivanova"),
 *             @OA\Property(property="email", type="string", example="a.ivanova123@gmail.com"),
 *             @OA\Property(property="password", type="string", example="pass123"),
 *             @OA\Property(property="mobile", type="string", example="+380661234567"),
 *             @OA\Property(property="ageGroup", type="string", example="adult"),
 *             @OA\Property(property="birthDate", type="string", example="1990-06-15"),
 *             @OA\Property(property="gender", type="string", example="female"),
 *             @OA\Property(property="loginType", type="string", example="NORMAL"),
 *             @OA\Property(property="countryCode", type="string", example="UA"),
 *             @OA\Property(property="role", type="string", example="student"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created User object",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=5),
 *             @OA\Property(property="firstname", type="string", example="Anna"),
 *             @OA\Property(property="lastname", type="string", example="Ivanova"),
 *             @OA\Property(property="email", type="string", example="a.ivanova123@gmail.com"),
 *             @OA\Property(property="profile_image", type="string", nullable=true),
 *             @OA\Property(property="is_active", type="boolean", nullable=true),
 *             @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true),
 *             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *             @OA\Property(property="remember_token", type="string", nullable=true),
 *             @OA\Property(
 *                 property="role",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=5),
 *                     @OA\Property(property="name", type="string", example="student"),
 *                     @OA\Property(property="guard_name", type="string", example="web"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-11T07:16:56.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-11T07:16:56.000000Z"),
 *                     @OA\Property(
 *                         property="pivot",
 *                         type="object",
 *                         @OA\Property(property="model_id", type="integer", example=5),
 *                         @OA\Property(property="role_id", type="integer", example=5),
 *                         @OA\Property(property="model_type", type="string", example="App\\Models\\User")
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 * )
 *
 * @OA\Post(
 *      path="/api/auth/login",
 *      summary="Login Users",
 *      tags={"Authentication"},
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property(property="email", type="string", example="a.ivanova123@gmail.com"),
 *              @OA\Property(property="password", type="string", example="pass123"),
 *              @OA\Property(property="loginType", type="string", example="NORMAL"),
 *              @OA\Property(property="deviceType", type="string", example="tablet", nullable=true),
 *              @OA\Property(property="OSVersion", type="string", example="16.2", nullable=true),
 *              @OA\Property(property="deviceToken", type="string", example="mbiDmobMRlhnDYMZa9", nullable=true),
 *              @OA\Property(property="brand", type="string", example="Apple", nullable=true),
 *              @OA\Property(property="model", type="string", example="iPhone 11", nullable=true),
 *              @OA\Property(property="deviceId", type="string", example="5893590235803", nullable=true)
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Logged in User object and Created API Token",
 *          @OA\JsonContent(
 *              @OA\Property(property="user", ref="#/components/schemas/User"),
 *              @OA\Property(property="token", type="string", example="1|laravel_sanctum_hBEi8VPgE28bXfmYhjjRcF0stKod4Aqn6lkt6egW4945d232")
 *          )
 *      ),
 *  )
 *
 * @OA\Schema(
 *      schema="User",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="firstname", type="string", example="Anna"),
 *      @OA\Property(property="lastname", type="string", example="Ivanova"),
 *      @OA\Property(property="email", type="string", example="a.ivanova123@gmail.com"),
 *      @OA\Property(property="profile_image", type="string", nullable=true),
 *      @OA\Property(property="is_active", type="integer", example=1),
 *      @OA\Property(property="deleted_at", type="string", nullable=true),
 *      @OA\Property(property="email_verified_at", type="string", nullable=true),
 *      @OA\Property(property="remember_token", type="string", nullable=true),
 *      @OA\Property(
 *          property="role",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Role")
 *      )
 *  )
 *
 * @OA\Schema(
 *      schema="Role",
 *      @OA\Property(property="id", type="integer", example=5),
 *      @OA\Property(property="name", type="string", example="student"),
 *      @OA\Property(property="guard_name", type="string", example="web"),
 *      @OA\Property(property="created_at", type="string", example="2023-09-12T05:33:27.000000Z"),
 *      @OA\Property(property="updated_at", type="string", example="2023-09-12T05:33:27.000000Z"),
 *      @OA\Property(
 *          property="pivot",
 *          type="object",
 *          @OA\Property(property="model_id", type="integer", example=1),
 *          @OA\Property(property="role_id", type="integer", example=5),
 *          @OA\Property(property="model_type", type="string", example="App\\Models\\User")
 *      )
 *  )
 *
 * @OA\Post(
 *       path="/api/auth/request-verification",
 *       operationId="sendVerificationCode",
 *       tags={"Authentication"},
 *       summary="Request a verification code",
 *       description="Sends a verification code to the given phone number",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               required={"phone_number"},
 *               @OA\Property(property="phone_number", type="string", format="string", example="+380685469492")
 *           ),
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful operation",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Verification code has been sent")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="The phone number field format is invalid.")
 *           )
 *       )
 *  )
 *
 * @OA\Post(
 *       path="/api/auth/verify-code",
 *       operationId="verifyCode",
 *       tags={"Authentication"},
 *       summary="Verify the code sent to the phone",
 *       description="Verifies the code sent to the phone number",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               required={"phone_number", "code"},
 *               @OA\Property(property="phone_number", type="string", format="string", example="+380689269492"),
 *               @OA\Property(property="code", type="string", format="string", example="123456")
 *           ),
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful operation",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Phone number verified successfully")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               @OA\Property(property="error", type="string", example="Invalid code")
 *           )
 *       )
 *  )
 *
 * @OA\Post(
 *       path="/api/auth/logout",
 *       operationId="logoutUser",
 *       tags={"Authentication"},
 *       summary="Log out",
 *       description="Logs out the current user by invalidating the token",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               required={"token"}
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful operation",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Logged out successfully")
 *           )
 *       ),
 *       @OA\Response(
 *           response=401,
 *           description="Unauthorized",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Unauthenticated.")
 *           )
 *       ),
 *       security={
 *           {"bearerAuth": {}}
 *       }
 *  )
 *
 * @OA\Post(
 *       path="/api/auth/forgot-password",
 *       operationId="forgotPassword",
 *       tags={"Authentication"},
 *       summary="Forgot Password",
 *       description="Sends a password reset link to the provided email",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               required={"email"},
 *               @OA\Property(property="email", type="string", format="email", description="The email of the user", example="user@example.com")
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful operation",
 *           @OA\JsonContent(
 *               @OA\Property(property="status", type="string", example="We have emailed your password reset link.")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               @OA\Property(property="error", type="string", example="We can't find a user with that email address.")
 *           )
 *       )
 *  )
 *
 * @OA\Post(
 *       path="/api/auth/reset-password",
 *       operationId="resetPassword",
 *       tags={"Authentication"},
 *       summary="Reset Password",
 *       description="Resets the user's password using a valid reset token",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               required={"token", "email", "password", "password_confirmation"},
 *               @OA\Property(property="token", type="string", description="Password reset token", example="sometoken"),
 *               @OA\Property(property="email", type="string", format="email", description="The email of the user", example="user@example.com"),
 *               @OA\Property(property="password", type="string", format="password", description="The new password", example="newPassword123"),
 *               @OA\Property(property="password_confirmation", type="string", format="password", description="The new password confirmation", example="newPassword123")
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful operation",
 *           @OA\JsonContent(
 *               @OA\Property(property="status", type="string", example="Your password has been reset.")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               @OA\Property(property="error", type="string", example="This password reset token is invalid.")
 *           )
 *       )
 *  )
 */
class UserAuthentificationController extends Controller
{
    //
}
