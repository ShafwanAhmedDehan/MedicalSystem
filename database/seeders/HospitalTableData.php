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
        $faker = Faker::create();

        for ($i = 1; $i < 11; $i++) {
            DB::table('hospitals')->insert([
                'hospitalname' => 'Hospital' . $i,
                'location' => $faker->address,
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
