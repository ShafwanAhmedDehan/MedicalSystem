<?php

namespace App\Http\Controllers\SystemVerification;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationMail;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class EmailVerificationController extends Controller
{
    public function verifyEmail($verificationToken)
{
    $emailVerification = EmailVerification::where('token', $verificationToken)->first();

    if (!$emailVerification) {
        return false;
    }

    if ($emailVerification->email_verified_at) {
        return false;
    }

    $user = User::where('email', $emailVerification->email)->first();

    if ($user) {
        $emailVerification->update([
            'email_verified_at' => Carbon::now(),
        ]);

        $user->update([
            'verifystatus' => 1,
        ]);

        //return true;
        return response()->json([

            'message' => 'Verification Successful',
            //'user' => $user,
        ]);
    }

    return false;
}

}


