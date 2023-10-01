<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

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
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '3',
                'address' => $faker->address,
                'verifystatus' => 1,
            ]);
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'doctor' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '2',
                'address' => $faker->address,
                'verifystatus' => 1,
            ]);
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => $faker->address,
                'verifystatus' => 1,
            ]);
        }

        for ($i = 11; $i < 21; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => $faker->address,
                'verifystatus' => 0,
            ]);
        }
    }
}
