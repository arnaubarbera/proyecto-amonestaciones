# Proyecto de Amonestaciones

Este proyecto es una aplicación web para la gestión de amonestaciones, desarrollada con Laravel en el backend y Vue.js en el frontend.

## Estructura del Proyecto

El proyecto está dividido en dos partes principales:

### Backend (Laravel)

El backend está desarrollado con Laravel 12 y utiliza las siguientes tecnologías y dependencias principales:

- PHP 8.2 o superior
- Laravel Framework 12.0
- Laravel Sanctum para autenticación
- Laravel DomPDF para generación de PDFs
- Laravel Tinker para interacción con la consola

#### Estructura de Directorios del Backend

```
backend/
├── app/            # Contiene el código principal de la aplicación
├── config/         # Archivos de configuración
├── database/       # Migraciones y seeders
├── routes/         # Definición de rutas
├── resources/      # Vistas y assets
├── storage/        # Archivos generados por la aplicación
├── tests/          # Tests automatizados
└── vendor/         # Dependencias de Composer
```

### Frontend (Vue.js)

El frontend está desarrollado con Vue.js 3 y utiliza las siguientes tecnologías:

- Vue.js 3.2
- Vue Router 4.0
- Axios para peticiones HTTP
- SASS para estilos

#### Estructura de Directorios del Frontend

```
frontend/
├── src/            # Código fuente de Vue.js
├── public/         # Archivos públicos
└── node_modules/   # Dependencias de npm
```

## Requisitos del Sistema

### Backend
- PHP >= 8.2
- Composer
- MySQL o SQLite
- Node.js y npm

### Frontend
- Node.js
- npm o yarn

## Instalación

### Backend

1. Navegar al directorio del backend:
```bash
cd backend
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Configurar el archivo .env:
```bash
cp .env.example .env
php artisan key:generate
```

4. Ejecutar migraciones:
```bash
php artisan migrate
```

### Frontend

1. Navegar al directorio del frontend:
```bash
cd frontend
```

2. Instalar dependencias:
```bash
npm install
```

## Desarrollo

### Backend

Para iniciar el servidor de desarrollo del backend:
```bash
php artisan serve
```

### Frontend

Para iniciar el servidor de desarrollo del frontend:
```bash
npm run serve
```

## Scripts Disponibles

### Backend
- `php artisan serve`: Inicia el servidor de desarrollo
- `php artisan migrate`: Ejecuta las migraciones de la base de datos
- `php artisan test`: Ejecuta los tests

### Frontend
- `npm run serve`: Inicia el servidor de desarrollo
- `npm run build`: Compila el proyecto para producción
- `npm run lint`: Ejecuta el linter

## Base de Datos

El proyecto utiliza una base de datos SQLite por defecto, pero puede ser configurada para usar MySQL u otros sistemas de base de datos modificando el archivo `.env`.

## Contribución

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. 