<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::controller(KaryawanController::class)->group(function () {
    Route::get('/karyawan', 'index')->name('karyawan.index');
    Route::post('/karyawan', 'store')->name('karyawan.store');
    Route::put('/karyawan/{id}', 'update')->name('karyawan.update');
    Route::delete('/karyawan/{id}', 'destroy')->name('karyawan.delete');
});

Route::controller(GajiController::class)->group(function () {
    Route::get('/gaji', 'index')->name('gaji.index');
    Route::post('/gaji', 'store')->name('gaji.store');
    Route::get('/gaji/{id_gaji}', 'show')->name('gaji.show');
    Route::put('/gaji/{id_gaji}', 'update')->name('gaji.update');
    Route::delete('/gaji/{id_gaji}', 'destroy')->name('gaji.destroy');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
