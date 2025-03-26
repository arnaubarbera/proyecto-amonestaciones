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
        Schema::create('amonestaciones', function (Blueprint $table) {
            $table->id();
            $table->string('gravedad', 25);
            $table->string('observaciones', 100);
            $table->string('documentosAdjuntos', 50);
            $table->string('motivo', 100);
            $table->boolean('notificacionCasa');
            $table->date('fechaAmonestacion');
            $table->foreignId('idAlumno')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('idComiconvi')->constrained('comiconvis')->onDelete('cascade');
            $table->foreignId('idCurso')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amonestaciones');
    }
};
