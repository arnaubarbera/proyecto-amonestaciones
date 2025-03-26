<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutamos los seeders en orden para mantener la integridad referencial
        $this->call([
            CursoSeeder::class,             // 1. Primero los cursos
            AsignaturaSeeder::class,        // 2. Luego las asignaturas
            AlumnoSeeder::class,            // 3. Alumnos (depende de cursos)
            CursoAsignaturaSeeder::class,   // 4. Relación curso-asignatura
            ProfesorSeeder::class,          // 5. Profesores
            CursoProfesorSeeder::class,     // 6. Relación curso-profesor
            ProfesorAsignaturaSeeder::class,// 7. Relación profesor-asignatura
            ComiconviSeeder::class,         // 8. Comiconvi
            ProfesorComiconviSeeder::class, // 9. Relación profesor-comiconvi
            AmonestacionSeeder::class       // 10. Finalmente las amonestaciones
        ]);
    }
}
