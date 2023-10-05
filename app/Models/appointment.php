<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_id',
        'doctor_id',
        'hospital_id',
        'day_of_week',
        'status',
        'date_of_appointment',
        'doctor_visiting_time'
    ];


     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'status',
        'created_at',
        'updated_at'
    ];

}
