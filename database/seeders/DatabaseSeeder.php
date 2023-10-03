<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserTableData::class,
            DoctorTableData::class,
            HospitalTableData::class,
            //PatientTableData::class,
            AppointmentTableData::class,
            //PrescriptionTableData::class,
            // DoctorTableData::class,
            // PatientTableData::class,
            // AppointmentTableData::class,
            // PrescriptionTableData::class,
        ]);





    }
}
