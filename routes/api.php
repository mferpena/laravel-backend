<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/ok', function() {
    return "ok";
});
Route::post('/employee-registration', [EmployeeController::class, 'employeeRegistration']);
Route::put('/employee-edit/{id}', [EmployeeController::class, 'employeeEdit']);
Route::get('/employee-list', [EmployeeController::class, 'employeeList']);
Route::delete('/employee-deactivate/{id}', [EmployeeController::class, 'employeeDeactivation']);
