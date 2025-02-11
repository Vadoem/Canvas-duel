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
    Schema::table('heroes', function (Blueprint $table) {
        $table->decimal('speed', 5, 2)->change();
        $table->decimal('fire_rate', 5, 2)->change();
    });
}

public function down()
{
    Schema::table('heroes', function (Blueprint $table) {
        $table->integer('speed')->change();
        $table->integer('fire_rate')->change();
    });
}

};
