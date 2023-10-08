<?php

namespace App\Http\Controllers\Notification;

use App\Models\User;
use App\Models\appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhoneNotificationController extends Controller
{
    //send SMS notification
    function SendSMS($pid, $aid)
    {
        $user = User::where('id', $pid)->first();

        $appoinment = appointment :: where('id', $aid)->first();
        //check user and appoinment found or not
        if(!$user && !$appoinment)
        {
            return response()->json(['message' => 'No user found.']);
        }
        else
        {
            $appoinment->update([
                'status' => 0,
            ]);

            //using sms sent api from greenweb.com
            $to = $user->phone;
            $token = "838611002716963092278bc4b2c87b5ba8ba230269fb6a1b7d88";  // Token given for my id in greenweb.com
            $message = "Hello, Your serial is up and enter to the doctor cabin";  // Write Message

            $url = "http://api.greenweb.com.bd/api.php?json"; // Request link for SMS


            //set all the parameters and send request
            $data= array(
            'to'=>"$to",
            'message'=>"$message",
            'token'=>"$token"
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);

            //Result
            return response()->json(['message' => 'SMS send Successfully and Appoinment Status Changed.']);

        }

    }
}
