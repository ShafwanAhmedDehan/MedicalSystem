<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckTokenValidity;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\Patient\PatientInfoController;
use App\Http\Controllers\SystemRegistration\AdminRegistrationController;
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

Route::post("login", [LoginController::class, 'GetLoginInfo']);


Route::middleware(CheckTokenValidity::class)->group(function () {
    Route::get("patient/all", [PatientInfoController::class, 'getAllPatient']);
    Route::get("patient/about/{uid}", [PatientInfoController::class, 'GetUserById']);
    Route::get("patient/delete/{uid}", [PatientInfoController::class, 'deletePatientById']);
    Route::post("patient/update", [PatientInfoController::class, 'updatePatient']);

    Route::get("hospital/all", [HospitalController::class, 'getAllHospital']);
    Route::get("hospital/about/{adminID}", [HospitalController::class, 'getHospitalbyAdminId']);
    Route::post("hospital/registration", [HospitalRegistrationController::class, 'CreateHospital']);
    Route::get("hospital/delete/{hid}", [HospitalController::class, 'deleteHospital']);
    Route::post("hospital/update", [HospitalController::class, 'updateHospital']);
    Route::get("hospital/info/{hid}", [HospitalController::class, 'getHospitalbyId']);

    Route::get("doctor/all", [DoctorController::class, 'getAllDoctor']);
    Route::post("doctor/registration", [DoctorRegistrationController::class, 'CreateDoctor']);
    Route::get("doctor/about/{uid}", [DoctorController::class, 'GetDoctorById']);
    Route::post("doctor/info/update", [DoctorController::class, 'setDoctorInfo']);
    Route::get("doctor/info/{uid}", [DoctorController::class, 'getDoctorInfoById']);
    Route::post("doctor/update", [DoctorController::class, 'updateDoctor']);
    Route::get("doctor/delete/{uid}", [DoctorController::class, 'deleteDoctorById']);


    Route::get("admin/all", [AdminController::class, 'getAllAdmin']);
    Route::post("admin/registration", [AdminRegistrationController::class, 'CreateAdmin']);
    Route::get("admin/about/{uid}", [AdminController::class, 'GetAdminById']);
    Route::post("admin/update", [AdminController::class, 'updateAdmin']);
    Route::get("admin/delete/{uid}", [AdminController::class, 'deleteAdminById']);
});



Route::post("patient/registration", [PatientRegistrationController::class, 'getRegister']);
Route::get("/auth/verify-email/{verification_token}", [EmailVerificationController::class, 'verifyEmail'])->name('verify_email');
