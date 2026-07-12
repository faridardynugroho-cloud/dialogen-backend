<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FeedbackController as AdminFeedbackController;

Route::prefix('/')->name('legal.')->group(function () {
    Route::get('about', [LegalController::class, 'about'])->name('about');
    Route::get('privacy-policy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('terms', [LegalController::class, 'terms'])->name('terms');

    Route::get('feedback', [LegalController::class, 'feedbackForm'])->name('feedback');
    Route::post('feedback', [LegalController::class, 'feedbackSubmit'])
        ->name('feedback.submit')
        ->middleware('throttle:5,1'); // batasi 5 submit per menit per IP, cegah spam
});

// ==============================
// Admin — Login (tanpa auth middleware)
// ==============================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])
        ->name('login')
        ->middleware('throttle:10,1');
    Route::post('login', [AdminAuthController::class, 'login'])
        ->name('login.submit')
        ->middleware('throttle:10,1');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// ==============================
// Admin — Halaman terproteksi
// ==============================
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::patch('feedback/{feedback}/status', [AdminFeedbackController::class, 'updateStatus'])->name('feedback.updateStatus');
    Route::delete('feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');
});
