<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class authtoken extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    protected $fillable = [
        'token',
        'tokencreated_at',
        'expires_at',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
