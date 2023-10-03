<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define an array of real doctor specializations
        $specializations = [
            'Cardiologist',
            'Orthopedic Surgeon',
            'Pediatrician',
            'Dermatologist',
            'Oncologist',
            'Neurologist',
            'Gynecologist',
            'Urologist',
            'ENT Specialist',
            'General Surgeon',
        ];
        $visitingDays = [

            'fri',
            'sat',
            'sat sun',
            'sun mon',
            'mon tue',
            'tue wed',
            'wed thu',
            'sat sun mon',
            'tue wed thu',
            'wed thu fri',
            'thu fri sat',
            'fri sat sun',

        ];

        $patientCounts = [20, 25, 30, 35, 40, 45, 50];

        $visitingTimes = [
            '8:00 AM - 12:00 PM',
            '10:00 AM - 2:00 PM',
            '12:00 PM - 4:00 PM',
            '2:00 PM - 6:00 PM',
            '4:00 PM - 8:00 PM',
            '6:00 PM - 10:00 PM',
            '8:00 AM - 12:00 PM',
            '10:00 AM - 2:00 PM',
            '12:00 PM - 4:00 PM',
            '2:00 PM - 6:00 PM',
            '4:00 PM - 8:00 PM',
            '6:00 PM - 10:00 PM',
        ];

        for ($i = 0; $i < 10; $i++) {
            DB::table('doctors')->insert([
                'specialization' => $specializations[$i % count($specializations)],
                'hospitalid' => $i + 1, // Adjust the hospitalid as needed
                'visitingDay'=> $visitingDays[$i],
                'patientcount'=> $patientCounts[array_rand($patientCounts)],
                'visitingTime'=> $visitingTimes[$i],//$visitingTimes[array_rand($visitingTimes)],
                'uid' => 11 + $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


 // $table-> id();
            // $table -> string('specialization');
            // $table -> string('visitingDay')->nullable();
            // $table -> integer('hospitalid');
            // $table -> integer('patientcount') ->nullable();
            // $table -> time('visitingTime') ->nullable();
            // $table -> integer('uid');
            // $table->timestamps();


            // }
            //     "firstName": "Dr. Dehan",
            //     "lastName": "Ahmed",
            //     "phone": "01715040513",
            //     "gender": "Male",
            //     "email": "dehan@gmail.com",
            //     "address": "mirbag, dhaka",
            //     "password": "D@ehan2208",
            //     "confirm_password": "D@ehan2208",
            //     "specialization": "heart surgion",
            //     "hospitalid": 1
            // }
