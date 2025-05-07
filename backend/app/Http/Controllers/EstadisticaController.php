<?php

namespace App\Http\Controllers;

use App\Models\Amonestacion;
use App\Models\EstadisticaHistorica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->input('periodo', 'actual');
        $curso = $request->input('curso');

        $query = Amonestacion::query();

        // Filtrar por período
        if ($periodo === 'actual') {
            $query->whereYear('fecha', date('Y'));
        } elseif ($periodo === 'anterior') {
            $query->whereYear('fecha', date('Y') - 1);
        }

        // Filtrar por curso si se especifica
        if ($curso) {
            $query->whereHas('alumno', function ($q) use ($curso) {
                $q->where('curso_id', $curso);
            });
        }

        // Estadísticas por curso
        $porCurso = $query->select('cursos.nombre as curso', DB::raw('count(*) as total'))
            ->join('alumnos', 'amonestaciones.alumno_id', '=', 'alumnos.id')
            ->join('cursos', 'alumnos.curso_id', '=', 'cursos.id')
            ->groupBy('cursos.id', 'cursos.nombre')
            ->get();

        // Estadísticas por mes
        $porMes = $query->select(DB::raw('MONTH(fecha) as mes'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(fecha)'))
            ->get()
            ->map(function ($item) {
                $item->mes = date('F', mktime(0, 0, 0, $item->mes, 1));
                return $item;
            });

        // Estadísticas por tipo
        $porTipo = $query->select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Estadísticas por profesor
        $porProfesor = $query->select('profesores.nombre as profesor', DB::raw('count(*) as total'))
            ->join('profesores', 'amonestaciones.profesor_id', '=', 'profesores.id')
            ->groupBy('profesores.id', 'profesores.nombre')
            ->get();

        return response()->json([
            'porCurso' => $porCurso,
            'porMes' => $porMes,
            'porTipo' => $porTipo,
            'porProfesor' => $porProfesor
        ]);
    }

    public function guardarEstadisticasHistoricas()
    {
        $año = date('Y');
        
        // Obtener estadísticas actuales
        $estadisticas = $this->index(request())->getData();
        
        // Guardar estadísticas por curso
        foreach ($estadisticas->porCurso as $estadistica) {
            EstadisticaHistorica::create([
                'tipo' => 'curso',
                'categoria' => $estadistica->curso,
                'total' => $estadistica->total,
                'año' => $año
            ]);
        }
        
        // Guardar estadísticas por mes
        foreach ($estadisticas->porMes as $estadistica) {
            EstadisticaHistorica::create([
                'tipo' => 'mes',
                'categoria' => $estadistica->mes,
                'total' => $estadistica->total,
                'año' => $año
            ]);
        }
        
        // Guardar estadísticas por tipo
        foreach ($estadisticas->porTipo as $estadistica) {
            EstadisticaHistorica::create([
                'tipo' => 'tipo',
                'categoria' => $estadistica->tipo,
                'total' => $estadistica->total,
                'año' => $año
            ]);
        }
        
        // Guardar estadísticas por profesor
        foreach ($estadisticas->porProfesor as $estadistica) {
            EstadisticaHistorica::create([
                'tipo' => 'profesor',
                'categoria' => $estadistica->profesor,
                'total' => $estadistica->total,
                'año' => $año
            ]);
        }
        
        return response()->json(['message' => 'Estadísticas históricas guardadas correctamente']);
    }
} 