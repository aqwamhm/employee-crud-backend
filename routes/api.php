<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Middleware\CheckSuperadmin;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function() {
    Route::get('/positions', [PositionController::class, 'index']);

    Route::get('/employees/sortedBySalary', [EmployeeController::class, 'sortedBySalary'])->middleware(CheckSuperadmin::class);
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'create']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::get('/auth/verifyToken', [AuthController::class, 'verifyToken']);
Route::post('/auth/login', [AuthController::class, 'login']);
