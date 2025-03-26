<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignaturaController extends Controller
{
    public function index()
    {
        $asignaturas = Asignatura::with(['cursos', 'profesores'])->get();
        return response()->json($asignaturas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:troncales,especificas'
        ]);

        $asignatura = Asignatura::create($request->all());
        return response()->json($asignatura, 201);
    }

    public function show(Asignatura $asignatura)
    {
        $asignatura->load(['cursos', 'profesores']);
        return response()->json($asignatura);
    }

    public function update(Request $request, Asignatura $asignatura)
    {
        $request->validate([
            'nombre' => 'string|max:255',
            'tipo' => 'in:troncales,especificas'
        ]);

        $asignatura->update($request->all());
        return response()->json($asignatura);
    }

    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return response()->json(null, 204);
    }

    public function getCursos(Asignatura $asignatura)
    {
        $cursos = $asignatura->cursos()
            ->with(['alumnos', 'profesores'])
            ->get();
        return response()->json($cursos);
    }

    public function getProfesores(Asignatura $asignatura)
    {
        $profesores = $asignatura->profesores()
            ->with(['cursos'])
            ->get();
        return response()->json($profesores);
    }

    public function getEstadisticas(Asignatura $asignatura)
    {
        $estadisticas = [
            'total_cursos' => $asignatura->cursos()->count(),
            'total_profesores' => $asignatura->profesores()->count(),
            'cursos_por_nivel' => DB::table('curso_asignatura')
                ->join('cursos', 'curso_asignatura.idCurso', '=', 'cursos.id')
                ->where('curso_asignatura.idAsignatura', $asignatura->id)
                ->select('cursos.nivel', DB::raw('count(*) as total'))
                ->groupBy('cursos.nivel')
                ->get()
        ];

        return response()->json($estadisticas);
    }

    public function getAsignaturasPorTipo($tipo)
    {
        $asignaturas = Asignatura::where('tipo', $tipo)
            ->with(['cursos', 'profesores'])
            ->get();
        return response()->json($asignaturas);
    }

    public function getAsignaturasPorCurso($cursoId)
    {
        $asignaturas = Asignatura::whereHas('cursos', function($query) use ($cursoId) {
            $query->where('cursos.id', $cursoId);
        })->with(['profesores'])->get();
        return response()->json($asignaturas);
    }
} 