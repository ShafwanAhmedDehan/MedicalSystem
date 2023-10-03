<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class HospitalTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            'Shahbag, Dhaka - 1000',
            'Plot: 81, Block: E, Bashundhara R/A, Dhaka - 1229',
            '18/F, Bir Uttam Qazi Nuruzzaman Sarak, West Panthapath, Dhaka - 1205',
            '122 Kazi Nazrul Islam Avenue, Shahbag, Dhaka - 1000',
            'Sher-E-Bangla Nagar, Dhaka - 1207',
            'Plot # 15, Road # 71, Gulshan, Dhaka - 1212',
            'House # 11/A, Road # 2, Dhanmondi, Dhaka - 1205',
            'House # 06, Road # 04, Dhanmondi, Dhaka - 1205',
            'Shahbag, Dhaka - 1000',
            'Bakshi Bazar, Dhaka - 1000',
            '1 Eskaton Garden Rd, Dhaka - 1000',
            'Mitford Road, Dhaka - 1100',
            'Mehedibag, Chittagong',
            '1000, CDA Avenue, East Nasirabad, Chittagong',
            'Dhaka Cantonment, Dhaka - 1206',
            'Greater Rd, Rajshahi - 6000',
            'Nayasarak Road, Sylhet - 3100',
            'Medical College Rd, Mymensingh',
            "Cox's Bazar - 4700",
            'Medical College Road, Rangpur'
        ];

        $names = [
            'Bangabandhu Sheikh Mujib Medical University (BSMMU) Hospital',
            'Evercare Hospitals Dhaka',
            'Square Hospital Ltd.',
            'Ibrahim Cardiac Hospital & Research Institute',
            'National Institute of Traumatology and Orthopaedic Rehabilitation (NITOR)',
            'United Hospital Limited',
            'Popular Diagnostic Centre Ltd.',
            'Labaid Specialized Hospital',
            'Birdem General Hospital',
            'Dhaka Medical College Hospital',
            'Holy Family Red Crescent Medical College Hospital',
            'Sir Salimullah Medical College Mitford Hospital',
            'Chittagong Medical College Hospital',
            'Chittagong Metropolitan Hospital',
            'Combined Military Hospital (CMH)',
            'Rajshahi Medical College Hospital',
            'Sylhet MAG Osmani Medical College Hospital',
            'Mymensingh Medical College Hospital',
            "Cox's Bazar Sadar Hospital",
            'Rangpur Medical College Hospital'
        ];

        $numAddresses = count($addresses);

        for ($i = 0; $i < 10; $i++) {

            $address = $addresses[$i % $numAddresses];
            $name = $names[$i];

            DB::table('hospitals')->insert([
                'hospitalname' => $name,
                'location' => $address,
                'adminid' => 1 + $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

// Schema::create('hospitals', function (Blueprint $table) {
//     $table->id();
//     $table -> string('hospitalname');
//     $table -> string('location');
//     $table->integer('adminid');
//     $table->timestamps();
// });
