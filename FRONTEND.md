# Documentación del Frontend

## Componentes Vue.js

### Componentes de Autenticación

#### LoginComponent
**Ubicación**: `frontend/src/components/LoginComponent.vue`

Componente para el inicio de sesión de usuarios.

```vue
<template>
  <div class="login-container">
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email">
      <input v-model="password" type="password" placeholder="Contraseña">
      <button type="submit">Iniciar Sesión</button>
    </form>
  </div>
</template>
```

### Componentes de Amonestaciones

#### CrearAmonestacionComponent
**Ubicación**: `frontend/src/components/CrearAmonestacionComponent.vue`

Componente para crear nuevas amonestaciones.

```vue
<template>
  <div class="amonestacion-form">
    <form @submit.prevent="crearAmonestacion">
      <select v-model="alumno_id">
        <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
          {{ alumno.nombre }}
        </option>
      </select>
      <textarea v-model="descripcion" placeholder="Descripción"></textarea>
      <select v-model="tipo">
        <option value="leve">Leve</option>
        <option value="grave">Grave</option>
        <option value="muy_grave">Muy Grave</option>
      </select>
      <button type="submit">Crear Amonestación</button>
    </form>
  </div>
</template>
```

#### AmonestacionRapidaComponent
**Ubicación**: `frontend/src/components/AmonestacionRapidaComponent.vue`

Componente para crear amonestaciones de forma rápida.

```vue
<template>
  <div class="amonestacion-rapida">
    <div class="buscador">
      <input v-model="busqueda" @input="buscarAlumnos" placeholder="Buscar alumno...">
    </div>
    <div class="resultados" v-if="alumnosEncontrados.length">
      <div v-for="alumno in alumnosEncontrados" :key="alumno.id" @click="seleccionarAlumno(alumno)">
        {{ alumno.nombre }}
      </div>
    </div>
  </div>
</template>
```

### Componentes de Gestión

#### AdminPanel
**Ubicación**: `frontend/src/components/AdminPanel.vue`

Panel de administración del sistema.

```vue
<template>
  <div class="admin-panel">
    <nav class="admin-nav">
      <router-link to="/usuarios">Usuarios</router-link>
      <router-link to="/configuracion">Configuración</router-link>
      <router-link to="/estadisticas">Estadísticas</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>
```

#### CursosComponent
**Ubicación**: `frontend/src/components/CursosComponent.vue`

Componente para gestionar cursos.

```vue
<template>
  <div class="cursos">
    <div class="cursos-lista">
      <div v-for="curso in cursos" :key="curso.id" class="curso-item">
        <h3>{{ curso.nombre }}</h3>
        <p>{{ curso.nivel }}</p>
        <button @click="verDetalles(curso)">Ver Detalles</button>
      </div>
    </div>
  </div>
</template>
```

#### AlumnosComponent
**Ubicación**: `frontend/src/components/AlumnosComponent.vue`

Componente para gestionar alumnos.

```vue
<template>
  <div class="alumnos">
    <div class="filtros">
      <input v-model="busqueda" placeholder="Buscar alumno...">
      <select v-model="cursoFiltro">
        <option value="">Todos los cursos</option>
        <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
          {{ curso.nombre }}
        </option>
      </select>
    </div>
    <table class="alumnos-tabla">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Curso</th>
          <th>Amonestaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="alumno in alumnosFiltrados" :key="alumno.id">
          <td>{{ alumno.nombre }}</td>
          <td>{{ alumno.curso.nombre }}</td>
          <td>{{ alumno.amonestaciones.length }}</td>
          <td>
            <button @click="verPerfil(alumno)">Ver Perfil</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
```

### Componentes de Información

#### Informes
**Ubicación**: `frontend/src/components/Informes.vue`

Componente para generar y visualizar informes.

