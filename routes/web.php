<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');


Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::resource('users', UserController::class);

Route::resource('vehiculos', VehicleController::class);
Route::resource('mantenimientos', MaintenanceController::class);

Route::get('/reports/availability',   [ReportController::class, 'availability'])->name('reports.availability');
Route::get('/reports/fleet-usage',    [ReportController::class, 'fleetUsage'])->name('reports.fleet-usage');
Route::get('/reports/driver-history', [ReportController::class, 'driverHistory'])->name('reports.driver-history');