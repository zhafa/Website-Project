<?php

/** 
 * API Route
 *
 * Route ini menyediakan endpoint API untuk mengelola app
 * menggunakan prosedur tersimpan di database.
 *
 * API yang ada:
 * 
 * // AUTHENTICATION
 * - POST api/login             [AuthController][email, password]
 * - POST api/logout            [AuthController][token]
 *
 * // USER
 * - GET api/user               [AuthController][token]
 * - GET api/users              [AuthController][token]
 * 
 * 
 **/

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Auth\AndroidForgotPasswordController;
use App\Http\Controllers\API\Auth\AndroidResetPasswordController;
use App\Http\Controllers\API\Auth\AndroidVerifyOtpController;

use App\Http\Controllers\API\User\ProfileController;

// API Route
Route::name('api.')->group(function () {
    // AUTHENTICATION
    Route::post('login', [AuthController::class, 'login'])->middleware('guest')->name('login');

    // WITH MIDDLEWARE
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // user routes (harus login)
        Route::name('user.')->group(function () {
            Route::get('user', [UserController::class, 'show'])->name('show'); // ambil user yang login
            Route::get('users', [UserController::class, 'index'])->name('index'); // ambil semua user
            Route::post('user', [UserController::class, 'store'])->name('store'); // buat user baru
            Route::put('user', [UserController::class, 'update'])->name('update'); // update user
            Route::delete('user', [UserController::class, 'destroy'])->name('destroy'); // hapus user
        });

        // PROFILE
        Route::name('profile.')->group(function () {
            Route::get('profile', [ProfileController::class, 'show'])->name('show'); // ambil user yang login
            Route::put('profile', [ProfileController::class, 'update'])->name('update'); // update user
            Route::put('profile/employee', [ProfileController::class, 'updateEmployee'])->name('updateEmployee'); // update employee
        });
    });

    // --- Mulai Baris Kode Android -----
    
    Route::post('/android/forgot-password', [AndroidForgotPasswordController::class, 'forgotPassword']);
    Route::post('/android/reset-password', [AndroidResetPasswordController::class, 'resetPassword']);
    Route::post('/android/request-otp', [AndroidForgotPasswordController::class, 'requestOtp']);
    Route::post('/android/verify-otp', [AndroidVerifyOtpController::class, 'verifyOtp']);











    // GLOBAL
    // Route::get('/profile', [ApiController::class, 'profile'])->middleware('auth:sanctum');

    // HUMAN RESOURCE
    // Route::group(['prefix' => 'humanresource', 'as' => 'humanresource.', 'middleware' => ['auth:sanctum', 'can:isHumanResource']], function () {
    //     Route::get('/', [HumanResourceHome::class, 'index'])->name('home');

    //     Route::prefix('employee')->name('employee.')->group(function () {
    //         Route::get('/', [HumanResourceEmployee::class, 'index'])->name('index');
    //         Route::get('/show/{employee}', [HumanResourceEmployee::class, 'show'])->name('show');
    //         Route::get('/create', [HumanResourceEmployee::class, 'create'])->name('create');
    //         Route::post('/store', [HumanResourceEmployee::class, 'store'])->name('store');
    //         Route::get('/edit/{employee}', [HumanResourceEmployee::class, 'edit'])->name('edit');
    //         Route::put('/update/{employee}', [HumanResourceEmployee::class, 'update'])->name('update');
    //         Route::delete('/destroy/{employee}', [HumanResourceEmployee::class, 'destroy'])->name('destroy');
    //     });
    // });
});
