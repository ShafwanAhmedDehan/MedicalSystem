<?php

namespace App\Http\Controllers\Patient;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;
use App\Models\EmailVerification;

class PatientInfoController extends Controller
{
    //patient management controller

    //Patient information display
    function GetUserById($uid)
    {
        //get user info by id
        $user = User::find($uid);

        //check if any user was found
        if (!$user)
        {
            return response()->json(['message' => 'No user found.']);
        }
        if ($user->role !== 0) {
            return response()->json(['message' => 'User is not a Patient.']);
        }

        //if user found, return
        return response()->json([ "user" => $user ]);
    }


    //All Patient information display
    function getAllPatient()
    {
        //Get user info by id
        $user = User::where('role', 0)->get();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No patient found.']);
        }

        //if user found then it will return
        return response()->json($user);
    }

    //Patient delete
    function deletePatientById($uid)
    {
        //Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No user found.']);
        }
        if ($user->role !== 0) {
            return response()->json(['message' => 'User is not a Patient.']);
        }

        //if user found then it will return
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    //use for update patient information
    public function updatePatient(Request $request)
    {
        $userId = $request->input('uid');
        $user = User::find($userId);
        $userEmail = $user->email;

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->role !== 0) {
            return response()->json(['message' => 'User is not a Patient.']);
        }

        // Validation Rules
        $rules = [
            'firstName' => 'required|string|max:100|regex:/^([a-zA-Z\',.-]+( [a-zA-Z\',.-]+)*)$/',
            'lastName' => 'required|string|max:100|regex:/^([a-zA-Z\',.-]+( [a-zA-Z\',.-]+)*)$/',
            'phone' => 'required|digits:11|unique:users,phone,' . $userId . '|regex:/^(01[3456789][0-9]{8})$/',
            'gender' => 'required|string|max:10',
            'email' => 'required|email|max:100|unique:users,email,' . $userId,
            'address' => 'required|string|max:100',
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
            'phone.digits' => 'Please enter a valid 11-digit Phone Number.',
            'phone.unique' => 'This Phone Number is already registered. If you have an account, please log in.',
            'phone.regex' => 'Please enter a valid Phone Number starting with 01.',

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
        ];

        // Perform validation
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Update user information in the database


        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        $user->address = $request->input('address');


        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Check if the email is being updated
        if ($user->email != $userEmail) {
            // Email is being updated, so send verification email and set verify_status to 0
            $user->verifystatus = 0; // Assuming you have a 'verify_status' field in your User model
            if ($user->save()) {

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
                        $responseMessage = 'Profile updated successfully. Please verify your new email.';
                    } else {
                        // Email sending failed
                        $responseMessage = 'Profile updated, but the verification email is not sent. Please try again later.';
                    }
                }
            } else {
                $responseMessage = 'Profile updated, but the verification email is not sent. Please try again later.';
            }
        } else { // Email is not being updated, just update the user data
            if ($user->save()) {
                $responseMessage = 'Profile updated successfully.';
            }
            else {
                $responseMessage = 'Profile update failed.';
            }

            // Return a JSON response with the appropriate message and user information

        }
        return response()->json([
            'message' => $responseMessage,
            'user' => $user,
        ]);
    }
}
