<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amonestacion_id')->constrained('amonestaciones')->onDelete('cascade');
            $table->string('tipo'); // 'profesor', 'tutor', 'padres'
            $table->string('email_destino');
            $table->boolean('enviada')->default(false);
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}; 