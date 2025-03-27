<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with(['alumnos', 'profesores', 'asignaturas'])
            ->get()
            ->map(function ($curso) {
                $curso->numero_alumnos = $curso->alumnos->count();
                return $curso;
            });
        return response()->json($cursos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required|string|max:50',
            'grupo' => 'required|string|max:10',
            'tutor' => 'required|exists:profesores,dni'
        ]);

        $curso = Curso::create($request->all());
        return response()->json($curso, 201);
    }

    public function show(Curso $curso)
    {
        $curso->load(['alumnos', 'profesores', 'asignaturas']);
        return response()->json($curso);
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nivel' => 'string|max:50',
            'grupo' => 'string|max:10',
            'tutor' => 'exists:profesores,dni'
        ]);

        $curso->update($request->all());
        return response()->json($curso);
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return response()->json(null, 204);
    }

    public function getAlumnos(Curso $curso)
    {
        $alumnos = $curso->alumnos()
            ->with(['amonestaciones'])
            ->get();
        return response()->json($alumnos);
    }

    public function getProfesores(Curso $curso)
    {
        $profesores = $curso->profesores()
            ->with(['asignaturas'])
            ->get();
        return response()->json($profesores);
    }

    public function getAsignaturas(Curso $curso)
    {
        $asignaturas = $curso->asignaturas()
            ->with(['profesores'])
            ->get();
        return response()->json($asignaturas);
    }

    public function getEstadisticas(Curso $curso)
    {
        $estadisticas = [
            'total_alumnos' => $curso->alumnos()->count(),
            'total_profesores' => $curso->profesores()->count(),
            'total_asignaturas' => $curso->asignaturas()->count(),
            'amonestaciones_por_gravedad' => DB::table('amonestaciones')
                ->where('idCurso', $curso->id)
                ->select('gravedad', DB::raw('count(*) as total'))
                ->groupBy('gravedad')
                ->get()
        ];

        return response()->json($estadisticas);
    }

    public function getAmonestaciones(Curso $curso)
    {
        $amonestaciones = $curso->amonestaciones()
            ->with(['alumno', 'comiconvi'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorGravedad(Curso $curso, $gravedad)
    {
        $amonestaciones = $curso->amonestaciones()
            ->where('gravedad', $gravedad)
            ->with(['alumno', 'comiconvi'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }
} 