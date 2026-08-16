<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', [ViolationController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/violations/records', [ViolationController::class, 'recordsPanel'])
    ->name('violations.records');

Route::get('/analytics', [ViolationController::class, 'analyticsPanel']);

Route::get('/analytics/export', [ViolationController::class, 'exportCSV'])
    ->name('analytics.export'); 

Route::get('/simulate-violation', function () {

    \App\Models\Violation::create([
        'plate_number' => 'TEST-999',
        'violation_type' => 'Both',
        'recorded_speed' => 115,
        'decibel_level' => 104,
        'status' => 'Pending',
    ]);

    return "Successfully injected 1 new violation into MySQL.";
});

Route::get('/violations/create',
    [ViolationController::class, 'create'])
    ->name('violations.create');

Route::post('/violations',
    [ViolationController::class, 'store'])
    ->name('violations.store');

Route::get('/violations/{id}/edit',
    [ViolationController::class, 'edit'])
    ->name('violations.edit');

Route::put('/violations/{id}',
    [ViolationController::class, 'update'])
    ->name('violations.update');

Route::delete('/violations/{id}',
    [ViolationController::class, 'destroy'])
    ->name('violations.destroy');

Route::patch('/violations/{id}/resolve',
    [ViolationController::class, 'resolve'])
    ->name('violations.resolve');

Route::get('/logs', [ViolationController::class, 'recordsLogs'])
    ->name('logs');