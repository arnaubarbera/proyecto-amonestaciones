<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model
{
    protected $table = 'amonestaciones';
    
    protected $fillable = [
        'gravedad',
        'observaciones',
        'documentosAdjuntos',
        'motivo',
        'notificacionCasa',
        'fechaAmonestacion',
        'idAlumno',
        'idComiconvi',
        'idCurso'
    ];

    protected $casts = [
        'notificacionCasa' => 'boolean',
        'fechaAmonestacion' => 'date'
    ];

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'idAlumno');
    }

    public function comiconvi()
    {
        return $this->belongsTo(Comiconvi::class, 'idComiconvi');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'idCurso');
    }

    // Scopes útiles
    public function scopePorGravedad($query, $gravedad)
    {
        return $query->where('gravedad', $gravedad);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fechaAmonestacion', $fecha);
    }

    public function scopeNotificadas($query)
    {
        return $query->where('notificacionCasa', true);
    }

    public function scopeNoNotificadas($query)
    {
        return $query->where('notificacionCasa', false);
    }

    // Métodos personalizados
    public function getDatosCompletosAttribute()
    {
        return [
            'alumno' => $this->alumno->nombre_completo,
            'curso' => $this->curso->nombre_completo,
            'gravedad' => $this->gravedad,
            'motivo' => $this->motivo,
            'fecha' => $this->fechaAmonestacion->format('d/m/Y'),
            'notificada' => $this->notificacionCasa ? 'Sí' : 'No'
        ];
    }
} 