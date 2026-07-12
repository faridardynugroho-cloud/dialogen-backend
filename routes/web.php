<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalController;

Route::prefix('/')->name('legal.')->group(function () {
    Route::get('about', [LegalController::class, 'about'])->name('about');
    Route::get('privacy-policy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('terms', [LegalController::class, 'terms'])->name('terms');

    Route::get('feedback', [LegalController::class, 'feedbackForm'])->name('feedback');
    Route::post('feedback', [LegalController::class, 'feedbackSubmit'])
        ->name('feedback.submit')
        ->middleware('throttle:5,1'); // batasi 5 submit per menit per IP, cegah spam
});