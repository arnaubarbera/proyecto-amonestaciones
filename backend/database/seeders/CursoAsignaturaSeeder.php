<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoAsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar la tabla antes de insertar
        DB::table('curso_asignatura')->truncate();

        $cursoAsignaturas = [
            ['idCurso' => 1, 'idAsignatura' => 1],
            ['idCurso' => 1, 'idAsignatura' => 2],
            ['idCurso' => 1, 'idAsignatura' => 3],
            ['idCurso' => 1, 'idAsignatura' => 4],
            ['idCurso' => 1, 'idAsignatura' => 5],
            ['idCurso' => 10, 'idAsignatura' => 9],
            ['idCurso' => 10, 'idAsignatura' => 1],
            ['idCurso' => 10, 'idAsignatura' => 8],
            ['idCurso' => 17, 'idAsignatura' => 10],
            ['idCurso' => 17, 'idAsignatura' => 1]
        ];

        foreach ($cursoAsignaturas as $cursoAsignatura) {
            DB::table('curso_asignatura')->insert($cursoAsignatura);
        }
    }
} 