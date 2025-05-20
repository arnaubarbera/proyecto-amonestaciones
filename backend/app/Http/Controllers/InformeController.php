<?php

namespace App\Http\Controllers;

use App\Models\Amonestacion;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use PDF;

class InformeController extends Controller
{
    public function generarInforme(Request $request)
    {
        try {
            \Log::info('Iniciando generación de informe', [
                'tipo' => $request->input('tipo'),
                'params' => $request->all()
            ]);

            $tipo = $request->input('tipo');
            $query = Amonestacion::with(['alumno', 'curso', 'comiconvi.profesores', 'asignatura']);

            switch ($tipo) {
                case 'diario':
                    $fecha = $request->input('fecha');
                    \Log::info('Filtro diario', ['fecha' => $fecha]);
                    $query->whereDate('fecha_amonestacion', $fecha);
                    break;

                case 'mensual':
                    $mes = $request->input('mes');
                    $año = $request->input('año');
                    \Log::info('Filtro mensual', ['mes' => $mes, 'año' => $año]);
                    $query->whereMonth('fecha_amonestacion', $mes)
                        ->whereYear('fecha_amonestacion', $año);
                    break;

                case 'intervalo':
                    $fecha_inicio = $request->input('fecha_inicio');
                    $fecha_fin = $request->input('fecha_fin');
                    $query->whereBetween('fecha_amonestacion', [$fecha_inicio, $fecha_fin]);
                    break;

                case 'curso':
                    $cursoId = $request->input('curso_id');
                    \Log::info('Filtro curso', ['curso_id' => $cursoId]);
                    $query->where('curso_id', $cursoId);
                    break;

                case 'alumno':
                    $alumnoId = $request->input('alumno_id');
                    \Log::info('Filtro alumno', ['alumno_id' => $alumnoId]);
                    $query->where('alumno_id', $alumnoId);
                    break;

                case 'profesor':
                    $profesorId = $request->input('profesor_id');
                    \Log::info('Filtro profesor', ['profesor_id' => $profesorId]);
                    $query->whereHas('comiconvi.profesores', function ($q) use ($profesorId) {
                        $q->where('profesores.id', $profesorId);
                    });
                    break;

                case 'asignatura':
                    $asignaturaId = $request->input('asignatura_id');
                    \Log::info('Filtro asignatura', ['asignatura_id' => $asignaturaId]);
                    $query->where('asignatura_id', $asignaturaId);
                    break;
            }

            \Log::info('Ejecutando consulta');
            $amonestaciones = $query->orderBy('fecha_amonestacion', 'asc')->get();
            \Log::info('Consulta ejecutada', ['count' => $amonestaciones->count()]);

            // Generar resumen
            $resumen = [
                'Total Amonestaciones' => $amonestaciones->count(),
                'Por Asignatura' => $amonestaciones->groupBy('asignatura.nombre')->map->count(),
                'Por Gravedad' => $amonestaciones->groupBy('gravedad')->map->count()
            ];

            \Log::info('Resumen generado', ['resumen' => $resumen]);

            // Verificar que las relaciones se cargaron correctamente
            foreach ($amonestaciones as $amonestacion) {
                \Log::info('Verificando amonestación', [
                    'id' => $amonestacion->id,
                    'alumno' => $amonestacion->alumno ? 'cargado' : 'no cargado',
                    'curso' => $amonestacion->curso ? 'cargado' : 'no cargado',
                    'comiconvi' => $amonestacion->comiconvi ? 'cargado' : 'no cargado',
                    'profesores' => $amonestacion->comiconvi && $amonestacion->comiconvi->profesores ? 'cargado' : 'no cargado'
                ]);
            }

            return response()->json([
                'amonestaciones' => $amonestaciones,
                'resumen' => $resumen
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al generar informe', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json([
                'message' => 'Error al generar el informe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportarPDF(Request $request)
    {
        try {
            \Log::info('Iniciando exportación a PDF', [
                'tipo' => $request->input('tipo'),
                'params' => $request->all()
            ]);

            $tipo = $request->input('tipo');
            $query = Amonestacion::with(['alumno', 'curso', 'comiconvi.profesores', 'asignatura']);

            switch ($tipo) {
                case 'diario':
                    $fecha = $request->input('fecha');
                    $query->whereDate('fecha_amonestacion', $fecha);
                    break;

                case 'mensual':
                    $mes = $request->input('mes');
                    $año = $request->input('año');
                    $query->whereMonth('fecha_amonestacion', $mes)
                        ->whereYear('fecha_amonestacion', $año);
                    break;

                case 'intervalo':
                    $fecha_inicio = $request->input('fecha_inicio');
                    $fecha_fin = $request->input('fecha_fin');
                    $query->whereBetween('fecha_amonestacion', [$fecha_inicio, $fecha_fin]);
                    break;

                case 'curso':
                    $cursoId = $request->input('curso_id');
                    $query->where('curso_id', $cursoId);
                    break;

                case 'alumno':
                    $alumnoId = $request->input('alumno_id');
                    $query->where('alumno_id', $alumnoId);
                    break;

                case 'profesor':
                    $profesorId = $request->input('profesor_id');
                    $query->whereHas('comiconvi.profesores', function ($q) use ($profesorId) {
                        $q->where('profesores.id', $profesorId);
                    });
                    break;
            }

            $amonestaciones = $query->orderBy('fecha_amonestacion', 'asc')->get();

            // Generar resumen
            $resumen = [
                'Total Amonestaciones' => $amonestaciones->count(),
                'Por Asignatura' => $amonestaciones->groupBy('asignatura.nombre')->map->count(),
                'Por Gravedad' => $amonestaciones->groupBy('gravedad')->map->count()
            ];

            \Log::info('Datos preparados para PDF', [
                'amonestaciones_count' => $amonestaciones->count(),
                'resumen' => $resumen
            ]);

            $pdf = PDF::loadView('pdf.informe', [
                'amonestaciones' => $amonestaciones,
                'resumen' => $resumen,
                'tipo' => $tipo
            ]);

            return $pdf->download('informe-' . $tipo . '-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Error al exportar PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Error al exportar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }
} 