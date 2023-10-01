<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital;



class HospitalController extends Controller
{
    //manage hospital controller

    //hospital information display
    function getHospitalbyAdminId($adminID)
    {
        //get the hospital of the admin
        $hospital = hospital :: where('adminid', $adminID)
        ->select('id', 'hospitalname', 'location')
        ->get();

        if ($hospital->isEmpty())
        {
            return response()->json(['message' => 'No hospital found.']);
        }

        //if hospital found then it will return
        return response()->json($hospital);
    }
}
