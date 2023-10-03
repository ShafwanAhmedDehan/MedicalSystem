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
        $addresses = [
            '12, shahid faruk road, jatrabari, 1204 Dhaka, Dhaka, 1204',
            '45, new eskaton road, moghbazar, 1217 Dhaka, Dhaka, 1217',
            '7/8, monipuripara, tejgaon, 1215 Dhaka, Dhaka, 1215',
            'house # 10, road # 12, sector # 10, uttara model town, 1230 Dhaka, Dhaka, 1230',
            '23, kazi nazrul islam avenue, shahbagh, 1000 Dhaka, Dhaka, 1000',
            '5/1, block # a, lalmatia, 1207 Dhaka, Dhaka, 1207',
            'house # 2/ka (3rd floor), road # 138, gulshan model town, gulshan-1, 1212 Dhaka, Dhaka, 1212',
            'house # 4/ka (4th floor), road # 139, banani model town, banani, 1213 Dhaka, Dhaka, 1213',
            'house # 6/ka (5th floor), road # 140, baridhara diplomatic zone, baridhara, 1212 Dhaka, Dhaka, 1212',
            '34, station road, chittagong, 4000 Chittagong, Chittagong, 4000',
            'house # 5/ka (2nd floor), road # 6, agrabad commercial area, 4100 Chittagong, Chittagong, 4100',
            'flat # b/4, house # 12, road # 8, khulshi residential area, 4205 Chittagong, Chittagong, 4205',
            'house # a/3 (3rd floor), road # 1, block # a, halishahar housing estate, 4216 Chittagong, Chittagong, 4216',
            'plot # c/5 (4th floor), road # 2, block # b, pahartali residential area, 4223 Chittagong, Chittagong, 4223',
            'house # b/6 (5th floor), road # 3, block # c, nasirabad housing society, 4202 Chittagong, Chittagong, 4202',
            'house # c/7 (6th floor), road # 4, block # d, muradpur residential area, 4204 Chittagong, Chittagong, 4204',
            'house # d/8 (7th floor), road # 5, block # e, gec circle residential area, 4000 Chittagong, Chittagong, 4000',
            'house # e/9 (8th floor), road # 6, block # f, sholoshahar residential area, 4208 Chittagong, Chittagong, 4208',
        ];

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




        $faker = Faker::create();
        $numAddresses = count($addresses);

        //super admin
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //admins
        for ($i = 1; $i < 11; $i++) {
            $firstName = $firstNames[$i];
            $lastName = $lastNames[$i];
            $address = $addresses[$i % $numAddresses];

            DB::table('users')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '3',
                'address' => $address,
                'verifystatus' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //Doctors
        for ($i = 1; $i < 11; $i++) {
            $firstName = $firstNames[$i+11];
            $lastName = $lastNames[$i+11];
            $address = $addresses[$i % $numAddresses];

            DB::table('users')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'doctor' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '2',
                'address' => $address,
                'verifystatus' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //verified patients
        for ($i = 1; $i < 41; $i++) {
            $firstName = $firstNames[$i+23];
            $lastName = $lastNames[$i+23];
            $address = $addresses[$i % $numAddresses];

            DB::table('users')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => $address,
                'verifystatus' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        //unverified patients
        for ($i = 41; $i < 51; $i++) {
            $firstName = $firstNames[$i+23];
            $lastName = $lastNames[$i+23];
            $address = $addresses[$i % $numAddresses];

            DB::table('users')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => '017' . mt_rand(10000000, 99999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('Password123@'),
                'role' => '0',
                'address' => $address,
                'verifystatus' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
