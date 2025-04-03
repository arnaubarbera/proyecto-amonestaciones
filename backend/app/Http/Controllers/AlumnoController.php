<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::with('curso');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "{$search}%")
                  ->orWhere('apellidos', 'like', "{$search}%")
                  ->orWhere('nia', 'like', "{$search}%");
            });
        }

        $alumnos = $query->get();
        return response()->json($alumnos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'nombrePadre' => 'required|string|max:255',
            'nombreMadre' => 'required|string|max:255',
            'telefonoPadre' => 'required|string|max:20',
            'telefonoMadre' => 'required|string|max:20',
            'idCurso' => 'required|exists:cursos,id'
        ]);

        $alumno = Alumno::create($request->all());
        return response()->json($alumno, 201);
    }

    public function show(Alumno $alumno)
    {
        $alumno->load(['curso', 'amonestaciones']);
        return response()->json($alumno);
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'nombrePadre' => 'string|max:255',
            'nombreMadre' => 'string|max:255',
            'telefonoPadre' => 'string|max:20',
            'telefonoMadre' => 'string|max:20',
            'idCurso' => 'exists:cursos,id'
        ]);

        $alumno->update($request->all());
        return response()->json($alumno);
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return response()->json(null, 204);
    }

    public function getAmonestaciones(Alumno $alumno)
    {
        $amonestaciones = $alumno->amonestaciones()
            ->with(['curso', 'comiconvi'])
            ->orderBy('fecha_amonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorGravedad(Alumno $alumno, $gravedad)
    {
        $amonestaciones = $alumno->amonestaciones()
            ->where('gravedad', $gravedad)
            ->with(['curso', 'comiconvi'])
            ->orderBy('fecha_amonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAlumnosPorCurso($cursoId)
    {
        $alumnos = Alumno::where('idCurso', $cursoId)
            ->with(['curso', 'amonestaciones'])
            ->get();
        return response()->json($alumnos);
    }

    public function getEstadisticas(Alumno $alumno)
    {
        $estadisticas = [
            'total_amonestaciones' => $alumno->amonestaciones()->count(),
            'amonestaciones_por_gravedad' => $alumno->amonestaciones()
                ->select('gravedad', DB::raw('count(*) as total'))
                ->groupBy('gravedad')
                ->get(),
            'ultima_amonestacion' => $alumno->amonestaciones()
                ->orderBy('fecha_amonestacion', 'desc')
                ->first()
        ];

        return response()->json($estadisticas);
    }
} 