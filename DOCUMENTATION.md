# Documentación Técnica del Proyecto de Amonestaciones

## Índice
1. [Arquitectura General](#arquitectura-general)
2. [Backend](#backend)
   - [Modelos](#modelos)
   - [Controladores](#controladores)
   - [Rutas](#rutas)
   - [Middleware](#middleware)
3. [Frontend](#frontend)
   - [Componentes](#componentes)
   - [Vistas](#vistas)
   - [Router](#router)
   - [Assets](#assets)
4. [Base de Datos](#base-de-datos)
5. [API Endpoints](#api-endpoints)

## Arquitectura General

El proyecto sigue una arquitectura cliente-servidor con:
- Backend: API REST con Laravel
- Frontend: SPA (Single Page Application) con Vue.js
- Base de datos: SQLite (configurable para MySQL)

## Backend

### Modelos

Los modelos se encuentran en `backend/app/Models/` y representan las entidades principales del sistema:

- `User.php`: Modelo de usuario del sistema
- `Amonestacion.php`: Modelo para las amonestaciones
- `Alumno.php`: Modelo para los alumnos
- `Profesor.php`: Modelo para los profesores

### Controladores

Los controladores se encuentran en `backend/app/Http/Controllers/` y manejan la lógica de negocio:

- `AuthController.php`: Maneja la autenticación
- `AmonestacionController.php`: Gestiona las operaciones CRUD de amonestaciones
- `AlumnoController.php`: Gestiona las operaciones de alumnos
- `ProfesorController.php`: Gestiona las operaciones de profesores

### Rutas

Las rutas API se definen en `backend/routes/api.php`:

```php
// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Rutas de amonestaciones
    Route::apiResource('amonestaciones', AmonestacionController::class);
    
    // Rutas de alumnos
    Route::apiResource('alumnos', AlumnoController::class);
    
    // Rutas de profesores
    Route::apiResource('profesores', ProfesorController::class);
});
```

### Middleware

Los middleware se encuentran en `backend/app/Http/Middleware/`:

- `Authenticate.php`: Verifica la autenticación
- `CheckRole.php`: Verifica los roles de usuario
- `HandleCors.php`: Maneja las políticas CORS

## Frontend

### Componentes

Los componentes Vue se encuentran en `frontend/src/components/`:

- `Login.vue`: Componente de inicio de sesión
- `AmonestacionForm.vue`: Formulario de creación/edición de amonestaciones
- `AmonestacionList.vue`: Lista de amonestaciones
- `AlumnoForm.vue`: Formulario de alumnos
- `ProfesorForm.vue`: Formulario de profesores

### Vistas

Las vistas principales se encuentran en `frontend/src/views/`:

- `Home.vue`: Página principal
- `Dashboard.vue`: Panel de control
- `Amonestaciones.vue`: Vista de amonestaciones
- `Alumnos.vue`: Vista de alumnos
- `Profesores.vue`: Vista de profesores

### Router

La configuración del router se encuentra en `frontend/src/router/index.js`:

```javascript
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  // ... más rutas
]
```

### Assets

Los recursos estáticos se encuentran en `frontend/src/assets/`:

- `styles/`: Archivos SCSS
- `images/`: Imágenes y recursos gráficos
- `icons/`: Iconos del sistema

## Base de Datos

### Esquema

El esquema de la base de datos se define en las migraciones en `backend/database/migrations/`:

```php
// users table
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});

// amonestaciones table
Schema::create('amonestaciones', function (Blueprint $table) {
    $table->id();
    $table->foreignId('alumno_id')->constrained();
    $table->foreignId('profesor_id')->constrained();
    $table->text('descripcion');
    $table->date('fecha');
    $table->timestamps();
});
```

## API Endpoints

### Autenticación

- `POST /api/login`: Iniciar sesión
- `POST /api/logout`: Cerrar sesión

### Amonestaciones

- `GET /api/amonestaciones`: Listar amonestaciones
- `POST /api/amonestaciones`: Crear amonestación
- `GET /api/amonestaciones/{id}`: Obtener amonestación
- `PUT /api/amonestaciones/{id}`: Actualizar amonestación
- `DELETE /api/amonestaciones/{id}`: Eliminar amonestación

### Alumnos

- `GET /api/alumnos`: Listar alumnos
- `POST /api/alumnos`: Crear alumno
- `GET /api/alumnos/{id}`: Obtener alumno
- `PUT /api/alumnos/{id}`: Actualizar alumno
- `DELETE /api/alumnos/{id}`: Eliminar alumno

### Profesores

- `GET /api/profesores`: Listar profesores
- `POST /api/profesores`: Crear profesor
- `GET /api/profesores/{id}`: Obtener profesor
- `PUT /api/profesores/{id}`: Actualizar profesor
- `DELETE /api/profesores/{id}`: Eliminar profesor 