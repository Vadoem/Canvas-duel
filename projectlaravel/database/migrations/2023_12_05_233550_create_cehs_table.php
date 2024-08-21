<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCehsTable extends Migration
{
    public function up()
    {
        Schema::create('цех', function (Blueprint $table) {
            $table->id();
            $table->string('название');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('цех');
    }
}
