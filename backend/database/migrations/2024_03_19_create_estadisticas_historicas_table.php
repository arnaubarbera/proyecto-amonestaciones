<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estadisticas_historicas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // 'curso', 'mes', 'tipo', 'profesor'
            $table->string('categoria'); // nombre del curso, mes, tipo de amonestación, nombre del profesor
            $table->integer('total');
            $table->integer('año');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estadisticas_historicas');
    }
}; 