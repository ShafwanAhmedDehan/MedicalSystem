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

        for ($i = 1; $i < 11; $i++) {

            DB::table('doctors')->insert([
                'specialization' => 'Specility' . $i,
                'hospitalid' => $i,
                'uid' => 11 + $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
        }
    }
}
