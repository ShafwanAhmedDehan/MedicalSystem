<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\DB;

class UserTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'phone' => '01871887499',
            'gender' => 'Male',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('Password123@'),
            'role' => '1',
            'address' => 'Dhaka, Bangladesh',
            'verifystatus' => 1,

        ]);

        for ($i = 1; $i < 11; $i++) {

            DB::table('users')->insert([
                'first_name' => 'Admin',
                'last_name' => $i,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => 'Male',
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '3',
                'address' => 'Dhaka, Bangladesh',
                'verifystatus' => 1,
            ]);
        }

        for ($i = 1; $i < 11; $i++) {

            DB::table('users')->insert([
                'first_name' => 'Doctor',
                'last_name' => $i,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => 'Male',
                'email' => 'doctor' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '2',
                'address' => 'Dhaka, Bangladesh',
                'verifystatus' => 1,
            ]);
        }


        for ($i = 1; $i < 11; $i++) {

            DB::table('users')->insert([
                'first_name' => 'Patient',
                'last_name' => $i,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => 'Male',
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => 'Dhaka, Bangladesh',
                'verifystatus' => 1,
            ]);
        }
        for ($i = 11; $i < 21; $i++) {

            DB::table('users')->insert([
                'first_name' => 'Patient',
                'last_name' => $i,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => 'Male',
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => 'Dhaka, Bangladesh',
                'verifystatus' => 0,
            ]);
        }
    }
}
