<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comiconvi extends Model
{
    protected $table = 'comiconvis';
    
    protected $fillable = [
        'idMiembro'
    ];

    // Relaciones
    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'profesor_comiconvi', 'idComiconvi', 'dniProfesor');
    }

    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class, 'idComiconvi');
    }

    // Scopes útiles
    public function scopeConAmonestaciones($query)
    {
        return $query->has('amonestaciones');
    }

    // Métodos personalizados
    public function getNumeroProfesoresAttribute()
    {
        return $this->profesores()->count();
    }

    public function getNumeroAmonestacionesAttribute()
    {
        return $this->amonestaciones()->count();
    }
} 