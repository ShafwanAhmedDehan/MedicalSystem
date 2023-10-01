<?php

namespace App\Http\Controllers\SystemRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class HospitalRegistrationController extends Controller
{
    //this controller use for hospital registration
    function CreateHospital(request $HospitalData)
    {
        //validation message
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute field is already exist.'
        ];

        //validation rules
        $rules = [
            'hospitalname' => 'required',
            'location' => 'required',
            'adminid' => 'required|unique:hospitals,adminid',
        ];

        $validationCheck = Validator::make($HospitalData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) 
        {
            return response()->json(['errors' => $validationCheck->errors()]);
        }

        $newHospital = new hospital([
            'hospitalname' => $HospitalData->input('hospitalname'),
            'location' => $HospitalData->input('location'),
            'adminid' => $HospitalData->input('adminid')
        ]);

        if ($newHospital->save()) 
        {
            // Insertion was successful
            return response()->json($newHospital);
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
