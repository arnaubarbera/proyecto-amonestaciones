<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    
    protected $fillable = [
        'amonestacion_id',
        'tipo',
        'email_destino',
        'enviada',
        'fecha_envio'
    ];

    protected $casts = [
        'enviada' => 'boolean',
        'fecha_envio' => 'datetime'
    ];

    public function amonestacion()
    {
        return $this->belongsTo(Amonestacion::class);
    }
} 