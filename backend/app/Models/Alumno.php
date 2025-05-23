<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    
    protected $fillable = [
        'nombre',
        'apellidos',
        'nombrePadre',
        'telefonoPadre',
        'correoPadre',
        'nombreMadre',
        'telefonoMadre',
        'correoMadre',
        'curso_id'
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class, 'alumno_id');
    }

    // Scopes útiles
    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    public function scopeConAmonestaciones($query)
    {
        return $query->has('amonestaciones');
    }

    // Métodos personalizados
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellidos}";
    }

    public function getDatosPadreAttribute()
    {
        return [
            'nombre' => $this->nombrePadre,
            'telefono' => $this->telefonoPadre,
            'correo' => $this->correoPadre
        ];
    }

    public function getDatosMadreAttribute()
    {
        return [
            'nombre' => $this->nombreMadre,
            'telefono' => $this->telefonoMadre,
            'correo' => $this->correoMadre
        ];
    }
} 