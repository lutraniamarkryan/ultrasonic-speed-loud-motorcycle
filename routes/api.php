<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ViolationApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SystemLogApiController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

 Route::middleware('api.auth')->group(function () {

    Route::get('/violations', [ViolationApiController::class, 'index']);
    Route::get('/violations/{id}', [ViolationApiController::class, 'show']);

    Route::post('/violations', [ViolationApiController::class, 'store']);

    Route::put('/violations/{id}', [ViolationApiController::class, 'update']);
    Route::delete('/violations/{id}', [ViolationApiController::class, 'destroy']);
    Route::patch('/violations/{id}/resolve', [ViolationApiController::class, 'resolve']);

    Route::get('/logs', [SystemLogApiController::class, 'index']);
 });