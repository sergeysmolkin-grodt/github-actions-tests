<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\SMSVerificationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDetails;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Services\AuthService;


class UserAuthenticationController extends Controller
{
    use \App\Traits\FileTrait;

    protected $authService;

    public function __construct(
        AuthService $authService)
    {
        parent::__construct();
        $this->authService = $authService;

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if( ! is_null($registerStudentValidationResponse = $this->authService->registerStudentValidation($validated))) {
            return $this->respondError($registerStudentValidationResponse);
        }

        // Create User data
        if (($user = $this->authService->createUserData($validated)) === null) {
            return $this->respondError(__('The user has not been created'));
        }

        // If signup via social
        if (in_array(strtolower($validated['loginType']), config('app.oauth_providers'))) {
            // Create a new social media provider entry for the user if not exists
            $this->userRepository->getUserProviderOrCreate($user->id, $validated['socialLoginId'], strtolower($validated['loginType']));
        }

        // Upload profile image in the storage
        if (! empty($validated['profileImage'])) {
            $this->uploadFile($validated['profileImage']);
        }

        // ToDo: OTP verification
        // ToDo: add User to sendGrid
        // ToDo: WhatsApp notification

        // Assign role for new user
        $user->assignRole($validated['role']);



        // ToDo: form necessary response with user data

        return $this->respondWithSuccess(new UserResource($user));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $loginStudentValidationResponse = $this->authService->loginStudentValidation($validated);

        if (!($loginStudentValidationResponse instanceof User)) {
            return $this->respondError($loginStudentValidationResponse);
        }

        $user = $loginStudentValidationResponse;

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        if (!empty($validated['deviceId'])) {
            $this->authService->createUserDeviceData($validated, $user->id);
        }

        return $this->respondWithSuccess([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->respondWithSuccess(['status' => __($status)])
            : $this->respondError(__($status));
    }

    public function resetPassword(ResetPasswordRequest $request): string
    {
        $validated = $request->validated();

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $response = $status === Password::PASSWORD_RESET
            ? $this->respondWithSuccess(['status' => __($status)])
            : $this->respondError(__($status));

        return $response->getContent();
    }

    public function sendVerificationCode(Request $request)
    {
        $data = $request->validate(['phone_number' => 'required|regex:/^[\+0-9]+$/|min:10|max:17']);


        return $this->respondWithSuccess([
            'message' => 'Verification code has been sent'
        ]);
    }

    public function verifyCode(SMSVerificationRequest $request)
    {
        $data = $request->validated();

        return $this->respondWithSuccess([
            'message' => 'Phone number verified successfully'
        ]);
    }
}
