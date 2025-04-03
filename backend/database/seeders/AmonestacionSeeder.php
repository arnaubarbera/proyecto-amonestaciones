<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Comiconvi;
use App\Models\Amonestacion;

class AmonestacionSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = Alumno::all();
        $comiconvis = Comiconvi::all();

        if ($alumnos->isEmpty()) {
            $this->command->error('No hay alumnos en la base de datos. Por favor, ejecuta primero el AlumnoSeeder.');
            return;
        }

        if ($comiconvis->isEmpty()) {
            $this->command->error('No hay comiconvis en la base de datos. Por favor, ejecuta primero el ComiconviSeeder.');
            return;
        }

        $motivos = [
            'grave' => [
                'Agresión física a un compañero',
                'Acoso escolar',
                'Daños materiales graves',
                'Falta de respeto grave al profesorado',
                'Conducta disruptiva grave en clase'
            ],
            'leve' => [
                'Falta de respeto leve al profesorado',
                'Retrasos reiterados',
                'Falta de material escolar',
                'Conducta disruptiva en clase',
                'Uso inadecuado del móvil'
            ],
            'convivencia' => [
                'Falta de puntualidad',
                'Falta de aseo personal',
                'Falta de respeto a las normas de convivencia',
                'Falta de participación en actividades',
                'Falta de colaboración en el aula'
            ]
        ];

        $this->command->info('Iniciando generación de amonestaciones...');
        $totalAmonestaciones = 0;

        foreach ($alumnos as $alumno) {
            // Generar entre 0 y 3 amonestaciones por alumno
            $numAmonestaciones = rand(0, 3);

            for ($i = 0; $i < $numAmonestaciones; $i++) {
                // Seleccionar gravedad aleatoria
                $gravedad = rand(1, 3);
                $gravedadTexto = match($gravedad) {
                    3 => 'grave',    // Grave
                    2 => 'leve',   // Leve
                    1 => 'convivencia',    // Convivencia
                    default => 'convivencia'
                };

                // Seleccionar motivo según la gravedad
                $motivo = $motivos[$gravedadTexto][array_rand($motivos[$gravedadTexto])];

                try {
                    Amonestacion::create([
                        'gravedad' => $gravedadTexto,
                        'observaciones' => 'Observaciones de ejemplo para ' . $motivo,
                        'motivo' => $motivo,
                        'notificacion_casa' => rand(0, 1),
                        'fecha_amonestacion' => now()->subDays(rand(1, 30)),
                        'alumno_id' => $alumno->id,
                        'curso_id' => $alumno->idCurso,
                        'comiconvi_id' => $comiconvis->random()->id
                    ]);
                    $totalAmonestaciones++;
                } catch (\Exception $e) {
                    $this->command->error("Error al crear amonestación para alumno {$alumno->id}: " . $e->getMessage());
                }
            }
        }

        $this->command->info("Se han creado {$totalAmonestaciones} amonestaciones en total.");

        // Ejemplos adicionales con los nuevos valores de gravedad
        Amonestacion::create([
            'gravedad' => 'grave',
            'observaciones' => 'Falta grave de disciplina',
            'documentos_adjuntos' => null,
            'motivo' => 'Falta de respeto al profesorado',
            'notificacion_casa' => true,
            'fecha_amonestacion' => now(),
            'alumno_id' => 1,
            'curso_id' => 1,
            'comiconvi_id' => 1
        ]);

        Amonestacion::create([
            'gravedad' => 'leve',
            'observaciones' => 'Falta de material escolar',
            'documentos_adjuntos' => null,
            'motivo' => 'No traer el material necesario',
            'notificacion_casa' => false,
            'fecha_amonestacion' => now()->subDays(2),
            'alumno_id' => 2,
            'curso_id' => 1,
            'comiconvi_id' => 1
        ]);

        Amonestacion::create([
            'gravedad' => 'convivencia',
            'observaciones' => 'Falta de puntualidad',
            'documentos_adjuntos' => null,
            'motivo' => 'Llegar tarde a clase',
            'notificacion_casa' => false,
            'fecha_amonestacion' => now()->subDays(5),
            'alumno_id' => 3,
            'curso_id' => 1,
            'comiconvi_id' => 1
        ]);
    }
} 