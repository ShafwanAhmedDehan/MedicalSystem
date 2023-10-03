<?php

namespace App\Http\Controllers\Doctor;

use App\Models\User;
use App\Models\doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{

    //doctor information display
    function GetDoctorById($uid)
    {
        //Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No user found.']);
        } else {
            if ($user->role !== 2) {
                return response()->json(['message' => 'User is not a doctor.']);
            }
            $doctorProfile = doctor::where('uid', $uid)->first();
            if (!$doctorProfile) {
                return response()->json(['message' => 'No user found.']);
            } else {
                //if user found then it will return
                return response()->json($user);
            }
        }
    }


    //Get doctors and doctors detail by hospital id
    function getDoctorByHospitalId($hid)
    {
        // Get doctors by hospital id
        $doctors = Doctor::where('hospitalid', $hid)->get();

        // Check if any doctor was found
        if (!$doctors) {
            return response()->json(['message' => 'No doctor found.']);
        }

        // Initialize an array to store user information for each doctor
        $doctorInfo = [];

        // Iterate through the doctors and get user information for each doctor
        foreach ($doctors as $doctor) {
            $user = User::where('id', $doctor->uid)->first(); // Assuming 'id' is unique, use first() to get a single user

            if ($user) {
                // Add user information to the array for this doctor
                $doctorInfo[] = [
                    'user' => $user,
                    'doctor' => $doctor,
                ];
            }
        }

        // Return the array containing information for all the doctors
        return response()->json($doctorInfo);
    }




    //all doctor information display
    function getAllDoctor()
    {
        //Get user info by id
        //$user = User::where('role', 2)->get();
        $usersWithDoctorInfo = User::where('role', 2)
            ->join('doctors', 'users.id', '=', 'doctors.uid')
            ->select('users.*', 'doctors.specialization','doctors.visitingDay','doctors.hospitalid','doctors.visitingTime','doctors.patientcount')
            ->get();

        // Check if any user was found
        if (!$usersWithDoctorInfo) {
            return response()->json(['message' => 'No doctor found.']);
        } else {
            return response()->json($usersWithDoctorInfo);
        }
    }

    //get doctor by doctor id
    public function getDoctorInfoById($uid)
    {
        // Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No user found.']);
        } else {
            // Check if the user's role is 2 (doctor)
            if ($user->role !== 2) {
                return response()->json(['message' => 'User is not a doctor.']);
            }

            // Find the doctor profile associated with the user
            $doctorProfile = Doctor::where('uid', $uid)->first();

            // Check if a doctor profile was found
            if (!$doctorProfile) {
                return response()->json(['message' => 'No doctor profile found.']);
            } else {
                // If user found and is a doctor, return the user and doctor profile
                return response()->json([
                    'user' => $user,
                    'doctor' => $doctorProfile,
                ]);
            }
        }
    }





    //doctor information update
    function setDoctorInfo(Request $DoctorData)
    {
        //validation rules
        $rules = [
            'visitingDay' => 'required|string',
            'visitingTime' => 'required|string',
            'patientcount' => 'required|numeric',
        ];

        //validation custom messages
        $validationMessages = [
            'visitingDay.required' => 'Visiting day is required',
            'visitingDay.string' => 'Visiting day must be a string',

            'visitingTime.required' => 'Visiting time is required',
            'visitingTime.string' => 'Visiting time must be a string',

            'patientcount.required' => 'Patient count is required',
            'patientcount.numeric' => 'Patient count must be a number',
        ];

        $validationCheck = Validator::make($DoctorData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) {
            return response()->json(['errors' => $validationCheck->errors()]);
        }

        $uid = $DoctorData->input('uid');

        $doctorProfile = doctor::where('uid', $uid)->first();

        if (!$doctorProfile) {
            return response()->json(['message' => 'No user found.']);
        } else {
            $doctorProfile = doctor::where('uid', $uid)->update([
                'visitingDay' => $DoctorData->input('visitingDay'),
                'visitingTime' => $DoctorData->input('visitingTime'),
                'patientcount' => $DoctorData->input('patientcount'),
            ]);

            if ($doctorProfile) {
                return response()->json([
                    'message' => 'Doctor info updated successfully.',
                    'doctor' => $doctorProfile,

                ]);
            } else {
                return response()->json(['message' => 'Doctor info update failed.']);
            }
        }
    }



    // This controller for updating Doctor information
    function updateDoctor(Request $DoctorData)
    {

        $id = $DoctorData->input('uid');
        // Find the doctor by ID
        $doctor = User::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
        if ($doctor->role !== 2) {
            return response()->json(['message' => 'User is not a Doctor.']);
        }
        // Validation Message
        $validationMessages = [
            'firstName.required' => 'Please enter your First Name.',
            'firstName.string' => 'First Name must be a string. Please enter a valid First Name.',
            'firstName.max' => 'Please enter a First Name under 100 characters.',
            'firstName.regex' => 'Please enter a valid First Name.',

            'lastName.required' => 'Please enter your Last Name.',
            'lastName.string' => 'Last Name must be a string. Please enter a valid Last Name.',
            'lastName.max' => 'Please enter a Last Name under 100 characters.',
            'lastName.regex' => 'Please enter a valid Last Name.',

            'phone.required' => 'Please enter your Phone Number.',
            'phone.digits' => 'Please enter a valid Phone Number.',
            'phone.unique' => 'This phone number already exists. If you already have an account, please log in.',
            'phone.regex' => 'Please enter a valid Phone Number.',

            'gender.required' => 'Please select your Gender.',
            'gender.string' => 'Gender must be a string.',
            'gender.max' => 'Maximum 10 characters are allowed for Gender.',

            'email.required' => 'Please enter your Email.',
            'email.email' => 'Please enter a valid Email.',
            'email.max' => 'Please enter an Email under 100 characters.',
            'email.unique' => 'This Email already exists. If you already have an account, please log in.',

            'address.required' => 'Please enter your Address.',
            'address.string' => 'Address must be a string. Please enter a valid Address.',
            'address.max' => 'Please enter an address under 100 characters.',

            'password.required' => 'Please enter your Password.',
            'password.min' => 'Please enter a Password with a minimum of 8 characters.',
            'password.max' => 'Please enter a Password under 100 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',

            'confirm_password.required' => 'Please enter Confirm Password.',
            'confirm_password.min' => 'Please enter a Confirm Password with a minimum of 8 characters.',
            'confirm_password.max' => 'Please enter a Confirm Password under 100 characters.',
            'confirm_password.regex' => 'Confirm Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'confirm_password.same' => 'Password and Confirm Password do not match.',

            'specialization.required' => 'Please enter your Specialization.',

            'hospitalid.required' => 'Please enter the hospital ID.'
        ];

        // Validation rules for updating a doctor
        $rules = [
            'firstName' => "required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'lastName' => "required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'phone' => 'required|digits:11|unique:users,phone,' . $id . '|regex:/^(01[3456789][0-9]{8})$/',
            'gender' => 'required|string|max:10',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'address' => 'required|string|max:100',
            'specialization' => 'required',
            'hospitalid' => 'required'
        ];


        $validationCheck = Validator::make($DoctorData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) {
            return response()->json(['errors' => $validationCheck->errors()]);
        }



        // Update doctor information
        $doctor->first_name = $DoctorData->input('firstName');
        $doctor->last_name = $DoctorData->input('lastName');
        $doctor->phone = $DoctorData->input('phone');
        $doctor->gender = $DoctorData->input('gender');
        $doctor->email = $DoctorData->input('email');
        $doctor->address = $DoctorData->input('address');

        // Update the password if provided
        if ($DoctorData->has('password')) {
            $doctor->password = Hash::make($DoctorData->input('password'));
        }

        // Save the updated doctor information
        if ($doctor->save()) {
            // Update doctor table information
            $doctorInfo = Doctor::where('uid', $id)->first();

            if (!$doctorInfo) {
                return response()->json(['message' => 'Doctor info not found'], 404);
            }

            $doctorInfo->specialization = $DoctorData->input('specialization');
            $doctorInfo->hospitalid = $DoctorData->input('hospitalid');

            if ($doctorInfo->save()) {
                // Update was successful
                return response()->json([
                    'message' => 'Doctor information updated successfully',
                    'doctor' => $doctor,
                ]);
            } else {
                // Update failed
                return response()->json(['message' => 'Doctor table update failed']);
            }
        } else {
            // Update failed
            return response()->json(['message' => 'Doctor information update failed']);
        }
    }

    function deleteDoctorById($uid)
    {
        // Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No user found.']);
        } else {
            // Check if the user's role is 2 (doctor)
            if ($user->role !== 2) {
                return response()->json(['message' => 'User is not a doctor.']);
            }

            // Find the doctor profile associated with the user
            $doctorProfile = Doctor::where('uid', $uid)->first();

            // Check if a doctor profile was found
            if (!$doctorProfile) {
                return response()->json(['message' => 'No doctor profile found.']);
            } else {
                // Delete the doctor info
                $doctorProfile->delete();
                // Delete the user
                $user->delete();

                // If user found and is a doctor, return the user and doctor profile
                return response()->json(['message' => 'Doctor deleted successfully']);
            }
        }
    }
}
