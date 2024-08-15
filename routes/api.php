<?php

use App\Http\Controllers\Companies\CompaniesController;
use App\Http\Controllers\Employees\EmployeesController;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// sanctum api protect
Route::middleware('auth:sanctum', 'throttle:api')->group(function () {

    // Employees


});

Route::apiResource('companies', CompaniesController::class);
Route::apiResource('employees', EmployeesController::class);
