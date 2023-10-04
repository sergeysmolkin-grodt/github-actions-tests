<?php

use App\Http\Controllers\API\UserAuthenticationController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AutoScheduleController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\CronController;
use Twilio\Rest\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Register, login, OAuth
Route::group(['prefix' => 'auth', 'controller' => UserAuthenticationController::class], function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
    Route::post('forgot-password', 'forgotPassword')->name('password.email');
    Route::post('reset-password', 'resetPassword')->name('password.update');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::post('/request-verification', [UserAuthenticationController::class, 'sendVerificationCode']);
    Route::post('/verify-code', [UserAuthenticationController::class, 'verifyCode']);
});

Route::group(['middleware' => ['auth:sanctum']],  function() {
    Route::apiResource('users', UserController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::post('become-teacher', [UserController::class, 'becomeTeacher']);
    Route::post('auto-schedule-time', [AutoScheduleController::class, 'store']);
    Route::put('auto-schedule-time/{user_id}', [AutoScheduleController::class, 'update']);
    Route::delete('auto-schedule-time/{user_id}', [AutoScheduleController::class, 'destroy']);
    Route::post('appointments/cancel-auto-scheduled', [AppointmentController::class, 'cancelAutoScheduled']);
});

// Cron
Route::prefix('cron')->group(function () {
    Route::any('{route}', CronController::class);
});
