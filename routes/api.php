<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\SystemRegistration\PatientRegistrationController;
use App\Http\Middleware\CheckTokenValidity;
use App\Http\Controllers\Patient\PatientInfoController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route :: post("login", [LoginController::class, 'GetLoginInfo']);
Route :: post("patient/registration", [PatientRegistrationController::class, 'CreatePatient']);

Route::middleware(CheckTokenValidity::class)->group(function () {
    Route :: get("patient/about/{uid}", [PatientInfoController::class, 'GetUserById']);
});

