<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Doctor;
use App\Models\User;

class SearchController extends Controller
{
    //
    public function ActiveSearch(Request $request){

        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        // Search for hospitals by hospital's name and location
        $hospitals = Hospital::where('hospitalname', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%", 'COLLATE utf8_general_ci')
            ->get();

        // Search for doctors by doctor's specialization, visiting day and time-slot
        /*$doctors = Doctor::where('specialization', 'like', "%$query%")
            ->get();*/

        // Search for users by name, address and email
        $users = User::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('role', 2)
                ->where(function ($subQuery) use ($query) {
                    $subQuery->where('first_name', 'like', "%$query%")
                        ->orWhere('last_name', 'like', "%$query%")
                        ->orWhere('address', 'like', "%$query%")
                        ->orWhere('address', 'like', "%$query%", 'COLLATE utf8_general_ci')
                        ->orWhere('email', 'like', "%$query%");
                });
        })
        ->join('doctors', 'users.id', '=', 'doctors.uid')
        ->leftJoin('hospitals', 'doctors.hospitalid', '=', 'hospitals.id')
        ->select('users.*', 'doctors.*', 'hospitals.*')
        ->get();

        /*$users = User::where('role', 2)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'like', "%$query%")
                    ->orWhere('last_name', 'like', "%$query%")
                    ->orWhere('address', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%");
                })
                ->join('doctors', 'users.id', '=', 'doctors.uid')
                ->leftJoin('hospitals', 'doctors.hospitalid', '=', 'hospitals.id')
                ->select('users.*', 'doctors.*', 'hospitals.*')
                ->get();*/

        $data = [
            'hospitals' => $hospitals,
            'doctors' => $users
        ];

        return response()->json($data);
    }
}
