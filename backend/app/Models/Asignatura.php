<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    
    protected $fillable = [
        'nombre',
        'tipo'
    ];

    // Relaciones
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_asignatura', 'idAsignatura', 'idCurso');
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'profesor_asignatura', 'idAsignatura', 'dniProfesor');
    }

    // Scopes útiles
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeTroncales($query)
    {
        return $query->where('tipo', 'Troncal');
    }

    public function scopeEspecificas($query)
    {
        return $query->where('tipo', 'Específica');
    }

    // Métodos personalizados
    public function getNumeroCursosAttribute()
    {
        return $this->cursos()->count();
    }

    public function getNumeroProfesoresAttribute()
    {
        return $this->profesores()->count();
    }
} 