<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemLogin\LoginController;
use App\Http\Controllers\SystemRegistration\PatientRegistrationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route :: post("login", [LoginController::class, 'GetLoginInfo']);


Route :: post("patient/registration", [PatientRegistrationController::class, 'getRegister']);
Route :: get("/auth/verify-email/{verification_token}", [EmailVerificationController::class, 'verifyEmail'])->name('verify_email');
                                                       
