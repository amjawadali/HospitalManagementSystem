<?php

use App\Http\Controllers\Management\BranchController;
use App\Http\Controllers\Management\DepartmentController;
use App\Http\Controllers\Management\DesignationController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\UserManagementController;
use Illuminate\Support\Facades\Route;
//fallback route


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::controller(UserManagementController::class)->group(function () {
        Route::get('management/users', 'index')->name('users.index');
        Route::post('management/user/store', 'store')->name('users.store');
        Route::post('management/user/update/{id}', 'update')->name('users.update');
        Route::get('management/user/edit/{id}', 'edit')->name('users.edit');
        Route::delete('management/users/delete/{id}', 'destroy')->name('users.destroy');
    });


    Route::controller(RoleController::class)->group(function () {
        Route::get('management/roles', 'index')->name('role.index')->middleware('permission:role.list');
        Route::post('management/role/store', 'store')->name('role.store')->middleware('permission:role.create');
        Route::post('management/role/update/{id}', 'update')->name('role.update')->middleware('permission:role.update');
        Route::get('management/role/edit/{id}', 'edit')->name('role.edit')->middleware('permission:role.update');
        Route::delete('management/roles/delete/{id}', 'destroy')->name('role.destroy')->middleware('permission:role.delete');
        Route::get('management/roles/get_data', 'get_data')->name('role.get_data')->middleware('permission:role.list');
    });

    Route::controller(BranchController::class)->group(function () {
        Route::get('management/branches', 'index')->name('branch.index')->middleware('permission:branch.list');
        Route::post('management/branch/store', 'store')->name('branch.store')->middleware('permission:branch.create');
        Route::post('management/branch/update/{id}', 'update')->name('branch.update')->middleware('permission:branch.update');
        Route::get('management/branch/edit/{id}', 'edit')->name('branch.edit')->middleware('permission:branch.update');
        Route::delete('management/branch/delete/{id}', 'destroy')->name('branch.destroy')->middleware('permission:branch.delete');
        Route::get('management/branches/get_data', 'get_data')->name('branch.get_data')->middleware('permission:branch.list');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('management/departments', 'index')->name('department.index')->middleware('permission:department.list');
        Route::post('management/department/store', 'store')->name('department.store')->middleware('permission:department.create');
        Route::post('management/department/update/{id}', 'update')->name('department.update')->middleware('permission:department.update');
        Route::get('management/department/edit/{id}', 'edit')->name('department.edit')->middleware('permission:department.update');
        Route::delete('management/department/delete/{id}', 'destroy')->name('department.destroy')->middleware('permission:department.delete');
        Route::get('management/departments/get_data', 'get_data')->name('department.get_data')->middleware('permission:department.list');
    });

    Route::controller(DesignationController::class)->group(function () {
        Route::get('management/designations', 'index')->name('designation.index')->middleware('permission:designation.list');
        Route::post('management/designation/store', 'store')->name('designation.store')->middleware('permission:designation.create');
        Route::post('management/designation/update/{id}', 'update')->name('designation.update')->middleware('permission:designation.update');
        Route::get('management/designation/edit/{id}', 'edit')->name('designation.edit')->middleware('permission:designation.update');
        Route::delete('management/designation/delete/{id}', 'destroy')->name('designation.destroy')->middleware('permission:designation.delete');
        Route::get('management/designations/get_data', 'get_data')->name('designation.get_data')->middleware('permission:designation.list');
    });


    Route::controller(PermissionController::class)->group(function () {
        Route::get('management/permissions', 'index')->name('permission.index')->middleware('permission:permission.list');
        Route::get('management/get/role/permission', 'get_role_permission')->name('permission.get_role');
        Route::post('management/permission_list', 'permission_list')->name('permission.list')->middleware('permission:permission.list');
        Route::post('management/assign_permission', 'assign_permission')->name('permission.assign')->middleware('permission:permission.create');
        Route::get('management/get_permission', 'get_permission')->name('get_permission')->middleware('permission:permission.list');
        Route::get('management/get_role_permission', 'get_role_permission')->name('get_role_permission')->middleware('permission:permission.list');
    });
});
require __DIR__ . '/auth.php';
