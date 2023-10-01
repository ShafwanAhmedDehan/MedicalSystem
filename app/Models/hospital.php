<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital extends Model
{
    use HasFactory;

    //model for the hospital
    protected $fillable = [
        'hospitalname',
        'location',
        'adminid'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
