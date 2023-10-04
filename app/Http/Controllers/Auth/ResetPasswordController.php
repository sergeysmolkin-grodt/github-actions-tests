<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function resetForm(Request $request, $token): JsonResponse|ViewFactory|View
    {

        $validated = $request->validate(['email' => 'required|email']);

        $hashedToken = PasswordResetToken::where('email', $validated['email'])->first();
        if(!Hash::check($token, $hashedToken->token)) {
            return $this->respondUnAuthenticated(__('Reset password token is not valid'));
        }

        $role = $this->userRepository->getRoleByEmail($validated['email']);

        return view('auth.reset-password', ['token' => $token, 'email' => $validated['email'], 'role' => $role]);
    }
}
