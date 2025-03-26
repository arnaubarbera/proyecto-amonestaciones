<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoProfesorSeeder extends Seeder
{
    public function run(): void
    {
        $cursoProfesor = [
            ['dniProfesor' => '12345678A', 'idCurso' => 1],
            ['dniProfesor' => '87654321B', 'idCurso' => 10],
            ['dniProfesor' => '11223344C', 'idCurso' => 17]
        ];

        foreach ($cursoProfesor as $cp) {
            DB::table('curso_profesor')->insert($cp);
        }
    }
} 