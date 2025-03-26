<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    
    protected $fillable = [
        'nombreCurso',
        'grupoCurso'
    ];

    // Relaciones
    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'idCurso');
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'curso_profesor', 'idCurso', 'dniProfesor');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'curso_asignatura', 'idCurso', 'idAsignatura');
    }

    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class, 'idCurso');
    }

    // Scopes útiles
    public function scopePorNivel($query, $nivel)
    {
        return $query->where('nombreCurso', 'like', "%{$nivel}%");
    }

    public function scopePorGrupo($query, $grupo)
    {
        return $query->where('grupoCurso', $grupo);
    }

    // Métodos personalizados
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombreCurso} {$this->grupoCurso}";
    }

    public function getNumeroAlumnosAttribute()
    {
        return $this->alumnos()->count();
    }

    public function getNumeroAmonestacionesAttribute()
    {
        return $this->amonestaciones()->count();
    }
} 