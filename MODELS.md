# Documentación de Modelos

## Modelos del Sistema

### Amonestacion
**Ubicación**: `backend/app/Models/Amonestacion.php`

Modelo principal que representa una amonestación en el sistema.

```php
class Amonestacion extends Model
{
    protected $fillable = [
        'alumno_id',
        'profesor_id',
        'descripcion',
        'fecha',
        'tipo',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
```

### Alumno
**Ubicación**: `backend/app/Models/Alumno.php`

Modelo que representa a un alumno en el sistema.

```php
class Alumno extends Model
{
    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'fecha_nacimiento',
        'curso_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class);
    }
}
```

### Profesor
**Ubicación**: `backend/app/Models/Profesor.php`

Modelo que representa a un profesor en el sistema.

```php
class Profesor extends Model
{
    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'email',
        'departamento'
    ];

    // Relaciones
    public function amonestaciones()
    {
        return $this->hasMany(Amonestacion::class);
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class);
    }
}
```

### Curso
**Ubicación**: `backend/app/Models/Curso.php`

Modelo que representa un curso académico.

```php
class Curso extends Model
{
    protected $fillable = [
        'nombre',
        'nivel',
        'año_academico'
    ];

    // Relaciones
    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
}
```

### Asignatura
**Ubicación**: `backend/app/Models/Asignatura.php`

Modelo que representa una asignatura.

```php
class Asignatura extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'curso_id'
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class);
    }
}
```

### Notificacion
**Ubicación**: `backend/app/Models/Notificacion.php`

Modelo para gestionar las notificaciones del sistema.

```php
class Notificacion extends Model
{
    protected $fillable = [
        'tipo',
        'mensaje',
        'leida',
        'user_id'
    ];

    protected $casts = [
        'leida' => 'boolean'
    ];
}
```

### Configuracion
**Ubicación**: `backend/app/Models/Configuracion.php`

Modelo para gestionar la configuración del sistema.

```php
class Configuracion extends Model
{
    protected $fillable = [
        'clave',
        'valor',
        'descripcion'
    ];
}
```

### EstadisticaHistorica
**Ubicación**: `backend/app/Models/EstadisticaHistorica.php`

Modelo para almacenar estadísticas históricas.

```php
class EstadisticaHistorica extends Model
{
    protected $fillable = [
        'tipo',
        'valor',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];
}
```

## Relaciones entre Modelos

### Amonestaciones
- Pertenece a un Alumno
- Pertenece a un Profesor
- Tiene un tipo y estado

### Alumnos
- Pertenece a un Curso
- Tiene muchas Amonestaciones

### Profesores
- Tiene muchas Amonestaciones
- Pertenece a muchas Asignaturas

### Cursos
- Tiene muchos Alumnos
- Tiene muchas Asignaturas

### Asignaturas
- Pertenece a un Curso
- Pertenece a muchos Profesores

## Validaciones

Cada modelo incluye reglas de validación para asegurar la integridad de los datos:

### Amonestacion
- `alumno_id`: Requerido, existe en la tabla alumnos
- `profesor_id`: Requerido, existe en la tabla profesores
- `descripcion`: Requerido, texto
- `fecha`: Requerido, fecha válida
- `tipo`: Requerido, enum ['leve', 'grave', 'muy_grave']
- `estado`: Requerido, enum ['pendiente', 'resuelta', 'anulada']

### Alumno
- `nombre`: Requerido, string
- `apellidos`: Requerido, string
- `dni`: Requerido, único, formato válido
- `fecha_nacimiento`: Requerido, fecha válida
- `curso_id`: Requerido, existe en la tabla cursos

### Profesor
- `nombre`: Requerido, string
- `apellidos`: Requerido, string
- `dni`: Requerido, único, formato válido
- `email`: Requerido, email válido
- `departamento`: Requerido, string 