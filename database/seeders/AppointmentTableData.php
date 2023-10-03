<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class AppointmentTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $firstNames = [
            'Nafis', 'Fatima', 'Riaz', 'Ayesha', 'Farid',
            'Nasrin', 'Shahid', 'Nusrat', 'Kamal', 'Rifi',
            'Shadhin', 'Sultana', 'Shahin', 'Anika', 'Hasan',
            'Fariha', 'Zahir', 'Sana', 'Arif', 'Meher',
            'Akhtar', 'Laila', 'Imran', 'Sumaiya', 'Abid',
            'Nabeela', 'Rafiq', 'Tasnim', 'Masud', 'Shabnam',
            'Farhan', 'Rubina', 'Javed', 'Yasmeen', 'Amin',
            'Firoza', 'Harun', 'Shama', 'Nasir', 'Amina',
            'Moin', 'Tarannum', 'Tariq', 'Nadia', 'Ali',
            'Shehla', 'Ashraf', 'Aisha', 'Shafiq', 'Sabina',
        ];

        $lastNames = [
            'Ahmed', 'Khan', 'Rahman', 'Islam', 'Ali',
            'Hassan', 'Chowdhury', 'Haque', 'Akhtar', 'Choudhury',
            'Hussain', 'Siddique', 'Hossain', 'Das', 'Malik',
            'Karim', 'Chowdhury', 'Mahmood', 'Ahmed', 'Khanam',
            'Amin', 'Yasmin', 'Rahman', 'Khan', 'Akter',
            'Uddin', 'Choudhury', 'Islam', 'Hossain', 'Ali',
            'Hasan', 'Chowdhury', 'Ahmed', 'Karim', 'Begum',
            'Khan', 'Rahman', 'Uddin', 'Choudhury', 'Hossain',
            'Siddiqui', 'Hasan', 'Islam', 'Rahman', 'Ali',
            'Chowdhury', 'Ahmed', 'Khanam', 'Akhtar', 'Begum',
        ];

        $day_of_weeks = [
            'sat',
            'sun',
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
        ];

        $patientCounts = [20, 25, 30, 35, 40, 45, 50];

        $doctor_visiting_times = [
            '8:00 AM - 12:00 PM',
            '10:00 AM - 2:00 PM',
            '12:00 PM - 4:00 PM',
            '2:00 PM - 6:00 PM',
            '4:00 PM - 8:00 PM',
            '6:00 PM - 10:00 PM',

        ];




        $faker = Faker::create();
        $startDate = 'now';
        $endDate = '+10 days';

        for ($i = 1; $i < 40; $i++) {
            //$firstName = $firstNames[$i];
            //$lastName = $lastNames[$i];


            DB::table('appointments')->insert([
                'patient_name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                'patient_id' => 21 + $i,
                'doctor_id' => rand(12, 21),
                'hospital_id' => rand(1, 10),
                'day_of_week' => $day_of_weeks[array_rand($day_of_weeks)],
                'date_of_appointment' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'doctor_visiting_time' => $faker->dateTimeBetween('08:00:00', '22:00:00')->format('H:i:s'), //$doctor_visiting_times[array_rand($doctor_visiting_times)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

// Schema::create('appointments', function (Blueprint $table) {
//     $table->id();
//     $table->string('patient_name');
//     $table -> integer('patient_id');
//     $table -> integer('doctor_id');
//     $table -> integer('hospital_id');
//     $table -> string('day_of_week');
//     $table -> date('date_of_appointment');
//     $table->timestamps();
//$table->time('doctor_visiting_time')->nullable();
// });
