<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('worker')->nullable();
            $table->date('birthdate');
            $table->string('university');
            $table->string('age')->nullable();
            $table->integer('course');
            $table->string('study_program');
            $table->string('practice_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('education_form');
            $table->string('Форма_обучения');
            $table->string('Номер_телефона');
            $table->string('Пол');
            $table->string('Почта');
            $table->string('Адрес_Регистрации');
            $table->string('university_supervisor');
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_position')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_position')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_supervisor')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('contract_number')->nullable();
            $table->integer('student_count')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
