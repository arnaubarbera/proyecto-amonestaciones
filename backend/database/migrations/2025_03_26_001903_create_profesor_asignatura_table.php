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
        Schema::create('profesor_asignatura', function (Blueprint $table) {
            $table->string('dniProfesor', 25);
            $table->foreignId('idAsignatura')->constrained('asignaturas')->onDelete('cascade');
            $table->foreign('dniProfesor')->references('dni')->on('profesores')->onDelete('cascade');
            $table->primary(['dniProfesor', 'idAsignatura']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_asignatura');
    }
};
