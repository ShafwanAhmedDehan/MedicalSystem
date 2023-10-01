<?php

use App\Http\Controllers\SystemRegistration\AdminRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckTokenValidity;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\Patient\PatientInfoController;
use App\Http\Controllers\SystemVerification\EmailVerificationController;
use App\Http\Controllers\SystemRegistration\DoctorRegistrationController;
use App\Http\Controllers\SystemRegistration\PatientRegistrationController;
use App\Http\Controllers\SystemRegistration\HospitalRegistrationController;


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


Route::middleware(CheckTokenValidity::class)->group(function () {
    Route :: get("patient/about/{uid}", [PatientInfoController::class, 'GetUserById']);
    Route :: post("hospital/registration", [HospitalRegistrationController::class, 'CreateHospital']);
    Route :: post("doctor/registration", [DoctorRegistrationController::class, 'CreateDoctor']);

    Route :: get("hospital/about/{adminID}", [HospitalController::class, 'getHospitalbyAdminId']);
    Route :: get("doctor/about/{uid}", [DoctorController::class, 'GetDoctorById']);
});


});
Route::post("admin/registration", [AdminRegistrationController::class, 'CreateAdmin']);

Route :: post("patient/registration", [PatientRegistrationController::class, 'getRegister']);
Route :: get("/auth/verify-email/{verification_token}", [EmailVerificationController::class, 'verifyEmail'])->name('verify_email');


