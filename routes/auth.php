<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\LoginAsistenController;
use App\Http\Controllers\Auth\LoginPraktikanController;
use App\Http\Controllers\Auth\PasswordAsistenController;
use App\Http\Controllers\Auth\PasswordPraktikanController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredAsistenController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\RegisteredPraktikanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    // Route::post('register/asisten', [RegisteredAsistenController::class, 'store']);

    Route::post('login/asisten', [LoginAsistenController::class, 'store']);
});

Route::prefix('asisten')->group(function () {

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware(['auth:sanctum', 'ability:change-password']);

    Route::put('password', [PasswordAsistenController::class, 'update'])->name('password.update')->middleware(['auth:sanctum', 'ability:change-password']);

    Route::post('logout', [LoginAsistenController::class, 'destroy'])
        ->name('logout.req.asisten')->middleware(['auth:sanctum', 'ability:logout']);
});


Route::middleware('guest')->group(function () {
    // Route::post('register/praktikan', [RegisteredPraktikanController::class, 'store']);

    Route::post('login/praktikan', [LoginPraktikanController::class, 'store']);
});

Route::prefix('praktikan')->group(function () {

    Route::put('password', [PasswordPraktikanController::class, 'update'])->name('password.update')->middleware(['auth:sanctum', 'ability:ganti-password']);

    Route::post('logout', [LoginPraktikanController::class, 'destroy'])
        ->name('logout.req.praktikan')->middleware(['auth:sanctum', 'ability:logout-praktikan']);
});
