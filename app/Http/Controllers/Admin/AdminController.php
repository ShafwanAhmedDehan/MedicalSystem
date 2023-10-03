<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //Admin information display
    function GetAdminById($uid)
    {
        //Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No admin found.']);
        } else {
            if ($user->role !== 3) {
                return response()->json(['message' => 'User is not a Admin.']);
            }
            return response()->json($user);
        }
    }

    //Admin information display
    function getAllAdmin()
    {
        //Get user info by id
        $user = User::where('role', 3)->get();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No admin found.']);
        } else {
            return response()->json($user);
        }
    }

    //Admin delete
    function deleteAdminById($uid)
    {
        //Get user info by id
        $user = User::where('id', $uid)->first();

        // Check if any user was found
        if (!$user) {
            return response()->json(['message' => 'No admin found.']);
        } else {
            if ($user->role !== 3) {
                return response()->json(['message' => 'User is not a Admin.']);
            }
            $user->delete();
            return response()->json(['message' => 'Admin deleted successfully.']);
        }
    }

    //Admin information update
    public function updateAdmin(Request $AdminData)
    {
        $userId = $AdminData->input('uid');
        // Validation Message and Rules (You can modify these as needed)
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        if ($user->role !== 3) {
            return response()->json(['message' => 'User is not a Admin.']);
        }
        //Validation Message
        $validationMessages = [

            'firstName.required' => 'Please enter First Name',
            'firstName.string' => 'Name must be a string, Please enter a valid First Name',
            'firstName.max' => 'Please enter a First Name under 100 characters',
            'firstName.regex' => 'Please enter a valid First Name',

            'lastName.required' => 'Please enter Last Name',
            'lastName.string' => 'Name must be a string, Please enter a valid Last Name',
            'lastName.max' => 'Please enter a Last Name under 100 characters',
            'lastName.regex' => 'Please enter a valid Last Name',

            'phone.required' => 'Please enter Phone Number',
            'phone.digits' => 'Please enter a valid Phone Number.',
            'phone.unique' => 'Nubmer exists. If you already have an account, Please Login',
            'phone.regex' => 'Please enter a valid Phone Number.',

            'gender.required' => 'Please select Gender',
            'gender.string' => 'Gender must be a string',
            'gender.max' => 'Max 10 character is allowed for Gender',

            'email.required' => 'Please enter Email',
            'email.email' => 'Please enter a valid Email',
            'email.max' => 'Please enter a Email under 100 characters',
            'email.unique' => 'Email exists. If you already have an account, Please Login',

            'address.required' => 'Please enter Address',
            'address.string' => 'Address must be a string, Please enter a valid Address',
            'address.max' => 'Please enter a address under 100 characters',

            'password.required' => 'Please enter Password',
            'password.min' => 'Please enter a Password with minimum 8 characters',
            'password.max' => 'Please enter a Password under 100 character',
            'password.regex' => 'Password must contain at least one uppercase, one lowercase letter, one number and one special character',

            'confirm_password.required' => 'Please enter Confirm Password',
            'confirm_password.min' => 'Please enter a Confirm Password with minimum 8 characters',
            'confirm_password.max' => 'Please enter a Confirm Password under 100 character',
            'confirm_password.regex' => 'Confirm Password must contain at least one uppercase, one lowercase letter, one number and one special character',
            'confirm_password.same' => 'Password and Confirm Password does not match'


        ];

        $rules = [
            'firstName' => "required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'lastName' => "required|string|max:100|regex:/^([a-zA-Z',.-]+( [a-zA-Z',.-]+)*)$/",
            'phone' => "required|digits:11|regex:/^(01[3456789][0-9]{8})$/|unique:users,phone,$userId,id",
            'gender' => 'required|string|max:10',
            'email' => "required|email|max:100|unique:users,email,$userId,id",
            'address' => 'required|string|max:100',
            'password' => "nullable|min:8|max:100|regex:/^((?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,})$/",
            'confirm_password' => 'nullable|min:8|max:100|regex:/^((?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,})$/', // Add the same:password rule conditionally
        ];

        $validationCheck = Validator::make($AdminData->all(), $rules, $validationMessages);

        // Check if validation fails
        if ($validationCheck->fails()) {
            return response()->json(['errors' => $validationCheck->errors()]);
        }



        // Update user data
        $user->first_name = $AdminData->input('firstName');
        $user->last_name = $AdminData->input('lastName');
        $user->phone = $AdminData->input('phone');
        $user->gender = $AdminData->input('gender');
        $user->email = $AdminData->input('email');
        $user->address = $AdminData->input('address');

        // Check if a new password is provided and update it
        if ($AdminData->filled('password')) {
            $user->password = Hash::make($AdminData->input('password'));
        }

        // Save the updated user data
        if ($user->save()) {
            return response()->json([
                'message' => 'Admin Update successful',
                'user' => $user
            ]);
        } else {
            return response()->json(['message' => 'Update failed']);
        }
    }
}
