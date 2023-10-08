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
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    //Function for login
    public function GetLoginInfo(Request $loginValues)
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
        if ($validationCheck->fails()) {
            return response()->json(['errors' => $validationCheck->errors()], 422);
        }

        //Login Credentials checking
        $user = User::where('email', $loginValues->email)->first();

        //user found and password matched and email verified
        if ($user) {
            if ((Hash::check(($loginValues->password), ($user->password))) && (($user->verifystatus) == 1)) {
                //login Passsed
                //token creation
                $tokenValue = $this->createToken($user);

                $cookie = cookie('jwt', $tokenValue, 10);

                return response()->json([
                    'user' => $user,
                    'token' => $tokenValue,
                ])->withCookie($cookie);
            }

            //email not verified yet
            elseif (($user->verifystatus) == 0) {
                return response()->json([
                    'message' => 'verify your email before login'
                ]);
            }

            else {
                return response()->json([
                    'message' => 'incorrect password'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'email does not exist'
            ]);
        }
    }

    //Function for logout
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        //delete token from database
        $this->destroyToken($token);

        if ($request->hasCookie('jwt')) {
            $cookie = Cookie::forget('jwt');

            return response()->json([
                'message' => 'logged out successfully'
            ])->withCookie($cookie);
        } else {
            return response()->json([
                'message' => 'logged out successfully'
            ]);
        }
    }

    public function createToken(User $user)
    {
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
        ];

        $tokenValue = JWTAuth::fromUser($user, $payload);
        $currentDateTime = now()->addHours(6);
        $expires_at = (now()->addHours(6))->addMinutes(10);

        $token = authtoken::create([
            'token' => $tokenValue,
            'created_at' => $currentDateTime,
            'expires_at' => $expires_at,
            'user_id' => $user->id,
        ]);

        while (!$token) {
            $tokenValue = JWTAuth::fromUser($user, $payload);
            $currentDateTime = now()->addHours(6);
            $expires_at = (now()->addHours(6))->addMinutes(10);

            $token = authtoken::create([
                'token' => $tokenValue,
                'created_at' => $currentDateTime,
                'expires_at' => $expires_at,
                'user_id' => $user->id,
            ]);
        }

        return $tokenValue;
    }
    

    public function destroyToken($token)
    {
        $tokenRec = authtoken::where('token', $token)->first();
        $tokenRec->delete();
    }

}
