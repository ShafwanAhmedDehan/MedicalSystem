<?php

namespace App\Http\Controllers\Appointment;

use App\Models\User;
use App\Models\doctor;
use App\Models\hospital;
use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    //use this controller to make appointment

    //function for create a new appointment
    function createNewAppointment(Request $appointmentData)
    {
        //getting user and doctor information
        $user = User :: where('id', $appointmentData->input('patient_id'))->first();
        $doctor = doctor :: where('uid', $appointmentData->input('doctor_id'))->first();

        //getting day from the current date and get the current date
        $currentDate = Carbon::now();
        $weekday = $currentDate->format('l');
        $dateFormatted = $currentDate->format('Y-m-d');

        $weekday = strtolower($weekday);

        //taking 1st 3 characters of the day
        $convertedweekday = substr($weekday, 0, 3);

        $count = appointment::where('date_of_appointment', '=', $dateFormatted)
            ->where('doctor_id', '=', $appointmentData->input('doctor_id'))
            ->count();


        $doctorweekday = explode(' ', $doctor->visitingDay);
        $patientName = ($user->first_name).' '.($user->last_name);


        //check doctor reach appointment
        if ($count < $doctor->patientcount)
        {
            foreach ($doctorweekday as $day)
            {
                //return $convertedweekday.' '.$day;
                // Compare the current day with doctor visiting day
                if (strcasecmp($convertedweekday, $day) === 0)
                {
                    // If the day matches and making an appointment
                    $newAppointment = appointment::create([
                        'patient_name' => $patientName,
                        'patient_id' => $user->id,
                        'doctor_id' => $appointmentData->input('doctor_id'),
                        'hospital_id' => $doctor->hospitalid,
                        'day_of_week' => $convertedweekday,
                        'date_of_appointment' => $dateFormatted
                    ]);

                    return response()->json(
                        $newAppointment
                    );
                }
            }

            //if doctor doest not have appointment schedule today
            return response()->json(['message' => 'Doctor doest not have visiting time today']);
        }
        else
        {
            return response()->json(['message' => 'Doctor does not have slot for this appointment']);
        }
    }

    //function for get all appointment of today by doctor id
    function getAppointmentByDoctor($Did)
    {
        //getting today's date
        $currentDate = Carbon::now();
        $dateFormatted = $currentDate->format('Y-m-d');

        //getting all the appointment of current date
        $appointment_list = appointment::where('doctor_id', '=', $Did)
                            ->where('date_of_appointment', '=', $dateFormatted)
                            ->where('status', '=', '1')
                            ->get();

        return $appointment_list;
    }

    //function for delete the appointment
    function deleteAppointmentById($id)
    {
        $appointment = appointment :: where('id', $id)->first();

        if(!$appointment)
        {
            return response()->json(['message' => 'No appointment found.']);
        }

        else
        {
            $appointment->delete();
            return response()->json(['message' => 'Appointment deleted successfully.']);
        }
    }

    //use for show all the appointment
    function showAllAppointments()
    {
        //get all the appointment
        $appointments_list = appointment :: all();

        return response()->json($appointments_list);
    }

    //use the function to get all the appointment history for a patient
    function showAllAppointmentsByPatient($id)
    {
        //get all the appointment by patient id
        //$appointments_list_patient = appointment :: where('patient_id', $id)->get();
        $appointments_list_patient = Appointment::select('appointments.*', 'hospitals.hospitalname as hospital_name', 'users.first_name as doctor_fname', 'users.last_name as doctor_lname')
                                        ->join('hospitals', 'appointments.hospital_id', '=', 'hospitals.id')
                                        ->join('users', 'appointments.doctor_id', '=', 'users.id')
                                        ->where('patient_id', $id)
                                        ->get();


        //check appointment have or not
        if (!$appointments_list_patient) {
            return response()->json(['message' => 'No appointment found.']);
        }

        return response()->json($appointments_list_patient);
    }
}
