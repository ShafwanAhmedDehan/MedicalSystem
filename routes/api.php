<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckTokenValidity;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\Notify\NotificationController;
use App\Http\Controllers\Patient\PatientInfoController;
use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Notification\PhoneNotificationController;
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

Route::post("login", [LoginController::class, 'GetLoginInfo'])->name('login');
Route::get("/auth/verify-email/{verification_token}", [EmailVerificationController::class, 'verifyEmail'])->name('verify_email');
Route::post("patient/registration", [PatientRegistrationController::class, 'getRegister']);


//['CheckTokenValidity', 'role:0']

Route::middleware(CheckTokenValidity::class)->group(function () {
    Route::get("isloggedin", function () {
        return 'valid';
    });
    Route::get("logout", [LoginController::class, 'logout'])->name('logout');

    Route::get("patient/all", [PatientInfoController::class, 'getAllPatient']);
    Route::get("patient/about/{uid}", [PatientInfoController::class, 'GetUserById']);
    Route::delete("patient/delete/{uid}", [PatientInfoController::class, 'deletePatientById']);
    Route::put("patient/update", [PatientInfoController::class, 'updatePatient']);

    Route::get("hospital/all", [HospitalController::class, 'getAllHospital']);
    Route::get("hospital/about/{adminID}", [HospitalController::class, 'getHospitalbyAdminId']);
    Route::post("hospital/registration", [HospitalRegistrationController::class, 'CreateHospital']);
    Route::delete("hospital/delete/{hid}", [HospitalController::class, 'deleteHospital']);
    Route::put("hospital/update", [HospitalController::class, 'updateHospital']);
    Route::get("hospital/info/{hid}", [HospitalController::class, 'getHospitalbyId']);

    Route::get("doctor/all", [DoctorController::class, 'getAllDoctor']);
    Route::get("doctor/hospital/{hid}", [DoctorController::class, 'getDoctorByHospitalId']);
    Route::post("doctor/registration", [DoctorRegistrationController::class, 'CreateDoctor']);
    Route::get("doctor/about/{uid}", [DoctorController::class, 'GetDoctorById']);
    Route::put("doctor/info/update", [DoctorController::class, 'setDoctorInfo']);
    Route::get("doctor/info/{uid}", [DoctorController::class, 'getDoctorInfoById']);
    Route::put("doctor/update", [DoctorController::class, 'updateDoctor']);
    Route::delete("doctor/delete/{uid}", [DoctorController::class, 'deleteDoctorById']);

    Route::post("create/appointment", [AppointmentController::class, 'createNewAppointment']);
    Route::get("view/appointment/{did}", [AppointmentController::class, 'getAppointmentByDoctor']);
    Route::delete("delete/appointment/{aid}", [AppointmentController::class, 'deleteAppointmentById']);
    Route::get("get/appointment/all", [AppointmentController::class, 'showAllAppointments']);
    Route::post("sms/notification/{pid}/{aid}", [PhoneNotificationController::class, 'SendSMS']);
    Route::get("view/patient/appointment/{pid}", [AppointmentController::class, 'showAllAppointmentsByPatient']);


    Route::get("admin/all", [AdminController::class, 'getAllAdmin']);
    Route::post("admin/registration", [AdminRegistrationController::class, 'CreateAdmin']);
    Route::get("admin/about/{uid}", [AdminController::class, 'GetAdminById']);
    Route::put("admin/update", [AdminController::class, 'updateAdmin']);
    Route::delete("admin/delete/{uid}", [AdminController::class, 'deleteAdminById']);

    Route::post('search/active', [SearchController::class, 'ActiveSearch']);
    Route::post('/notification/{id}', [NotificationController::class, 'patientNotification']);
});
