<template>
  <HeaderComponent />
  <div class="alumnos">
    <h1 class="titulo">{{ nombreCurso }}</h1>

    <hr class="linea-divisiora" />

    <div class="contenido">
      <div v-if="alumnosFiltrados.length > 0" class="grid-container">
        <div v-for="alumno in alumnosFiltrados" :key="alumno.id" class="alumno-card">
          <a href="">{{ alumno.nombre }} {{ alumno.apellidos }}</a>
        </div>
      </div>
      <p v-else>Cargando alumnos...</p>
    </div>
  </div>
  <!-- No repetimos el FooterComponent aquí ya que está en la vista principal -->
</template>

<script>
import HeaderComponent from './HeaderComponent.vue';
import '@/assets/styles/cursos.css';

export default {
  name: 'CursoComponent',
  components: {
    HeaderComponent,
  },
  data() {
    return {
      alumnos: [], // Lista de alumnos
      alumnosFiltrados: [], // Alumnos filtrados
      grupos: [], // Lista de grupos
      grupoSeleccionado: '', // Grupo seleccionado
      nombreCurso: '',
    };
  },
  methods: {
    // Obtener los alumnos desde la base de datos
    async obtenerAlumnos() {
      try {
        const cursoNombre = this.$route.params.curso;
        const response = await fetch(
          `http://localhost/proyectoGestionConvivencia/backend/api/ObtenerAlumnos.php?curso=${encodeURIComponent(
            cursoNombre
          )}`
        );
        const data = await response.json();
        if (data.success) {
          this.alumnos = data.data;
          this.alumnosFiltrados = data.data; // Por defecto, mostramos todos los alumnos
          if (this.alumnos.length > 0) {
            this.nombreCurso = this.alumnos[0].nombreCurso;
          } else {
            this.nombreCurso = 'Curso no encontrado';
          }
        } else {
          console.error(data.message);
        }
      } catch (error) {
        console.error('Error al obtener los alumnos:', error);
      }
    },

    // Obtener los grupos desde la base de datos
    async obtenerGrupos() {
      try {
        const response = await fetch(
          'http://localhost/proyectoGestionConvivencia/backend/api/ObtenerCursos.php'
        );
        const data = await response.json();
        if (data.success) {
          this.grupos = data.data; // Lista de grupos
        } else {
          console.error(data.message);
        }
      } catch (error) {
        console.error('Error al obtener los grupos:', error);
      }
    },

    // Filtrar alumnos por grupo
    filtrarAlumnos() {
      if (this.grupoSeleccionado) {
        this.alumnosFiltrados = this.alumnos.filter(
          (alumno) => alumno.grupoCurso === this.grupoSeleccionado
        );
      } else {
        this.alumnosFiltrados = this.alumnos;
      }
    },

    // Método para crear una amonestación
    crearAmonestacion(alumnoId) {
      this.$router.push(`/crear-amonestacion/${alumnoId}`);
    },
  },
  mounted() {
    this.obtenerAlumnos();
    this.obtenerGrupos();
  },
};
</script>

<style scoped>
/* Contenedor principal */
.alumnos {
  margin: 15vh 20vh 0 20vh;
  backdrop-filter: blur(10px);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.3);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  padding: 10px;
}

.titulo {
  color: white;
  text-align: center;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  font-size: 2.5em;
}

.linea-divisiora {
  border: none;
  height: 2px;
  background-color: white;
  margin: 5px 0;
  width: 100%;
  border-radius: 2px;
}

/*ESTILOS PARA EL CONTENEDOR QUE TENDRÁ TODAS LAS TARGETAS DE LOS ALUMNOS*/
.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
  padding: 1rem;
}

/*Targetas de los alumnos*/
.alumno-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 5px;
  padding: 15px;
  border-radius: 5px;
  background-color: rgb(255, 255, 255);
  font-size: 1.25em;
  cursor: pointer;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  transition: ease 0.2s;
}

.alumno-card a {
  text-decoration: none;
  color: black;
  font-weight: 600;
  font-size: 1.5em;
}

.alumno-card p {
  font-size: 0.75em;
}

.alumno-card:hover {
  transform: scale(101%);
}

/* Tablets (pantallas medianas) */
@media (max-width: 1024px) {
  .alumnos {
    margin: 20vh 5vw 0 5vw;
  }

  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }

  .alumno-card {
    font-size: 1.1em;
    padding: 8px;
  }
}

/* Móviles (pantallas pequeñas) */
@media (max-width: 768px) {
  .alumnos {
    margin: 20vh 3vw 0 3vw;
  }

  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
  }

  .alumno-card {
    font-size: 1em;
    padding: 5px;
  }
}

/* Móviles muy pequeños */
@media (max-width: 480px) {
  .alumnos {
    margin: 20vh 2vw 0 2vw;
    padding: 5px;
  }

  .grid-container {
    grid-template-columns: 1fr;
  }

  .alumno-card {
    font-size: 0.9em;
    padding: 5px;
  }
}
</style>
