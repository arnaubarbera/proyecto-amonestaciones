<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfesorSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar la tabla antes de insertar
        DB::table('profesores')->delete();

        $profesores = [
            [
                'dni' => '12345678A',
                'nombre' => 'Alberto',
                'apellidos' => 'Fernández',
                'correo' => 'alberto.fernandez@gmail.com',
                'telefono' => '600123456',
                'password' => Hash::make('password123')
            ],
            [
                'dni' => '87654321B',
                'nombre' => 'María',
                'apellidos' => 'García',
                'correo' => 'maria.garcia@gmail.com',
                'telefono' => '600789012',
                'password' => Hash::make('password123')
            ],
            [
                'dni' => '11223344C',
                'nombre' => 'Juan',
                'apellidos' => 'López',
                'correo' => 'juan.lopez@gmail.com',
                'telefono' => '600345678',
                'password' => Hash::make('password123')
            ]
        ];

        foreach ($profesores as $profesor) {
            DB::table('profesores')->insert($profesor);
        }
    }
} 