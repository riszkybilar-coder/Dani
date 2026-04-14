<?php

use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AspirasiController::class, 'index'])->name('pengaduan.index');
Route::get('/pengaduan', [AspirasiController::class, 'index'])->name('pengaduan.list');
Route::get('/pengaduan/{id}', [AspirasiController::class, 'show'])->name('pengaduan.show');

// Siswa routes (tanpa login)
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/form', [AspirasiController::class, 'create'])->name('form');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('store');
    
    // Edit untuk siswa
    Route::get('/edit/{id}', [AspirasiController::class, 'editUser'])->name('edit-form');
    Route::post('/verify/{id}', [AspirasiController::class, 'verifyNIS'])->name('verify-nis');
    Route::put('/update/{id}', [AspirasiController::class, 'updateUser'])->name('update');
});

// API untuk dropdown siswa
Route::get('/api/siswa', [AspirasiController::class, 'getSiswa'])->name('api.siswa');

// Admin routes (dengan middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Aspirasi untuk admin
    Route::get('/aspirasi/{id}/edit', [AspirasiController::class, 'editAdmin'])->name('aspirasi.edit');
    Route::put('/aspirasi/{id}', [AspirasiController::class, 'updateAdmin'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy'])->name('aspirasi.destroy');
    
    // Update status cepat (AJAX)
    Route::patch('/aspirasi/{id}/status', [AdminController::class, 'updateStatus'])->name('aspirasi.status');
});
