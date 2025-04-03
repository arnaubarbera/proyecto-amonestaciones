<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ComiconviController;
use App\Http\Controllers\AmonestacionController;
use App\Http\Controllers\AuthController;


// Ruta de autenticación
Route::post('profesores/login', [AuthController::class, 'login']);

// Rutas de Alumnos
Route::apiResource('alumnos', AlumnoController::class);
Route::get('alumnos/{alumno}/amonestaciones', [AlumnoController::class, 'getAmonestaciones']);
Route::get('alumnos/{alumno}/amonestaciones/{gravedad}', [AlumnoController::class, 'getAmonestacionesPorGravedad']);
Route::get('alumnos/curso/{cursoId}', [AlumnoController::class, 'getAlumnosPorCurso']);
Route::get('alumnos/{alumno}/estadisticas', [AlumnoController::class, 'getEstadisticas']);

// Rutas de Cursos
Route::apiResource('cursos', CursoController::class);
Route::get('cursos/{curso}/alumnos', [CursoController::class, 'getAlumnos']);
Route::get('cursos/{curso}/profesores', [CursoController::class, 'getProfesores']);
Route::get('cursos/{curso}/asignaturas', [CursoController::class, 'getAsignaturas']);
Route::get('cursos/{curso}/estadisticas', [CursoController::class, 'getEstadisticas']);
Route::get('cursos/{curso}/amonestaciones', [CursoController::class, 'getAmonestaciones']);
Route::get('cursos/{curso}/amonestaciones/{gravedad}', [CursoController::class, 'getAmonestacionesPorGravedad']);

// Rutas de Asignaturas
Route::apiResource('asignaturas', AsignaturaController::class);
Route::get('asignaturas/{asignatura}/cursos', [AsignaturaController::class, 'getCursos']);
Route::get('asignaturas/{asignatura}/profesores', [AsignaturaController::class, 'getProfesores']);
Route::get('asignaturas/{asignatura}/estadisticas', [AsignaturaController::class, 'getEstadisticas']);
Route::get('asignaturas/tipo/{tipo}', [AsignaturaController::class, 'getAsignaturasPorTipo']);
Route::get('asignaturas/curso/{cursoId}', [AsignaturaController::class, 'getAsignaturasPorCurso']);

// Rutas de Profesores
Route::apiResource('profesores', ProfesorController::class);
Route::get('profesores/{profesor}/cursos', [ProfesorController::class, 'getCursos']);
Route::get('profesores/{profesor}/asignaturas', [ProfesorController::class, 'getAsignaturas']);
Route::get('profesores/{profesor}/comiconvis', [ProfesorController::class, 'getComiconvis']);
Route::get('profesores/{profesor}/estadisticas', [ProfesorController::class, 'getEstadisticas']);
Route::get('profesores/asignatura/{asignaturaId}', [ProfesorController::class, 'getProfesoresPorAsignatura']);
Route::get('profesores/curso/{cursoId}', [ProfesorController::class, 'getProfesoresPorCurso']);

// Rutas de Comiconvis
Route::apiResource('comiconvis', ComiconviController::class);
Route::get('comiconvis/{comiconvi}/profesores', [ComiconviController::class, 'getProfesores']);
Route::get('comiconvis/{comiconvi}/amonestaciones', [ComiconviController::class, 'getAmonestaciones']);
Route::get('comiconvis/{comiconvi}/amonestaciones/{gravedad}', [ComiconviController::class, 'getAmonestacionesPorGravedad']);
Route::get('comiconvis/{comiconvi}/estadisticas', [ComiconviController::class, 'getEstadisticas']);
Route::get('comiconvis/profesor/{profesorDni}', [ComiconviController::class, 'getComiconvisPorProfesor']);

// Rutas de Amonestaciones
Route::apiResource('amonestaciones', AmonestacionController::class);
Route::get('amonestaciones/alumno/{alumno}', [AmonestacionController::class, 'getAmonestacionesPorAlumno']);
Route::get('amonestaciones/curso/{curso}', [AmonestacionController::class, 'getAmonestacionesPorCurso']);
Route::get('amonestaciones/comiconvi/{comiconvi}', [AmonestacionController::class, 'getAmonestacionesPorComiconvi']);
Route::get('amonestaciones/gravedad/{gravedad}', [AmonestacionController::class, 'getAmonestacionesPorGravedad']);
Route::get('amonestaciones/estadisticas', [AmonestacionController::class, 'getEstadisticas']);
Route::get('amonestaciones/no-notificadas', [AmonestacionController::class, 'getAmonestacionesNoNotificadas']);
Route::patch('amonestaciones/{amonestacion}/notificar', [AmonestacionController::class, 'marcarComoNotificada']); 