<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesorComiconviSeeder extends Seeder
{
    public function run(): void
    {
        $profesorComiconvi = [
            ['dniProfesor' => '12345678A', 'idComiconvi' => 1],
            ['dniProfesor' => '87654321B', 'idComiconvi' => 2]
        ];

        foreach ($profesorComiconvi as $pc) {
            DB::table('profesor_comiconvi')->insert($pc);
        }
    }
} 