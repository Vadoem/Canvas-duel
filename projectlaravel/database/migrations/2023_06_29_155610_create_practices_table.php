<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->string('practice_type');
            $table->string('practice_category');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('university_supervisor');
            $table->string('company_supervisor');
            $table->string('survey');
            $table->string('medical_exam');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('practices');
    }
}