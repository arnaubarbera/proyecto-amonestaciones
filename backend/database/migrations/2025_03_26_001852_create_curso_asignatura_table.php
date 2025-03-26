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
        Schema::create('curso_asignatura', function (Blueprint $table) {
            $table->foreignId('idCurso')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('idAsignatura')->constrained('asignaturas')->onDelete('cascade');
            $table->primary(['idCurso', 'idAsignatura']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_asignatura');
    }
};
