<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        $asignaturas = [
            ['nombre' => 'Matemáticas', 'tipo' => 'Troncal'],
            ['nombre' => 'Lengua Española', 'tipo' => 'Troncal'],
            ['nombre' => 'Inglés', 'tipo' => 'Troncal'],
            ['nombre' => 'Ciencias Naturales', 'tipo' => 'Troncal'],
            ['nombre' => 'Educación Física', 'tipo' => 'Específica'],
            ['nombre' => 'Tecnología', 'tipo' => 'Específica'],
            ['nombre' => 'Física y Química', 'tipo' => 'Troncal'],
            ['nombre' => 'Historia', 'tipo' => 'Troncal'],
            ['nombre' => 'Filosofía', 'tipo' => 'Troncal'],
            ['nombre' => 'Programación', 'tipo' => 'Específica']
        ];

        foreach ($asignaturas as $asignatura) {
            DB::table('asignaturas')->insert($asignatura);
        }
    }
} 