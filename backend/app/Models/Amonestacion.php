<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model
{
    protected $table = 'amonestaciones';
    
    // Constantes para los valores de gravedad
    const GRAVEDAD_GRAVE = 'grave';
    const GRAVEDAD_LEVE = 'leve';
    const GRAVEDAD_CONVIVENCIA = 'convivencia';

    // Constantes para los tipos de amonestación
    const TIPO_CONDUCTA = 'conducta';
    const TIPO_ACADEMICO = 'academico';
    const TIPO_ASISTENCIA = 'asistencia';

    protected $fillable = [
        'gravedad',
        'observaciones',
        'documentos_adjuntos',
        'motivo',
        'notificacion_casa',
        'fecha_amonestacion',
        'alumno_id',
        'comiconvi_id',
        'curso_id',
        'tipo'
    ];

    protected $casts = [
        'fecha_amonestacion' => 'date',
        'notificacion_casa' => 'boolean'
    ];

    // Método para obtener el valor numérico de la gravedad
    public function getGravedadNumericaAttribute()
    {
        return match($this->gravedad) {
            self::GRAVEDAD_GRAVE => 3,
            self::GRAVEDAD_LEVE => 2,
            self::GRAVEDAD_CONVIVENCIA => 1,
            default => 1
        };
    }

    // Método para obtener el texto descriptivo de la gravedad
    public function getGravedadTextoAttribute()
    {
        return match($this->gravedad) {
            self::GRAVEDAD_GRAVE => 'Grave',
            self::GRAVEDAD_LEVE => 'Leve',
            self::GRAVEDAD_CONVIVENCIA => 'Convivencia',
            default => 'Convivencia'
        };
    }

    // Método para obtener el texto descriptivo del tipo
    public function getTipoTextoAttribute()
    {
        return match($this->tipo) {
            self::TIPO_CONDUCTA => 'Conducta',
            self::TIPO_ACADEMICO => 'Académico',
            self::TIPO_ASISTENCIA => 'Asistencia',
            default => 'No especificado'
        };
    }

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function comiconvi()
    {
        return $this->belongsTo(Comiconvi::class, 'comiconvi_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function profesor()
    {
        return $this->comiconvi->profesores()->first();
    }

    // Scopes útiles
    public function scopePorGravedad($query, $gravedad)
    {
        return $query->where('gravedad', $gravedad);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha_amonestacion', $fecha);
    }

    public function scopeNotificadas($query)
    {
        return $query->where('notificacion_casa', true);
    }

    public function scopeNoNotificadas($query)
    {
        return $query->where('notificacion_casa', false);
    }

    // Métodos personalizados
    public function getDatosCompletosAttribute()
    {
        return [
            'alumno' => $this->alumno->nombre_completo,
            'curso' => $this->curso->nombre_completo,
            'gravedad' => $this->gravedad,
            'motivo' => $this->motivo,
            'fecha' => $this->fecha_amonestacion->format('d/m/Y'),
            'notificada' => $this->notificacion_casa ? 'Sí' : 'No'
        ];
    }
} 