<?php

namespace App\Http\Controllers;

use App\Models\Amonestacion;
use App\Models\Alumno;
use App\Models\Comiconvi;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmonestacionController extends Controller
{
    public function index()
    {
        $amonestaciones = Amonestacion::with(['alumno', 'comiconvi', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gravedad' => 'required|integer|min:1|max:3',
            'observaciones' => 'required|string',
            'documentosAdjuntos' => 'nullable|string',
            'motivo' => 'required|string',
            'notificacionCasa' => 'required|boolean',
            'fechaAmonestacion' => 'required|date',
            'idAlumno' => 'required|exists:alumnos,id',
            'idComiconvi' => 'required|exists:comiconvis,id',
            'idCurso' => 'required|exists:cursos,id'
        ]);

        // Convertir el valor numérico de gravedad a texto
        $gravedadTexto = match($request->gravedad) {
            3 => 'alta',    // Grave
            2 => 'media',   // Leve
            1 => 'baja',    // Convivencia
            default => 'baja'
        };

        $amonestacion = Amonestacion::create([
            'gravedad' => $gravedadTexto,
            'observaciones' => $request->observaciones,
            'documentosAdjuntos' => $request->documentosAdjuntos,
            'motivo' => $request->motivo,
            'notificacionCasa' => $request->notificacionCasa,
            'fechaAmonestacion' => $request->fechaAmonestacion,
            'idAlumno' => $request->idAlumno,
            'idComiconvi' => $request->idComiconvi,
            'idCurso' => $request->idCurso
        ]);

        return response()->json($amonestacion, 201);
    }

    public function show(Amonestacion $amonestacion)
    {
        $amonestacion->load(['alumno', 'comiconvi', 'curso']);
        return response()->json($amonestacion);
    }

    public function update(Request $request, Amonestacion $amonestacion)
    {
        $request->validate([
            'gravedad' => 'integer|min:1|max:3',
            'observaciones' => 'string',
            'documentosAdjuntos' => 'nullable|string',
            'motivo' => 'string',
            'notificacionCasa' => 'boolean',
            'fechaAmonestacion' => 'date',
            'idAlumno' => 'exists:alumnos,id',
            'idComiconvi' => 'exists:comiconvis,id',
            'idCurso' => 'exists:cursos,id'
        ]);

        $amonestacion->update($request->all());
        return response()->json($amonestacion);
    }

    public function destroy(Amonestacion $amonestacion)
    {
        $amonestacion->delete();
        return response()->json(null, 204);
    }

    public function getAmonestacionesPorAlumno(Alumno $alumno)
    {
        $amonestaciones = $alumno->amonestaciones()
            ->with(['comiconvi', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorCurso(Curso $curso)
    {
        $amonestaciones = $curso->amonestaciones()
            ->with(['alumno', 'comiconvi'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorComiconvi(Comiconvi $comiconvi)
    {
        $amonestaciones = $comiconvi->amonestaciones()
            ->with(['alumno', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getAmonestacionesPorGravedad($gravedad)
    {
        $amonestaciones = Amonestacion::where('gravedad', $gravedad)
            ->with(['alumno', 'comiconvi', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function getEstadisticas()
    {
        $estadisticas = [
            'total_amonestaciones' => Amonestacion::count(),
            'amonestaciones_por_gravedad' => Amonestacion::select('gravedad', DB::raw('count(*) as total'))
                ->groupBy('gravedad')
                ->get(),
            'amonestaciones_por_curso' => DB::table('amonestaciones')
                ->join('cursos', 'amonestaciones.idCurso', '=', 'cursos.id')
                ->select('cursos.nivel', 'cursos.grupo', DB::raw('count(*) as total'))
                ->groupBy('cursos.nivel', 'cursos.grupo')
                ->get(),
            'amonestaciones_por_mes' => Amonestacion::select(
                    DB::raw('MONTH(fechaAmonestacion) as mes'),
                    DB::raw('YEAR(fechaAmonestacion) as año'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('mes', 'año')
                ->orderBy('año', 'desc')
                ->orderBy('mes', 'desc')
                ->get()
        ];

        return response()->json($estadisticas);
    }

    public function getAmonestacionesNoNotificadas()
    {
        $amonestaciones = Amonestacion::where('notificacionCasa', false)
            ->with(['alumno', 'comiconvi', 'curso'])
            ->orderBy('fechaAmonestacion', 'desc')
            ->get();
        return response()->json($amonestaciones);
    }

    public function marcarComoNotificada(Amonestacion $amonestacion)
    {
        $amonestacion->update(['notificacionCasa' => true]);
        return response()->json($amonestacion);
    }
} 