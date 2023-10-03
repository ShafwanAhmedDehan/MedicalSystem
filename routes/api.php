<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\SystemRegistration\PatientRegistrationController;
use App\Http\Middleware\CheckTokenValidity;
use App\Http\Controllers\Patient\PatientInfoController;
use App\Http\Controllers\SystemRegistration\HospitalRegistrationController;
use App\Http\Controllers\SystemRegistration\DoctorRegistrationController;
use App\Http\Controllers\SystemVerification\EmailVerificationController;


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

Route::post("login", [LoginController::class, 'GetLoginInfo'])->name('login');
Route::get("/auth/verify-email/{verification_token}", [EmailVerificationController::class, 'verifyEmail'])->name('verify_email');
Route::post("patient/registration", [PatientRegistrationController::class, 'getRegister']);


Route::middleware(CheckTokenValidity::class)->group(function () {
    Route::get("logout", [LoginController::class, 'logout'])->name('logout');
    Route::get("patient/about/{uid}", [PatientInfoController::class, 'GetUserById']);
    Route::post("hospital/registration", [HospitalRegistrationController::class, 'CreateHospital']);
    Route::post("doctor/registration", [DoctorRegistrationController::class, 'CreateDoctor']);
  
});