```vue
<template>
  <div class="informes">
    <div class="filtros-informe">
      <select v-model="tipoInforme">
        <option value="amonestaciones">Amonestaciones</option>
        <option value="alumnos">Alumnos</option>
        <option value="cursos">Cursos</option>
      </select>
      <input type="date" v-model="fechaInicio">
      <input type="date" v-model="fechaFin">
      <button @click="generarInforme">Generar Informe</button>
    </div>
    <div class="informe-resultado" v-if="informe">
      <!-- Contenido del informe -->
    </div>
  </div>
</template>
```

#### AlumnoPerfilComponent
**Ubicación**: `frontend/src/components/AlumnoPerfilComponent.vue`

Componente para ver el perfil detallado de un alumno.

```vue
<template>
  <div class="alumno-perfil">
    <div class="info-basica">
      <h2>{{ alumno.nombre }}</h2>
      <p>Curso: {{ alumno.curso.nombre }}</p>
    </div>
    <div class="amonestaciones">
      <h3>Amonestaciones</h3>
      <div v-for="amonestacion in amonestaciones" :key="amonestacion.id" class="amonestacion-item">
        <p>{{ amonestacion.descripcion }}</p>
        <p>Fecha: {{ amonestacion.fecha }}</p>
        <p>Tipo: {{ amonestacion.tipo }}</p>
      </div>
    </div>
  </div>
</template>
```

### Componentes de Navegación

#### HeaderComponent
**Ubicación**: `frontend/src/components/HeaderComponent.vue`

Componente de cabecera con navegación.

```vue
<template>
  <header class="header">
    <nav>
      <router-link to="/">Inicio</router-link>
      <router-link to="/amonestaciones">Amonestaciones</router-link>
      <router-link to="/alumnos">Alumnos</router-link>
      <router-link to="/cursos">Cursos</router-link>
      <router-link to="/informes">Informes</router-link>
    </nav>
    <div class="user-info">
      <span>{{ usuario.nombre }}</span>
      <button @click="logout">Cerrar Sesión</button>
    </div>
  </header>
</template>
```

#### FooterComponent
**Ubicación**: `frontend/src/components/FooterComponent.vue`

Componente de pie de página.

```vue
<template>
  <footer class="footer">
    <p>&copy; 2024 Sistema de Amonestaciones</p>
  </footer>
</template>
```

## Estilos y Assets

### Estilos Globales
Los estilos globales se encuentran en `frontend/src/assets/styles/`:

- `main.scss`: Estilos principales
- `variables.scss`: Variables de estilo
- `components/`: Estilos específicos de componentes

### Imágenes y Recursos
Los recursos estáticos se encuentran en `frontend/src/assets/`:

- `images/`: Imágenes del sistema
- `icons/`: Iconos SVG
- `fonts/`: Fuentes personalizadas

## Router

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
    component: LoginComponent
  },
  {
    path: '/amonestaciones',
    name: 'Amonestaciones',
    component: AmonestacionRapidaComponent,
    meta: { requiresAuth: true }
  },
  {
    path: '/alumnos',
    name: 'Alumnos',
    component: AlumnosComponent,
    meta: { requiresAuth: true }
  },
  {
    path: '/cursos',
    name: 'Cursos',
    component: CursosComponent,
    meta: { requiresAuth: true }
  },
  {
    path: '/informes',
    name: 'Informes',
    component: Informes,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin',
    name: 'Admin',
    component: AdminPanel,
    meta: { requiresAuth: true, requiresAdmin: true }
  }
]
```

## Estado Global (Vuex)

El estado global se gestiona con Vuex en `frontend/src/store/`:

```javascript
export default new Vuex.Store({
  state: {
    usuario: null,
    token: null,
    amonestaciones: [],
    alumnos: [],
    cursos: []
  },
  mutations: {
    setUsuario(state, usuario) {
      state.usuario = usuario
    },
    setToken(state, token) {
      state.token = token
    }
  },
  actions: {
    async login({ commit }, credentials) {
      // Lógica de login
    },
    async logout({ commit }) {
      // Lógica de logout
    }
  }
})
``` 