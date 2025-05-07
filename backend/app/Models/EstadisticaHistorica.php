<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticaHistorica extends Model
{
    protected $table = 'estadisticas_historicas';
    
    protected $fillable = [
        'tipo',
        'categoria',
        'total',
        'año'
    ];
} 