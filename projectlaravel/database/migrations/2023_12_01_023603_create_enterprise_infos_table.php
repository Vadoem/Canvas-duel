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
    Schema::create('enterprise_infos', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('director');
        $table->string('phone_number');
        $table->string('email');
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprise_infos');
    }
};
