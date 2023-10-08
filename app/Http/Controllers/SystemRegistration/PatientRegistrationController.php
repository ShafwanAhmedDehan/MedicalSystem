<?php

namespace App\Http\Controllers\SystemRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Models\EmailVerification;

class PatientRegistrationController extends Controller
{
    /**
     * Handle the user registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegister(Request $request)
    {
        // Validation Rules
        $rules = [
            'firstName' => 'required|string|max:100|regex:/^([a-zA-Z\',.-]+( [a-zA-Z\',.-]+)*)$/',
            'lastName' => 'required|string|max:100|regex:/^([a-zA-Z\',.-]+( [a-zA-Z\',.-]+)*)$/',
            'phone' => 'required',
            'gender' => 'required|string',
            'email' => 'required|email|max:100|unique:users,email',
            'address' => 'required|string|max:100',
            'password' => 'required|min:8|max:100|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[~!.@>#$%^&*+-_<?])[a-zA-Z\d~!.@>#$%^&*+-_<?]{8,}$/',
            'confirm_password' => 'required|min:8|max:100|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[~!.@>#$%^&*+-_<?])[a-zA-Z\d~!.@>#$%^&*+-_<?]{8,}$/|same:password',
        ];

        // Validation Messages
        $messages = [
            'firstName.required' => 'Please enter your First Name.',
            'firstName.string' => 'First Name must be a string. Please enter a valid First Name.',
            'firstName.max' => 'First Name should not exceed 100 characters in length.',
            'firstName.regex' => 'Please enter a valid First Name.',

            'lastName.required' => 'Please enter your Last Name.',
            'lastName.string' => 'Last Name must be a string. Please enter a valid Last Name.',
            'lastName.max' => 'Last Name should not exceed 100 characters in length.',
            'lastName.regex' => 'Please enter a valid Last Name.',

            'phone.required' => 'Please enter your Phone Number.',
            // 'phone.digits' => 'Please enter a valid 11-digit Phone Number.',
            // 'phone.unique' => 'This Phone Number is already registered. If you have an account, please log in.',
            // 'phone.regex' => 'Please enter a valid Phone Number starting with 01.',

            'gender.required' => 'Please select your Gender.',
            'gender.string' => 'Gender must be a string.',
            'gender.max' => 'Gender should not exceed 10 characters in length.',

            'email.required' => 'Please enter your Email Address.',
            'email.email' => 'Please enter a valid Email Address.',
            'email.max' => 'Email Address should not exceed 100 characters in length.',
            'email.unique' => 'This Email Address is already registered. If you have an account, please log in.',

            'address.required' => 'Please enter your Address.',
            'address.string' => 'Address must be a string. Please enter a valid Address.',
            'address.max' => 'Address should not exceed 100 characters in length.',

            'password.required' => 'Please enter your Password.',
            'password.min' => 'Password should be at least 8 characters in length.',
            'password.max' => 'Password should not exceed 100 characters in length.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',

            'confirm_password.required' => 'Please enter your Confirm Password.',
            'confirm_password.min' => 'Confirm Password should be at least 8 characters in length.',
            'confirm_password.max' => 'Confirm Password should not exceed 100 characters in length.',
            'confirm_password.regex' => 'Confirm Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'confirm_password.same' => 'Password and Confirm Password do not match.',
        ];

        // Perform validation
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save user information in the database
        $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($user) {
            // Create an email verification record
            $emailVerification = EmailVerification::create([
                'token' => Str::random(40),
                'user_id' => $user->id,
                'name' => $request->input('firstName'),
                'email' => $request->input('email'),
                'token_created_at' => now(),
            ]);

            if ($emailVerification) {
                // Send the email verification mail
                $emailSent = Mail::to($request->input('email'))->send(new EmailVerificationMail($emailVerification));

                if ($emailSent) {
                    // Email sent successfully
                    $responseMessage = 'Registration successful. Please verify your email.';
                } else {
                    // Email sending failed
                    $user->delete();
                    $emailVerification->delete();
                    $responseMessage = 'Registration is successful but Validation Email is not sent.';
                }

                // Return a JSON response with the appropriate message and user information
                return response()->json([
                    'message' => $responseMessage,
                ]);
            }
        }
        // Registration failed
        return response()->json([
            'message' => 'Registration failed'
        ]);
    }
}
