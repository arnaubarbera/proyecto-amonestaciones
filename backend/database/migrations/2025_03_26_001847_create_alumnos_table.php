<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 25);
            $table->string('apellidos', 25);
            $table->string('nombrePadre', 25);
            $table->string('telefonoPadre', 20);
            $table->string('correoPadre', 40);
            $table->string('nombreMadre', 25);
            $table->string('telefonoMadre', 20);
            $table->string('correoMadre', 40);
            $table->foreignId('idCurso')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
