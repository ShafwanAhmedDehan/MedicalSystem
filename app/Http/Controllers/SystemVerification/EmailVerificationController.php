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
        // Check if there is an EmailVerification record with the provided token
        $emailVerification = EmailVerification::where('token', $verificationToken)->first();

        if (!$emailVerification) {
            // If no EmailVerification record found, return an error message view
            return view('auth/verification_message')->with('message', 'error');
        }

        if ($emailVerification->email_verified_at) {
            // If the email has already been verified, return a corresponding message view
            return view('auth/verification_message')->with('message', 'already_verified');
        }

        // Find the user associated with the EmailVerification record
        $user = User::where('email', $emailVerification->email)->first();

        if ($user) {
            // Update the EmailVerification record to mark the email as verified
            $emailVerification->update([
                'email_verified_at' => Carbon::now(),
            ]);

            // Update the user's verification status to indicate success
            $user->update([
                'verifystatus' => 1,
            ]);

            // Return a success message view
            return view('auth/verification_message')->with('message', 'success');
        }

        // If no user is found for the email, return an error message view
        return view('auth/verification_message')->with('message', 'error');
    }
}
