<template>
  <!-- Header -->
  <!-- eslint-disable --> 
  <HeaderComponent />
  <div class="cursos">
    <div class="filtros">
      <form @submit.prevent="filtrarCursos">
        <input type="text" v-model="busqueda" placeholder="Buscar curso..." class="buscador" />
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
      <div class="title-container">
        <img src="../assets/IES-Logo.jpg" alt="Logo Instituto" />
        <h2>IES Mestre Ramón Esteve</h2>
      </div>
    </div>

    <hr class="linea-divisiora" />

    <div class="contenido">
      <div v-if="cursos.length > 0" class="grid-container">
        <div v-for="curso in cursosFiltrados" :key="curso.id" class="curso-card" @click="obtenerAlumnosPorCurso(curso.id)">
          <a href="#">{{ curso.nombreCurso }} {{ curso.grupoCurso }}</a>
          <p>Número de alumnos: {{ curso.numero_alumnos }}</p>
        </div>
      </div>
      <p v-else>Cargando cursos...</p>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import HeaderComponent from './HeaderComponent.vue';
import '../assets/styles/cursos.css';

export default {
  name: 'CursosComponent',
  components: {
    HeaderComponent,
  },
  data() {
    return {
      busqueda: '',
      cursos: [], // Lista de cursos obtenidos de la BBDD
      cursosFiltrados: [], // Lista filtrada para búsqueda
      alumnos: [], // Lista de alumnos obtenidos de la BBDD
      alumnosFiltrados: [], // Lista filtrada para búsqueda
    };
  },
  methods: {
    async fetchCursos() {
      try {
        console.log('Iniciando petición a /api/cursos');
        const response = await fetch('http://127.0.0.1:8000/api/cursos', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('Respuesta recibida:', result);

        if (result) {
          this.cursos = result;
          this.cursosFiltrados = [...this.cursos];
        } else {
          console.error('No se encontraron cursos');
          this.cursos = [];
        }
      } catch (error) {
        console.error('Error al obtener los cursos:', error);
        this.cursos = [];
      }
    },
    filtrarCursos() {
      this.cursosFiltrados = this.cursos.filter((curso) =>
        curso.nombreCurso.toLowerCase().includes(this.busqueda.toLowerCase())
      );
    },
    async obtenerAlumnosPorCurso(cursoId) {
      this.$router.push(`/curso/${cursoId}/alumnos`);
    },
  },
  mounted() {
    this.fetchCursos();
  },
};
</script>
