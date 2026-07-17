<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CvController;

// Mengarahkan halaman utama (/) ke ProjectController pada method 'index'
Route::get('/', [ProjectController::class, 'index'])->name('home');

// Route untuk menangani unduhan CV secara dinamis (generate dari database via dompdf)
Route::get('/download-cv', [CvController::class, 'download'])->name('download.cv');

// Route untuk menangani submit form kontak (dengan rate limiting anti-spam)
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
