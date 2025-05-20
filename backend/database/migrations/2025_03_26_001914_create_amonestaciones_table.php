<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('amonestaciones', function (Blueprint $table) {
            $table->id();
            // Los valores internos son 'grave', 'leve', 'convivencia' que corresponden a Grave, Leve, Convivencia respectivamente
            $table->enum('gravedad', ['grave', 'leve', 'convivencia'])->comment('grave=Grave, leve=Leve, convivencia=Convivencia');
            $table->foreignId('asignatura_id')->nullable()->constrained('asignaturas')->onDelete('set null');
            $table->text('observaciones');
            $table->string('documentos_adjuntos')->nullable();
            $table->string('motivo');
            $table->boolean('notificacion_casa')->default(false);
            $table->date('fecha_amonestacion');
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('comiconvi_id')->constrained('comiconvis')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amonestaciones');
    }
}; 