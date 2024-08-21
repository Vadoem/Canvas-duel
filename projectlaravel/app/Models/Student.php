<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'worker',
        'birthdate',
        'age',
        'university',
        'study_program',
        'practice_type',
        'start_date',
        'end_date',
        'education_form',
        'company_phone',
        'Форма_обучения',
        'Номер_телефона',
        'Пол',
        'Почта',
        'Адрес_Регистрации',
        'course',
        'university_supervisor',
        'supervisor_name',
        'supervisor_position',
        'employee_name',
        'employee_position',
        'company_name',

    ];
}