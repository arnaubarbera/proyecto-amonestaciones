<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesorAsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        $profesorAsignatura = [
            ['dniProfesor' => '12345678A', 'idAsignatura' => 1],
            ['dniProfesor' => '12345678A', 'idAsignatura' => 2],
            ['dniProfesor' => '87654321B', 'idAsignatura' => 9],
            ['dniProfesor' => '11223344C', 'idAsignatura' => 10]
        ];

        foreach ($profesorAsignatura as $pa) {
            DB::table('profesor_asignatura')->insert($pa);
        }
    }
} 