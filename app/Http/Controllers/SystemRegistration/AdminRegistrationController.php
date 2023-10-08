<?php

namespace App\Http\Controllers\SystemRegistration;

use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegistrationController extends Controller
{
    function CreateAdmin(Request $AdminData)
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
            // 'phone.digits'=>'Please enter a valid Phone Number.',
            // 'phone.unique'=>'Nubmer exists. If you already have an account, Please Login',
            // 'phone.regex'=>'Please enter a valid Phone Number.',

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
            'confirm_password.same'=>'Password and Confirm Password does not match'

        ];

        //Validation for user registration
        $rules = [
            'firstName'=>"required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'lastName'=>"required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'phone' => 'required',
            'gender' => 'required|string|max:10',
            'email'=>'required|email|max:100|unique:users,email',
            'address'=>'required|string|max:100',
            'password'=>'required|min:8|max:100|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[~!.@>#$%^&*+-_<?])[a-zA-Z\d~!.@>#$%^&*+-_<?]{8,}$/',
            'confirm_password'=>'required|min:8|max:100|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[~!.@>#$%^&*+-_<?])[a-zA-Z\d~!.@>#$%^&*+-_<?]{8,}$/|same:password'
        ];

        $validationCheck = Validator::make($AdminData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails())
        {
            return response()->json(['errors' => $validationCheck->errors()]);
        }

        $newuser = new User([
            'first_name' => $AdminData->input('firstName'),
            'last_name' => $AdminData->input('lastName'),
            'phone' => $AdminData->input('phone'),
            'gender' => $AdminData->input('gender'),
            'email' => $AdminData->input('email'),
            'address' => $AdminData->input('address'),
            'verifystatus' => 1,
            'password' => Hash::make($AdminData->input('password')),
            'role' => 3,
        ]);

        if ($newuser->save())
        {
            // Insertion was successful
            return response()->json([
                'user' => $newuser
            ]);
        }
        else
        {
            // Insertion failed
            $Error = [
                'message' => 'Registration failed'
            ];
            return response()->json($Error);
        }

    }
}
