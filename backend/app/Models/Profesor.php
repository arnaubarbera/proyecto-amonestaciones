<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Profesor extends Authenticatable
{
    use Notifiable;

    protected $table = 'profesores';
    
    protected $primaryKey = 'dni';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'dni',
        'nombre',
        'apellidos',
        'correo',
        'telefono',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relaciones
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_profesor', 'dniProfesor', 'idCurso');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'profesor_asignatura', 'dniProfesor', 'idAsignatura');
    }

    public function comiconvis()
    {
        return $this->belongsToMany(Comiconvi::class, 'profesor_comiconvi', 'dniProfesor', 'idComiconvi');
    }

    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class, 'idComiconvi', 'idComiconvi');
    }

    // Scopes útiles
    public function scopePorAsignatura($query, $asignaturaId)
    {
        return $query->whereHas('asignaturas', function($q) use ($asignaturaId) {
            $q->where('id', $asignaturaId);
        });
    }

    public function scopePorCurso($query, $cursoId)
    {
        return $query->whereHas('cursos', function($q) use ($cursoId) {
            $q->where('id', $cursoId);
        });
    }

    public function scopeDelComiconvi($query)
    {
        return $query->whereHas('comiconvis');
    }

    // Métodos personalizados
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellidos}";
    }

    public function getNumeroCursosAttribute()
    {
        return $this->cursos()->count();
    }

    public function getNumeroAsignaturasAttribute()
    {
        return $this->asignaturas()->count();
    }

    public function getNumeroAmonestacionesAttribute()
    {
        return $this->amonestaciones()->count();
    }
} 