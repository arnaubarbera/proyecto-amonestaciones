<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuracion';
    
    protected $fillable = [
        'notificaciones_email',
        'exportacion_automatica',
        'email_convivencia'
    ];

    protected $casts = [
        'notificaciones_email' => 'boolean',
        'exportacion_automatica' => 'boolean'
    ];
} 