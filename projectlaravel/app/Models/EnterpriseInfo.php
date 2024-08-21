<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'director',
        'phone_number',
        'email',
    ];
}