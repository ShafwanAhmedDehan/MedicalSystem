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
        //Get user info by id
        $user = User :: where('id', $uid)->get();

        // Check if any user was found
        if ($user->isEmpty()) 
        {
            return response()->json(['message' => 'No user found.']);
        }

        //if user found then it will return
        return response()->json($user);
    }
}
