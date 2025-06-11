<?php

use App\Http\Controllers\Admin\AdminAddressController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\DoctorPanelController;
use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Appointment\AppointmentShowController;
use App\Http\Controllers\Appointment\AppointmentUpdateController;
use App\Http\Controllers\Appointment\DoctorController;
use App\Http\Controllers\Appointment\HospitalController;
use App\Http\Controllers\Appointment\LocationController;
use App\Http\Controllers\Appointment\ScheduleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get("/",[IndexController::class,'index']);
Route::get("/contact",[ContactController::class,'index']);
Route::post("/contact",[ContactController::class,'store']);

Route::get("/appointment",[AppointmentController::class,'index']);
Route::post("/appointment",[AppointmentController::class,'store']);
Route::get("/appointment-show",[AppointmentShowController::class,'index']);
Route::post("/appointment-show",[AppointmentShowController::class,'update']);
Route::get('/get-districts', [LocationController::class, 'getDistrictsByCity']);
Route::get('/get-hospital', [HospitalController::class, 'getHospitals']);
Route::get('/get-doctor', [DoctorController::class, 'getDoctor']);
Route::get('/get-doctor-schedule', [ScheduleController::class, 'getSchedule']);
Route::get('/doctor-panel', [DoctorPanelController::class, 'index'])->name('doctor.panel');
Route::get('/appointment-update', [AppointmentUpdateController::class, 'index']);
Route::put('/appointment-update/{appointmentId}', [AppointmentUpdateController::class, 'update']);

//update işlemleri yaparken put veya patch methotları kullanılır

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/log', [AdminLogsController::class, 'index']);
Route::get('/admin/appointment', [AdminAppointmentController::class, 'index']);
Route::get('/admin/appointments/{id}', [AdminAppointmentController::class, 'show']);
Route::put('/admin/appointments/{id}', [AdminAppointmentController::class, 'update']);
Route::delete('/admin/appointments/{id}', [AdminAppointmentController::class, 'destroy']);
Route::get('/admin/roles', [AdminRolesController::class, 'index']);
Route::post('/admin/roles', [AdminRolesController::class, 'store']);

require __DIR__.'/auth.php';
