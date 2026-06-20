<?php

use App\Http\Controllers\Auth\EmailVerificationCodeController;
use App\Http\Controllers\CustomerProfileController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::get('verify-email', [EmailVerificationCodeController::class, 'create'])->name('verification.code.notice');
Route::post('verify-email', [EmailVerificationCodeController::class, 'store'])
    ->middleware('throttle:verification-code')
    ->name('verification.code.store');
Route::post('verify-email/resend', [EmailVerificationCodeController::class, 'resend'])
    ->middleware('throttle:verification-code')
    ->name('verification.code.resend');

Route::middleware(['auth'])->group(function () {
    Route::get('customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::post('customer/profile/skip', [CustomerProfileController::class, 'skip'])->name('customer.profile.skip');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
