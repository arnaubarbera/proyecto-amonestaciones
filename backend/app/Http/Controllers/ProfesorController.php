<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Comiconvi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::with(['cursos', 'asignaturas', 'comiconvis'])->get();
        return response()->json($profesores);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:9|unique:profesores',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:profesores',
            'telefono' => 'required|string|max:20',
            'password' => 'required|string|min:6'
        ]);

        $profesor = Profesor::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password)
        ]);

        return response()->json($profesor, 201);
    }

    public function show(Profesor $profesor)
    {
        $profesor->load(['cursos', 'asignaturas', 'comiconvis']);
        return response()->json($profesor);
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'nombre' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'correo' => 'email|unique:profesores,correo,' . $profesor->dni . ',dni',
            'telefono' => 'string|max:20',
            'password' => 'nullable|string|min:6'
        ]);

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $profesor->update($data);
        return response()->json($profesor);
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();
        return response()->json(null, 204);
    }

    public function getCursos(Profesor $profesor)
    {
        $cursos = $profesor->cursos()
            ->with(['alumnos', 'asignaturas'])
            ->get();
        return response()->json($cursos);
    }

    public function getAsignaturas(Profesor $profesor)
    {
        $asignaturas = $profesor->asignaturas()
            ->with(['cursos'])
            ->get();
        return response()->json($asignaturas);
    }

    public function getComiconvis(Profesor $profesor)
    {
        $comiconvis = $profesor->comiconvis()
            ->with(['amonestaciones'])
            ->get();
        return response()->json($comiconvis);
    }

    public function getEstadisticas(Profesor $profesor)
    {
        $estadisticas = [
            'total_cursos' => $profesor->cursos()->count(),
            'total_asignaturas' => $profesor->asignaturas()->count(),
            'total_comiconvis' => $profesor->comiconvis()->count(),
            'amonestaciones_por_gravedad' => DB::table('amonestaciones')
                ->join('profesor_comiconvi', 'amonestaciones.idComiconvi', '=', 'profesor_comiconvi.idComiconvi')
                ->where('profesor_comiconvi.dniProfesor', $profesor->dni)
                ->select('amonestaciones.gravedad', DB::raw('count(*) as total'))
                ->groupBy('amonestaciones.gravedad')
                ->get()
        ];

        return response()->json($estadisticas);
    }

    public function getProfesoresPorAsignatura($asignaturaId)
    {
        $profesores = Profesor::whereHas('asignaturas', function($query) use ($asignaturaId) {
            $query->where('asignaturas.id', $asignaturaId);
        })->with(['cursos'])->get();
        return response()->json($profesores);
    }

    public function getProfesoresPorCurso($cursoId)
    {
        $profesores = Profesor::whereHas('cursos', function($query) use ($cursoId) {
            $query->where('cursos.id', $cursoId);
        })->with(['asignaturas'])->get();
        return response()->json($profesores);
    }
} 