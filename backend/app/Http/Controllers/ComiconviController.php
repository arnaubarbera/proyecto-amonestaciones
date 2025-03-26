<?php

namespace App\Http\Controllers;

use App\Models\Comiconvi;
use App\Models\Profesor;
use App\Models\Amonestacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComiconviController extends Controller
{
    public function index()
    {
        $comiconvis = Comiconvi::with(['profesores', 'amonestaciones'])->get();
        return response()->json($comiconvis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idMiembro' => 'required|exists:profesores,dni'
        ]);

        $comiconvi = Comiconvi::create($request->all());
        return response()->json($comiconvi, 201);
    }

    public function show(Comiconvi $comiconvi)
    {
        $comiconvi->load(['profesores', 'amonestaciones']);
        return response()->json($comiconvi);
    }

    public function update(Request $request, Comiconvi $comiconvi)
    {
        $request->validate([
            'idMiembro' => 'exists:profesores,dni'
        ]);

        $comiconvi->update($request->all());
        return response()->json($comiconvi);
    }

    public function destroy(Comiconvi $comiconvi)
    {
        $comiconvi->delete();
        return response()->json(null, 204);
    }

    public function getProfesores(Comiconvi $comiconvi)
    {
        $profesores = $comiconvi->profesores()
            ->with(['cursos', 'asignaturas'])
            ->get();
        return response()->json($profesores);
    }

    public function getAmonestaciones(Comiconvi $comiconvi)
    {
        $amonestaciones = $comiconvi->amonestaciones()
            ->with(['alumno', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorGravedad(Comiconvi $comiconvi, $gravedad)
    {
        $amonestaciones = $comiconvi->amonestaciones()
            ->where('gravedad', $gravedad)
            ->with(['alumno', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getEstadisticas(Comiconvi $comiconvi)
    {
        $estadisticas = [
            'total_profesores' => $comiconvi->profesores()->count(),
            'total_amonestaciones' => $comiconvi->amonestaciones()->count(),
            'amonestaciones_por_gravedad' => $comiconvi->amonestaciones()
                ->select('gravedad', DB::raw('count(*) as total'))
                ->groupBy('gravedad')
                ->get(),
            'amonestaciones_por_curso' => DB::table('amonestaciones')
                ->join('cursos', 'amonestaciones.idCurso', '=', 'cursos.id')
                ->where('amonestaciones.idComiconvi', $comiconvi->id)
                ->select('cursos.nivel', 'cursos.grupo', DB::raw('count(*) as total'))
                ->groupBy('cursos.nivel', 'cursos.grupo')
                ->get()
        ];

        return response()->json($estadisticas);
    }

    public function getComiconvisPorProfesor($profesorDni)
    {
        $comiconvis = Comiconvi::whereHas('profesores', function($query) use ($profesorDni) {
            $query->where('profesores.dni', $profesorDni);
        })->with(['amonestaciones'])->get();
        return response()->json($comiconvis);
    }
} 