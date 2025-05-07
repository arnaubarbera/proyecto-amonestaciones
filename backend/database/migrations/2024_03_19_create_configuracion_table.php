<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->boolean('notificaciones_email')->default(true);
            $table->boolean('exportacion_automatica')->default(false);
            $table->string('email_convivencia')->default('convivencia@iesmre.com');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracion');
    }
}; 