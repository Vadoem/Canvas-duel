<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('практика', function (Blueprint $table) {
            $table->id('ID_Студента');
            $table->unsignedBigInteger('ID_Практики');
            $table->unsignedBigInteger('ID_Тип_Практики');
            $table->unsignedBigInteger('ID_Вид_Практики');
            $table->date('Дата_начала');
            $table->date('Дата_окончания');
            $table->string('Медосмотр');
            $table->string('Анкета');
            $table->string('Предприятие');
            $table->string('Руководитель_от_предприятия');
            $table->string('Руководитель_от_университета');

            // Определите внешние ключи здесь, если необходимо

            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('практика');
    }
}