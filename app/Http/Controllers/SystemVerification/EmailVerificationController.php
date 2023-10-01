<?php

namespace App\Http\Controllers\SystemVerification;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationMail;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\View\auth;


class EmailVerificationController extends Controller
{
    public function verifyEmail($verificationToken)
    {
        $emailVerification = EmailVerification::where('token', $verificationToken)->first();

        if (!$emailVerification) {
            return view('auth/verification_message')->with('message', 'error');
        }

        if ($emailVerification->email_verified_at) {
            return view('auth/verification_message')->with('message', 'already_verified');
        }

        $user = User::where('email', $emailVerification->email)->first();

        if ($user) {
            $emailVerification->update([
                'email_verified_at' => Carbon::now(),
            ]);

            $user->update([
                'verifystatus' => 1,
            ]);

            return view('auth/verification_message')->with('message', 'Verification Successful');
        }

        return view('auth/verification_message')->with('message', 'error');
    }

}


