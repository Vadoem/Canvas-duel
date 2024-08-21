<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'company',
        'adress',
        'supervisor',
        'napr',
        'sum',
        'start',
        'end',
        // Добавьте остальные заполняемые поля для данных договоров
    ];
}
