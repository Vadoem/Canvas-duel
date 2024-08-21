<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerPractice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'lastname',
        'name_company',
        'company_employer',
        'worker',
        'people',
        'safety',
        'pass',
    ];
}
