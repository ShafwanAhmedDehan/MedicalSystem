<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PatientInfoController extends Controller
{
    //patient management controller

    //Patient information display
    function GetUserById($uid)
    {
        //Get user info by id
        $user = User :: where('id', $uid)->first();

        // Check if any user was found
        if (!$user)
        {
            return response()->json(['message' => 'No user found.']);
        }
        if ($user->role !== 0) {
            return response()->json(['message' => 'User is not a Patient.']);
        }

        //if user found then it will return
        return response()->json($user);
    }

    function deletePatientById($uid)
    {
        //Get user info by id
        $user = User :: where('id', $uid)->first();

        // Check if any user was found
        if (!$user)
        {
            return response()->json(['message' => 'No user found.']);
        }
        if ($user->role !== 0) {
            return response()->json(['message' => 'User is not a Patient.']);
        }

        //if user found then it will return
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
