<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PatientInfoController extends Controller
{
    //user information display
    function GetUserById($uid)
    {
        //get user info by id
        $user = User::find($uid);

        //check if any user was found
        if (!$user) 
        {
            return response()->json(['message' => 'No user found.'], 404);
        }

        //if user found, return
        return response()->json([ "user" => $user ], 200);
    }
}
