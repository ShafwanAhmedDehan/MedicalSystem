<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\doctor;

class DoctorController extends Controller
{
    //doctor management

    //doctor information display
    function GetDoctorById($uid)
    {
        //Get user info by id
        $user = User :: where('id', $uid)->get();

        // Check if any user was found
        if ($user->isEmpty())
        {
            return response()->json(['message' => 'No user found.']);
        }
        else
        {
            $doctorProfile = doctor :: where('uid', $uid)->get();
            if($doctorProfile->isEmpty())
            {
                return response()->json(['message' => 'No user found.']);
            }
            else
            {
                //if user found then it will return
                return response()->json([
                    'user' => $user,
                    'doctor' => $doctorProfile,
                ]);
            }
        }
    }
}
