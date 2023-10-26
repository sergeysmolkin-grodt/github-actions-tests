<?php

use App\Http\Controllers\API\PayPalController;
use App\Http\Controllers\API\UserAuthenticationController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AutoScheduleController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\CronController;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Http\Controllers\API\TeacherVideoController;
use App\Http\Controllers\API\TeacherReviewController;

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
    Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
        Route::apiResource('/', 'UserController');
        Route::post('become-teacher', 'becomeTeacher');
        Route::get('reminders/options', 'getRemindersOptions');
        Route::post('reminders/options', 'setRemindersOptions');
    });

    Route::apiResource('appointments', AppointmentController::class);
    Route::post('appointments/cancel-auto-scheduled', [AppointmentController::class, 'cancelAutoScheduled']);

    Route::apiResource('auto-schedule-slots', AutoScheduleController::class);
    Route::apiResource('/teacher/video', TeacherVideoController::class);
    Route::apiResource('/teacher/review', TeacherReviewController::class);

    Route::post('/subscription', [PayPalController::class, 'createSubscription']);
    Route::resource('/teacher/video', TeacherVideoController::class);
    Route::resource('/teacher/review', TeacherReviewController::class);
});

Route::post('/webhooks/paypal', [PayPalController::class, 'handlePayPalWebhook']);

// Cron
Route::prefix('cron')->group(function () {
    Route::any('{route}', CronController::class);
});
