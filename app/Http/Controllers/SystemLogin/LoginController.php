<?php

namespace App\Http\Controllers\SystemLogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\authtoken;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //Function for login
    function GetLoginInfo(Request $loginValues)
    {
        //Customize validation messages
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'regex' => 'The :attribute field is not valid email.',
        ];

        //rules for validation
        $rules = [
            'email' => ['required', 'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/'],
            'password' => 'required',
        ];
        

        // Perform validation
        $validationCheck = Validator::make($loginValues->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) 
        {
            return response()->json(['errors' => $validationCheck->errors()], 422);
        }

        //Login Credentials checking
        $User = User :: where('email', $loginValues-> email)->first();

        //user found or not and match the password
        if ($User != null /*&& /*(Hash :: check(($loginValues-> password),($user -> Password)))*/)
        {
            //login Passsed
            //token creation
            $tokenValue = JWTAuth::fromUser($User);

            // Calculate the expiration minutes
            $expires_at = (now()->addHours(6))->addMinutes(10);
            $currentDateTime = now()->addHours(6);

            // Store the token in the tokens table
            $token = authtoken::create([
                'token' => $tokenValue,
                'created_at' => $currentDateTime,
                'expires_at' => $expires_at,
                'user_id' => $User->id,
            ]);
            return response()->json([
                'user' => $User,
                'token' => $token,
            ]);
        }
        
        else
        {
            //Login failed
            $Error = [
                'message' => 'Wrong Login Credentials'
            ];
            return response()->json($Error);
        }
    }
}
