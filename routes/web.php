<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\DoctorScheduleController;
use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->prefix('admin')->controller(DoctorController::class)->group(function () {
    Route::get('doctor/index', 'index')->name('doctor.index');
    Route::get('doctor/create', 'create')->name('doctor.create');
    Route::post('doctor/store', 'store')->name('doctor.store');
    Route::get('doctor/edit/{id}', 'edit')->name('doctor.edit');
    Route::post('doctor/update/{id}', 'update')->name('doctor.update');
    Route::delete('doctor/delete/{id}', 'destroy')->name('doctor.destroy');
});


require __DIR__.'/auth.php';
