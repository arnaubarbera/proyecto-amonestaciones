<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmonestacionSeeder extends Seeder
{
    public function run(): void
    {
        $amonestaciones = [
            [
                'gravedad' => 'Alta',
                'observaciones' => 'Falta grave en clase',
                'documentosAdjuntos' => 'documento1.pdf',
                'motivo' => 'Indisciplina',
                'notificacionCasa' => true,
                'fechaAmonestacion' => '2025-01-01',
                'idAlumno' => 1,
                'idComiconvi' => 1,
                'idCurso' => 1
            ],
            [
                'gravedad' => 'Media',
                'observaciones' => 'Uso de móvil en clase',
                'documentosAdjuntos' => 'documento2.pdf',
                'motivo' => 'Distracción',
                'notificacionCasa' => false,
                'fechaAmonestacion' => '2025-01-02',
                'idAlumno' => 2,
                'idComiconvi' => 2,
                'idCurso' => 2
            ],
            [
                'gravedad' => 'Baja',
                'observaciones' => 'No entregó tarea',
                'documentosAdjuntos' => 'documento3.pdf',
                'motivo' => 'Tarea no entregada',
                'notificacionCasa' => true,
                'fechaAmonestacion' => '2025-01-03',
                'idAlumno' => 3,
                'idComiconvi' => 1,
                'idCurso' => 3
            ],
            [
                'gravedad' => 'Alta',
                'observaciones' => 'Comportamiento disruptivo',
                'documentosAdjuntos' => 'documento4.pdf',
                'motivo' => 'Indisciplina',
                'notificacionCasa' => true,
                'fechaAmonestacion' => '2025-01-04',
                'idAlumno' => 4,
                'idComiconvi' => 1,
                'idCurso' => 10
            ]
        ];

        foreach ($amonestaciones as $amonestacion) {
            DB::table('amonestaciones')->insert($amonestacion);
        }
    }
} 