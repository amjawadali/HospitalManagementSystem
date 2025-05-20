<?php

use App\Http\Controllers\AppointmentConrolller;
use App\Http\Controllers\Patient\PatientConsultationController;
use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::prefix('patient')->controller(AppointmentConrolller::class)->group(function () {
        // Route::get('/', 'index')->name('Paitent.schedule.index');
        // Route::get('/{Paitent}/schedule', 'show')->name('Paitents.schedule.show');
        // Route::post('/{Paitent}/schedule', 'store')->name('Paitents.schedule.store');
        // Route::get('/{Paitent}/schedule/slots', 'getSlots')->name('Paitents.schedule.slots');
        // Route::post('/{Paitent}/schedule/slots', 'updateSlots')->name('Paitents.schedule.slots.update');

        Route::get('/appointments/events/{doctor}','getDoctorEvents')->name('patient.appointment.list');
        Route::post('/appointment/store', 'store')->name('patient.appointment.store');
    });

    Route::prefix('appointment')->controller(AppointmentConrolller::class)->group(function () {
        Route::get('/availability', 'availability')->name('appointment.availability');
        Route::get('/checkin/{id}', 'checkin')->name('appointment.checkin');
        Route::get('/list', 'list')->name('appointment.list');
        Route::get('/approve/list', 'approvedList')->name('appointment.approve.list');
        Route::post('/update/status/{id}', 'UpdateAppointmentStatus')->name('appointment.updatestatus');
        Route::post('/appointment/checkin', 'PatientCheckin')->name('patient.checkin');
    });

    Route::prefix('patient')->controller(PatientController::class)->group(function () {
        Route::get('/index', 'index')->name('patient.index');
        Route::get('/create', 'create')->name('patient.create');
        Route::post('/store', 'store')->name('patient.store');
        Route::get('/edit/{id}', 'edit')->name('patient.edit');
        Route::get('/medical/history/{id}', 'medicalHistory')->name('patient.medical.history');
        Route::post('/update/{id}', 'update')->name('patient.update');
        Route::delete('/delete/{id}', 'destroy')->name('patient.destroy');
    });

    Route::prefix('consultation')->controller(PatientConsultationController::class)->group(function () {
        Route::get('/checkin', 'checkinPatient')->name('consultation.checkin');
        Route::get('/prescription/{id}', 'prescription')->name('consultation.prescription');
        Route::get('/checkup/{id}', 'checkup')->name('consultation.checkup');
        Route::post('/store', 'store')->name('consultation.store');
    });


});

require __DIR__.'/auth.php';
