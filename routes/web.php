<?php

use App\Http\Controllers\Panel\ChartController;
use App\Http\Controllers\Panel\TeacherAvailabilityController;
use App\Http\Controllers\Panel\TeacherAvailabilityExceptionController;
use App\Http\Controllers\Panel\TeacherOptionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\LoginController;
use App\Http\Controllers\Panel\AdminController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\StudentController;
use App\Http\Controllers\Panel\TeacherController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Panel\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']],  function() {
    Route::get('/admin-home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/student', [StudentController::class, 'index']);
    Route::get('/student/edit/{id}', [StudentController::class, 'edit']);
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/export/{format}', [StudentController::class, 'export']);
    Route::delete('/student/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::resource('/teachers', TeacherController::class);
    Route::resource('/teacher-details', TeacherOptionsController::class);
    Route::resource('companies', CompanyController::class);
    Route::post('/get-month-wise-sessions', [ChartController::class, 'getMonthWiseSessions']);
    Route::get('/teachers/{id}/availabilities', [TeacherAvailabilityController::class, 'show']);
    Route::put('/teachers/{id}/availabilities/edit', [TeacherAvailabilityController::class, 'edit']);
    Route::post('/teacher/availabilities/exceptions', [TeacherAvailabilityExceptionController::class, 'store']);
    Route::post('/teacher/availabilities/exceptions/delete', [TeacherAvailabilityExceptionController::class, 'delete']);
    Route::post('/teacher/availability/holidays', [TeacherAvailabilityExceptionController::class, 'storeHoliday']);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->middleware('guest')->name('password.reset');

// OAuth with Socialite
Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::group(['prefix' => 'admin_user'], function () {
    Route::post('/create', [AdminController::class, 'store']);
});

