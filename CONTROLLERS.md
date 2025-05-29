# Documentación de Controladores

## Controladores del Sistema

### AuthController
**Ubicación**: `backend/app/Http/Controllers/AuthController.php`

Controlador para la autenticación de usuarios.

```php
class AuthController extends Controller
{
    // Métodos principales
    public function login(Request $request)
    public function logout(Request $request)
    public function me(Request $request)
}
```

#### Endpoints
- `POST /api/login`: Autenticación de usuarios
- `POST /api/logout`: Cierre de sesión
- `GET /api/me`: Obtener información del usuario actual

### AmonestacionController
**Ubicación**: `backend/app/Http/Controllers/AmonestacionController.php`

Controlador para la gestión de amonestaciones.

```php
class AmonestacionController extends Controller
{
    // Métodos principales
    public function index(Request $request)
    public function store(Request $request)
    public function show(Amonestacion $amonestacion)
    public function update(Request $request, Amonestacion $amonestacion)
    public function destroy(Amonestacion $amonestacion)
    public function exportar(Request $request)
}
```

#### Endpoints
- `GET /api/amonestaciones`: Listar amonestaciones
- `POST /api/amonestaciones`: Crear amonestación
- `GET /api/amonestaciones/{id}`: Ver amonestación
- `PUT /api/amonestaciones/{id}`: Actualizar amonestación
- `DELETE /api/amonestaciones/{id}`: Eliminar amonestación
- `GET /api/amonestaciones/exportar`: Exportar amonestaciones

### AlumnoController
**Ubicación**: `backend/app/Http/Controllers/AlumnoController.php`

Controlador para la gestión de alumnos.

```php
class AlumnoController extends Controller
{
    // Métodos principales
    public function index(Request $request)
    public function store(Request $request)
    public function show(Alumno $alumno)
    public function update(Request $request, Alumno $alumno)
    public function destroy(Alumno $alumno)
    public function amonestaciones(Alumno $alumno)
}
```

#### Endpoints
- `GET /api/alumnos`: Listar alumnos
- `POST /api/alumnos`: Crear alumno
- `GET /api/alumnos/{id}`: Ver alumno
- `PUT /api/alumnos/{id}`: Actualizar alumno
- `DELETE /api/alumnos/{id}`: Eliminar alumno
- `GET /api/alumnos/{id}/amonestaciones`: Ver amonestaciones del alumno

### ProfesorController
**Ubicación**: `backend/app/Http/Controllers/ProfesorController.php`

Controlador para la gestión de profesores.

```php
class ProfesorController extends Controller
{
    // Métodos principales
    public function index(Request $request)
    public function store(Request $request)
    public function show(Profesor $profesor)
    public function update(Request $request, Profesor $profesor)
    public function destroy(Profesor $profesor)
    public function amonestaciones(Profesor $profesor)
}
```

#### Endpoints
- `GET /api/profesores`: Listar profesores
- `POST /api/profesores`: Crear profesor
- `GET /api/profesores/{id}`: Ver profesor
- `PUT /api/profesores/{id}`: Actualizar profesor
- `DELETE /api/profesores/{id}`: Eliminar profesor
- `GET /api/profesores/{id}/amonestaciones`: Ver amonestaciones del profesor

### CursoController
**Ubicación**: `backend/app/Http/Controllers/CursoController.php`

Controlador para la gestión de cursos.

```php
class CursoController extends Controller
{
    // Métodos principales
    public function index(Request $request)
    public function store(Request $request)
    public function show(Curso $curso)
    public function update(Request $request, Curso $curso)
    public function destroy(Curso $curso)
    public function alumnos(Curso $curso)
}
```

#### Endpoints
- `GET /api/cursos`: Listar cursos
- `POST /api/cursos`: Crear curso
- `GET /api/cursos/{id}`: Ver curso
- `PUT /api/cursos/{id}`: Actualizar curso
- `DELETE /api/cursos/{id}`: Eliminar curso
- `GET /api/cursos/{id}/alumnos`: Ver alumnos del curso

### AsignaturaController
**Ubicación**: `backend/app/Http/Controllers/AsignaturaController.php`

Controlador para la gestión de asignaturas.

```php
class AsignaturaController extends Controller
{
    // Métodos principales
    public function index(Request $request)
    public function store(Request $request)
    public function show(Asignatura $asignatura)
    public function update(Request $request, Asignatura $asignatura)
    public function destroy(Asignatura $asignatura)
    public function profesores(Asignatura $asignatura)
}
```

#### Endpoints
- `GET /api/asignaturas`: Listar asignaturas
- `POST /api/asignaturas`: Crear asignatura
- `GET /api/asignaturas/{id}`: Ver asignatura
- `PUT /api/asignaturas/{id}`: Actualizar asignatura
- `DELETE /api/asignaturas/{id}`: Eliminar asignatura
- `GET /api/asignaturas/{id}/profesores`: Ver profesores de la asignatura

### InformeController
**Ubicación**: `backend/app/Http/Controllers/InformeController.php`

Controlador para la generación de informes.

```php
class InformeController extends Controller
{
    // Métodos principales
    public function amonestaciones(Request $request)
    public function alumnos(Request $request)
    public function profesores(Request $request)
    public function cursos(Request $request)
}
```

#### Endpoints
- `GET /api/informes/amonestaciones`: Generar informe de amonestaciones
- `GET /api/informes/alumnos`: Generar informe de alumnos
- `GET /api/informes/profesores`: Generar informe de profesores
- `GET /api/informes/cursos`: Generar informe de cursos

### EstadisticaController
**Ubicación**: `backend/app/Http/Controllers/EstadisticaController.php`

Controlador para la gestión de estadísticas.

```php
class EstadisticaController extends Controller
{
    // Métodos principales
    public function general()
    public function porCurso()
    public function porProfesor()
    public function porTipo()
}
```

#### Endpoints
- `GET /api/estadisticas/general`: Estadísticas generales
- `GET /api/estadisticas/por-curso`: Estadísticas por curso
- `GET /api/estadisticas/por-profesor`: Estadísticas por profesor
- `GET /api/estadisticas/por-tipo`: Estadísticas por tipo de amonestación

### ComiconviController
**Ubicación**: `backend/app/Http/Controllers/ComiconviController.php`

Controlador para la gestión de la comisión de convivencia.

```php
class ComiconviController extends Controller
{
    // Métodos principales
    public function index()
    public function store(Request $request)
    public function show(Comiconvi $comiconvi)
    public function update(Request $request, Comiconvi $comiconvi)
    public function destroy(Comiconvi $comiconvi)
}
```

#### Endpoints
- `GET /api/comiconvi`: Listar miembros de la comisión
- `POST /api/comiconvi`: Añadir miembro
- `GET /api/comiconvi/{id}`: Ver miembro
- `PUT /api/comiconvi/{id}`: Actualizar miembro
- `DELETE /api/comiconvi/{id}`: Eliminar miembro

## Validaciones y Middleware

### Validaciones Comunes
- Autenticación requerida para todas las rutas excepto login
- Validación de datos de entrada según el modelo
- Verificación de permisos según el rol del usuario

### Middleware
- `auth:sanctum`: Verifica la autenticación
- `role:admin`: Verifica rol de administrador
- `role:profesor`: Verifica rol de profesor
- `role:comiconvi`: Verifica rol de comisión de convivencia 