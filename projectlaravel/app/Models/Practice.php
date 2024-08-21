<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $fillable = [
        'practice_type',
        'practice_category',
        'start_date',
        'end_date',
        'university_supervisor',
        'company_supervisor',
        'questionnaire',
        'medical_checkup',
    ];
}