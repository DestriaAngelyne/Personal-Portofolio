<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;

// Mengarahkan halaman utama (/) ke ProjectController pada method 'index'
Route::get('/', [ProjectController::class, 'index'])->name('home');

// Route untuk menangani unduhan file CV secara aman (Sudah Diperbaiki + Anti-Cache)
Route::get('/download-cv', function () {
    $filePath = public_path('files/CV_ANGELYNE.pdf');

    if (file_exists($filePath)) {
        $response = response()->download($filePath, 'CV_Destria_Angelyne.pdf');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    abort(404, 'File CV tidak ditemukan.');
})->name('download.cv');

// Route untuk menangani submit form kontak (dengan rate limiting anti-spam)
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
