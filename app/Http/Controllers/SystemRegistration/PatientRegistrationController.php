<?php

namespace App\Http\Controllers\SystemRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EmailVerification;
//use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;

class PatientRegistrationController extends Controller
{


    //Use for user registration
    function getRegister(Request $PatientData)
    {
        //Validation Message
        $validationMessages = [
            'firstName.required'=>'Please enter First Name',
            'firstName.string'=>'Name must be a string, Please enter a valid First Name',
            'firstName.max'=>'Please enter a First Name under 100 characters',
            'firstName.regex'=>'Please enter a valid First Name',

            'lastName.required'=>'Please enter Last Name',
            'lastName.string'=>'Name must be a string, Please enter a valid Last Name',
            'lastName.max'=>'Please enter a Last Name under 100 characters',
            'lastName.regex'=>'Please enter a valid Last Name',

            'phone.required'=>'Please enter Phone Number',
            'phone.digits'=>'Please enter a valid Phone Number.',
            'phone.unique'=>'Nubmer exists. If you already have an account, Please Login',
            'phone.regex'=>'Please enter a valid Phone Number.',

            'gender.required'=>'Please select Gender',
            'gender.string'=>'Gender must be a string',
            'gender.max'=>'Max 10 character is allowed for Gender',

            'email.required'=>'Please enter Email',
            'email.email'=>'Please enter a valid Email',
            'email.max'=>'Please enter a Email under 100 characters',
            'email.unique'=>'Email exists. If you already have an account, Please Login',

            'address.required'=>'Please enter Address',
            'address.string'=>'Address must be a string, Please enter a valid Address',
            'address.max'=>'Please enter a address under 100 characters',

            'password.required'=>'Please enter Password',
            'password.min'=>'Please enter a Password with minimum 8 characters',
            'password.max'=>'Please enter a Password under 100 character',
            'password.regex'=>'Password must contain at least one uppercase, one lowercase letter, one number and one special character',

            'confirm_password.required'=>'Please enter Confirm Password',
            'confirm_password.min'=>'Please enter a Confirm Password with minimum 8 characters',
            'confirm_password.max'=>'Please enter a Confirm Password under 100 character',
            'confirm_password.regex'=>'Confirm Password must contain at least one uppercase, one lowercase letter, one number and one special character',
            'confirm_password.same'=>'Confirm Password does not match with Password',

        ];

        //Validation for user registration
        $rules = [
            'firstName'=>"required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'lastName'=>"required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'phone' => 'required|digits:11|unique:users,phone|regex:/^(01[3456789][0-9]{8})$/',   //|regex:/(^(\+8801|8801|01))[1|3-9]{1}(\d){8}$/
            'gender' => 'required|string|max:10',
            'email'=>'required|email|max:100|unique:users,email',
            'address'=>'required|string|max:100',
            'password'=>'required|min:8|max:100|regex:/^((?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,})$/',
            'confirm_password'=>'required|min:8|max:100|regex:/^((?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,})$/|same:password',
        ];

        // Perform validation
        $validationCheck = Validator::make($PatientData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails())
        {

            return response()->json(['errors' => $validationCheck->errors()]);
        }


        //Save user information in database
        $newuser = new User([
            'first_name' => $PatientData->input('firstName'),
            'last_name' => $PatientData->input('lastName'),
            'phone' => $PatientData->input('phone'),
            'gender' => $PatientData->input('gender'),
            'email' => $PatientData->input('email'),
            'address' => $PatientData->input('address'),
            'password' => Hash::make($PatientData->input('password')),

        ]);

        if ($newuser->save())
        {
            $newemailvalidator = new EmailVerification([
                'token' => Str::random(40),
                'user_id' => $newuser->id,
                'name' => $PatientData->input('firstName'),
                'email' => $PatientData->input('email'),
                'token_created_at'=>\Carbon\Carbon::now(),
    
            ]);

            if ($newemailvalidator->save())
            {


                 if(Mail::to($PatientData->input('email'))->send(new EmaiLVerificationMail($newemailvalidator)))
                {
                    return response()->json([
                        'message' => 'Registration successful. Please verify your email',
                        'user' => $newuser,
                    ]);
                }
                else
                {
                    return response()->json([
                        'message' => 'Registration is successful but verification email is not sent',
                        'user' => $newuser,
                    ]);
                }
            }
            // Insertion was successful
            
        }
        else
        {
            // Insertion failed
            return response()->json([
                'message' => 'Registration failed'
            ]);
        }
    }














    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
