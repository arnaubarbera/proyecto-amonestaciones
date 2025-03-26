<template>
  <div class="alumnos-container">
    <HeaderComponent />
    <div class="alumnos">
      <div class="filtros">
        <form @submit.prevent="filtrarAlumnos">
          <!-- Filtrar por el nombre del alumno -->
          <input class="buscador" type="text" v-model="busqueda" placeholder="Buscar alumno..." />

          <!-- Filtrar por cursos -->
          <select class="select curso" v-model="cursoSeleccionado">
            <option value="curso">Curso</option>
            <option v-for="curso in cursos" :key="curso.id" :value="curso.nombreCurso">
              {{ curso.nombreCurso }} {{ curso.grupoCurso }}
            </option>
          </select>

          <!-- Boton para enviar From Uiverse.io by Peary74 -->
          <button type="submit" class="btnBuscar">
            <div class="svg-wrapper-1">
              <div class="svg-wrapper">
                <svg
                  version="1.1"
                  id="Capa_1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="612.08px"
                  height="612.08px"
                  viewBox="0 0 612.08 612.08"
                  style="enable-background: new 0 0 612.08 612.08"
                  xml:space="preserve"
                >
                  <g>
                    <path
                      d="M237.927,0C106.555,0,0.035,106.52,0.035,237.893c0,131.373,106.52,237.893,237.893,237.893
                                c50.518,0,97.368-15.757,135.879-42.597l0.028-0.028l176.432,176.433c3.274,3.274,8.48,3.358,11.839,0l47.551-47.551
                                c3.274-3.274,3.106-8.703-0.028-11.838L433.223,373.8c26.84-38.539,42.597-85.39,42.597-135.907C475.82,106.52,369.3,0,237.927,0z
                                 M237.927,419.811c-100.475,0-181.918-81.443-181.918-181.918S137.453,55.975,237.927,55.975s181.918,81.443,181.918,181.918
                                S338.402,419.811,237.927,419.811z"
                    />
                  </g>
                </svg>
              </div>
            </div>
            <span>Buscar</span>
          </button>
        </form>
        <h2 class="subTitulo">Alumnos</h2>
      </div>

      <hr class="linea-divisiora" />

      <div class="contenido">
        <div v-if="alumnos.length > 0" class="grid-container">
          <div v-for="alumno in alumnosFiltrados" :key="alumno.id" class="alumno-card">
            <a href="">{{ alumno.nombre }} {{ alumno.apellidos }}</a>
            <p>{{ alumno.curso?.nombreCurso }} {{ alumno.curso?.grupoCurso }}</p>
          </div>
        </div>
        <p v-else>Cargando alumnos...</p>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import '../assets/styles/alumnos.css';
import HeaderComponent from './HeaderComponent.vue';

export default {
  name: 'AlumnosComponent',
  components: {
    HeaderComponent,
  },
  data() {
    return {
      alumnos: [], // Lista de alumnos
      alumnosFiltrados: [],
      cursos: [], // Lista de cursos
      busqueda: '',
      cursoSeleccionado: 'curso', // Establecer "Curso" por defecto
    };
  },
  methods: {
    async obtenerAlumnos() {
      try {
        console.log('Iniciando petición a /api/alumnos');
        const response = await fetch('http://127.0.0.1:8000/api/alumnos', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          },
          credentials: 'include'
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('Respuesta recibida:', result);

        if (result) {
          this.alumnos = result;
          this.alumnosFiltrados = [...this.alumnos];
        } else {
          console.error('No se encontraron alumnos');
          this.alumnos = [];
        }
      } catch (error) {
        console.error('Error al obtener los alumnos:', error);
        this.alumnos = [];
      }
    },
    async obtenerCursos() {
      try {
        console.log('Iniciando petición a /api/cursos');
        const response = await fetch('http://127.0.0.1:8000/api/cursos', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          },
          credentials: 'include'
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('Respuesta recibida:', result);

        if (result) {
          this.cursos = result;
        } else {
          console.error('No se encontraron cursos');
          this.cursos = [];
        }
      } catch (error) {
        console.error('Error al obtener los cursos:', error);
        this.cursos = [];
      }
    },
    filtrarAlumnos() {
      this.alumnosFiltrados = this.alumnos.filter((alumno) => {
        let matchNombre =
          alumno.nombre.toLowerCase().includes(this.busqueda.toLowerCase()) ||
          alumno.apellidos.toLowerCase().includes(this.busqueda.toLowerCase());
        let matchCurso =
          this.cursoSeleccionado === 'curso' || 
          `${alumno.curso?.nombreCurso} ${alumno.curso?.grupoCurso}` === this.cursoSeleccionado;

        return matchNombre && matchCurso;
      });
    },
  },
  mounted() {
    this.obtenerAlumnos();
    this.obtenerCursos();
  },
};
</script>
