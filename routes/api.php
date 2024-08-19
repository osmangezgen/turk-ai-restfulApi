<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\Companies\CompaniesController;
use App\Http\Controllers\Employees\EmployeesController;
use App\Models\Employees;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// auth
Route::post('login', [authController::class, "login"]);
Route::post('logout', [authController::class, "logout"]);

// sanctum api protect
Route::middleware('auth:sanctum', 'throttle:30,1')->group(function () {

    // Companies
    Route::apiResource('companies', CompaniesController::class);
    Route::get('companies-read', [CompaniesController::class, 'getAllCompanies']);
    Route::get('companies-search', [CompaniesController::class, 'search']);

    // Employees
    Route::apiResource('employees', EmployeesController::class);
    Route::get('employees-search', [EmployeesController::class, 'search']);

});


