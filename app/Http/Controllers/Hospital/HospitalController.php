<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital;
use Illuminate\Support\Facades\Validator;



class HospitalController extends Controller
{
    //manage hospital controller
    //hospital information display
    function getHospitalbyAdminId($adminID)
    {
        //get the hospital of the admin
        $hospital = hospital::where('adminid', $adminID)
            ->select('id', 'hospitalname', 'location')
            ->first();

        if (!$hospital) {
            return response()->json(['message' => 'No hospital found.']);
        }

        //if hospital found then it will return
        return response()->json($hospital);
    }

    //all hospital information display
    function getAllHospital()
    {
        //get the hospital of the admin
        $hospital = hospital::select('id', 'hospitalname', 'location')
            ->get();

        if (!$hospital) {
            return response()->json(['message' => 'No hospital found.']);
        }

        //if hospital found then it will return
        return response()->json($hospital);
    }

    //hospital information update
    function updateHospital(Request $HospitalData,)
    {
        $hospitalId = $HospitalData->input('hid');
        // Validation messages
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute field is already in use.'
        ];

        // Validation rules
        $rules = [
            'hospitalname' => 'required',
            'location' => 'required',
            'adminid' => 'required|numeric|unique:hospitals,adminid,' . $hospitalId,
        ];

        $validationCheck = Validator::make($HospitalData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) {
            return response()->json(['errors' => $validationCheck->errors()]);
        }

        // Find the hospital by ID
        $hospital = Hospital::find($hospitalId);

        if (!$hospital) {
            // Hospital not found
            $error = [
                'message' => 'Hospital not found'
            ];
            return response()->json($error, 404);
        }

        // Update hospital data
        $hospital->hospitalname = $HospitalData->input('hospitalname');
        $hospital->location = $HospitalData->input('location');
        $hospital->adminid = $HospitalData->input('adminid');

        if ($hospital->save()) {
            // Update was successful
            return response()->json([
                'message' => 'Hospital Update successful',
                'hospital'=> $hospital
            ]);
        } else {
            // Update failed
            $error = [
                'message' => 'Update failed'
            ];
            return response()->json($error, 500);
        }
    }

    //hospital information delete
    function deleteHospital($hospitalId)
    {
        // Find the hospital by ID
        $hospital = Hospital::find($hospitalId);

        if (!$hospital) {
            // Hospital not found
            $error = [
                'message' => 'Hospital not found'
            ];
            return response()->json($error, 404);
        }

        if ($hospital->delete()) {
            $error = [
                'message' => 'Hospital deleted successfully'
            ];
            // Deletion was successful
            return response()->json($error);
        } else {
            // Deletion failed
            $error = [
                'message' => 'Deletion failed'
            ];
            return response()->json($error, 500);
        }
    }

    //hospital information by hospital id
    function getHospitalbyId($hospitalId)
    {
        //get the hospital of the admin
        $hospital = hospital::where('id', $hospitalId)
            ->select('id', 'hospitalname', 'location')
            ->first();

        if (!$hospital) {
            return response()->json(['message' => 'No hospital found.']);
        }

        //if hospital found then it will return
        return response()->json($hospital);
    }
}
