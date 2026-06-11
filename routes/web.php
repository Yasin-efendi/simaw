<?php

use App\Livewire\ManageGrades; // Import komponen Livewire kita
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Grup rute yang HANYA bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    // Rute Kustom Kita untuk Panel Guru
    Route::get('/grades', ManageGrades::class)->name('grades.manage');
});

require __DIR__.'/auth.php';