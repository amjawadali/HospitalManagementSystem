<?php

use App\Http\Controllers\Doctor\DoctorPreferenceController;
use App\Http\Controllers\Doctor\DoctorScheduleController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('dashboard');
});

Route::middleware('auth')->prefix('doctor')->controller(DoctorScheduleController::class)->group(function () {
    // Route::get('/', 'index')->name('doctor.schedule.index');
    // Route::get('/{doctor}/schedule', 'show')->name('doctors.schedule.show');
    // Route::post('/{doctor}/schedule', 'store')->name('doctors.schedule.store');
    // Route::get('/{doctor}/schedule/slots', 'getSlots')->name('doctors.schedule.slots');
    // Route::post('/{doctor}/schedule/slots', 'updateSlots')->name('doctors.schedule.slots.update');

    Route::get('/schedule/create', 'create')->name('doctor.schedule.create');
    Route::get('/schedule/list', 'list')->name('doctor.schedule.list');

    Route::post('/schedule/store', 'store')->name('doctor.schedule.store');
});


require __DIR__.'/auth.php';
