<?php

use App\Http\Controllers\AuthController;
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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
