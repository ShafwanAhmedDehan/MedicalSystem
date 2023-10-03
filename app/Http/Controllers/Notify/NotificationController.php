<?php

namespace App\Http\Controllers\Notify;

use Illuminate\Http\Request;
use App\Events\PushNotification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function patientNotification($id){

        $message = "Your appointment is next.";

        event(new PushNotification($message, $id));

        return response()->json([
            'success' => 'Notification sent.'
        ]);
    }
}
