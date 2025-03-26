<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            ['nombreCurso' => '1º ESO', 'grupoCurso' => 'A'],
            ['nombreCurso' => '1º ESO', 'grupoCurso' => 'B'],
            ['nombreCurso' => '2º ESO', 'grupoCurso' => 'A'],
            ['nombreCurso' => '2º ESO', 'grupoCurso' => 'B'],
            ['nombreCurso' => '3º ESO', 'grupoCurso' => 'A'],
            ['nombreCurso' => '3º ESO', 'grupoCurso' => 'B'],
            ['nombreCurso' => '4º ESO', 'grupoCurso' => 'A'],
            ['nombreCurso' => '4º ESO', 'grupoCurso' => 'B'],
            ['nombreCurso' => '1º Bachillerato', 'grupoCurso' => 'A'],
            ['nombreCurso' => '1º Bachillerato', 'grupoCurso' => 'B'],
            ['nombreCurso' => '2º Bachillerato', 'grupoCurso' => 'A'],
            ['nombreCurso' => '2º Bachillerato', 'grupoCurso' => 'B'],
            ['nombreCurso' => 'FP Básica 1', 'grupoCurso' => 'A'],
            ['nombreCurso' => 'FP Básica 2', 'grupoCurso' => 'A'],
            ['nombreCurso' => 'Grado Medio 1', 'grupoCurso' => 'A'],
            ['nombreCurso' => 'Grado Medio 2', 'grupoCurso' => 'A'],
            ['nombreCurso' => 'Grado Superior 1', 'grupoCurso' => 'A'],
            ['nombreCurso' => 'Grado Superior 2', 'grupoCurso' => 'A']
        ];

        foreach ($cursos as $curso) {
            DB::table('cursos')->insert($curso);
        }
    }
} 