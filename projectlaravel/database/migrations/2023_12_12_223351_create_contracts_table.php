<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('date');
            $table->string('company');
            $table->string('adress');
            $table->string('supervisor');
            $table->string('napr');
            $table->string('sum');
            $table->string('start');
            $table->string('end');
            // Добавьте остальные поля для данных договоров
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
