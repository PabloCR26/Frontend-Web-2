<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;

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
Route::resource('solicitudes', RequestController::class);
Route::resource('viajes', TripController::class);
Route::resource('rutas', RouteController::class);

Route::get('/reports/availability',   [ReportController::class, 'availability'])->name('reports.availability');
Route::get('/reports/fleet-usage',    [ReportController::class, 'fleetUsage'])->name('reports.fleet-usage');
Route::get('/reports/driver-history', [ReportController::class, 'driverHistory'])->name('reports.driver-history');

Route::patch('solicitudes/{id}/approve', [RequestController::class, 'approve'])
    ->name('solicitudes.approve');

Route::patch('solicitudes/{id}/reject', [RequestController::class, 'reject'])
    ->name('solicitudes.reject');

Route::patch('solicitudes/{id}/cancel', [RequestController::class, 'cancel'])
    ->name('solicitudes.cancel');