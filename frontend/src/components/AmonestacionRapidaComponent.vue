<template>
  <div class="amonestacion-rapida-page">
    <HeaderComponent />
    <main class="main-content">
      <div class="amonestacion-rapida">
        <h2>Amonestación Rápida</h2>

        <!-- Buscador de alumnos -->
        <div class="buscador-container">
          <input
            type="text"
            v-model="busqueda"
            @input="buscarAlumnos"
            placeholder="Buscar alumno por nombre..."
            class="buscador"
          />
          <div v-if="resultadosBusqueda.length > 0" class="resultados-busqueda">
            <div
              v-for="alumno in resultadosBusqueda"
              :key="alumno.id"
              class="resultado-item"
              @click="seleccionarAlumno(alumno)"
            >
              {{ alumno.nombre }} {{ alumno.apellidos }} - {{ alumno.nia }}
            </div>
          </div>
        </div>

        <!-- Formulario de amonestación -->
        <div v-if="alumnoSeleccionado" class="formulario-amonestacion">
          <div class="info-alumno">
            <h3>Información del Alumno</h3>
            <p>
              <strong>Nombre:</strong> {{ alumnoSeleccionado.nombre }}
              {{ alumnoSeleccionado.apellidos }}
            </p>
            <p><strong>NIA:</strong> {{ alumnoSeleccionado.nia }}</p>
            <p><strong>Curso:</strong> {{ alumnoSeleccionado.nombreCurso }}</p>
          </div>

          <div class="opciones-notificacion">
            <label class="checkbox-container">
              <input type="checkbox" v-model="amonestacion.notificacion_casa" />
              Notificar a casa
            </label>
          </div>

          <div class="form-group">
            <label for="motivo">Motivo de la Amonestación</label>
            <textarea
              id="motivo"
              v-model="amonestacion.motivo"
              class="form-control"
              rows="3"
              required
            ></textarea>
          </div>

          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea
              id="observaciones"
              v-model="amonestacion.observaciones"
              class="form-control"
              rows="3"
              required
            ></textarea>
          </div>

          <button class="btn-crear" @click="crearAmonestacion" :disabled="!puedeCrearAmonestacion">
            {{ estaCargando ? 'Creando...' : 'Crear Amonestación' }}
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue';

export default {
  name: 'AmonestacionRapidaComponent',
  components: {
    HeaderComponent,
  },
  data() {
    return {
      busqueda: '',
      resultadosBusqueda: [],
      alumnoSeleccionado: null,
      estaCargando: false,
      amonestacion: {
        gravedad: 1,
        motivo: 'Salida a convivencia',
        observaciones: 'Salida a convivencia por comportamiento inadecuado',
        notificacion_casa: false,
      },
      timeoutId: null,
    };
  },
  computed: {
    puedeCrearAmonestacion() {
      return (
        this.alumnoSeleccionado &&
        this.amonestacion.motivo.trim() !== '' &&
        this.amonestacion.observaciones.trim() !== '' &&
        !this.estaCargando
      );
    },
  },
  methods: {
    /**
     * Busca alumnos en el sistema basándose en el texto de búsqueda.
     * Implementa un debounce de 300ms para evitar múltiples peticiones al servidor.
     * Actualiza la lista de resultados de búsqueda con los alumnos encontrados.
     * 
     * @async
     * @returns {Promise<void>}
     */
    async buscarAlumnos() {
      // Limpiar el timeout anterior
      if (this.timeoutId) {
        clearTimeout(this.timeoutId);
      }

      // Si la búsqueda está vacía, limpiar resultados
      if (!this.busqueda.trim()) {
        this.resultadosBusqueda = [];
        return;
      }

      // Establecer un nuevo timeout para evitar múltiples peticiones
      this.timeoutId = setTimeout(async () => {
        try {
          const response = await fetch(
            `http://localhost:8000/api/alumnos?search=${encodeURIComponent(this.busqueda)}`
          );
          if (!response.ok) throw new Error('Error al buscar alumnos');

          const alumnos = await response.json();
          this.resultadosBusqueda = alumnos;
        } catch (error) {
          console.error('Error:', error);
          alert('Error al buscar alumnos');
        }
      }, 300); // 300ms de debounce
    },

    /**
     * Selecciona un alumno y carga sus datos completos, incluyendo información del curso.
     * Actualiza el estado del componente con los datos del alumno seleccionado.
     * 
     * @async
     * @param {Object} alumno - Objeto con los datos básicos del alumno seleccionado
     * @returns {Promise<void>}
     */
    async seleccionarAlumno(alumno) {
      try {
        // Obtener datos completos del alumno
        const response = await fetch(`http://localhost:8000/api/alumnos/${alumno.id}`);
        if (!response.ok) throw new Error('Error al obtener datos del alumno');

        const alumnoData = await response.json();

        // Obtener datos del curso
        if (alumnoData.idCurso) {
          const cursoResponse = await fetch(
            `http://localhost:8000/api/cursos/${alumnoData.idCurso}`
          );
          if (cursoResponse.ok) {
            const cursoData = await cursoResponse.json();
            alumnoData.nombreCurso = `${cursoData.nombreCurso} ${cursoData.grupoCurso}`;
          }
        }

        this.alumnoSeleccionado = alumnoData;
        this.resultadosBusqueda = [];
        this.busqueda = `${this.alumnoSeleccionado.nombre} ${this.alumnoSeleccionado.apellidos}`;
      } catch (error) {
        console.error('Error:', error);
        alert('Error al obtener datos del alumno');
      }
    },

    /**
     * Crea una nueva amonestación para el alumno seleccionado.
     * Envía los datos al servidor y maneja la respuesta.
     * Redirige al usuario a la página de cursos después de crear la amonestación.
     * 
     * @async
     * @returns {Promise<void>}
     */
    async crearAmonestacion() {
      if (!this.puedeCrearAmonestacion) return;

      this.estaCargando = true;
      try {
        const amonestacionData = {
          alumno_id: this.alumnoSeleccionado.id,
          curso_id: this.alumnoSeleccionado.idCurso,
          fecha_amonestacion: new Date().toISOString(),
          motivo: this.amonestacion.motivo.trim(),
          observaciones: this.amonestacion.observaciones.trim(),
          gravedad: 1,
          documentos_adjuntos: null,
          notificacion_casa: this.amonestacion.notificacion_casa,
          comiconvi_id: 1, // ID por defecto del comite de convivencia
        };

        const response = await fetch('http://localhost:8000/api/amonestaciones', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify(amonestacionData),
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Error al crear la amonestación');
        }

        alert('Amonestación creada correctamente');
        this.$router.push('/cursos');
      } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al crear la amonestación');
      } finally {
        this.estaCargando = false;
      }
    },
  },
};
</script>

<style scoped>
.amonestacion-rapida-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
  padding-top: 80px;
}

.amonestacion-rapida {
  margin: 2rem auto;
  max-width: 800px;
  backdrop-filter: blur(10px);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.3);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  padding: 2rem;
}

h2 {
  color: white;
  text-align: center;
  margin-bottom: 2rem;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.buscador-container {
  position: relative;
  margin-bottom: 2rem;
}

.buscador {
  width: 100%;
  padding: 1rem;
  border: none;
  border-radius: 5px;
  font-size: 1.1em;
  background-color: rgba(255, 255, 255, 0.9);
}

.resultados-busqueda {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background-color: white;
  border-radius: 5px;
  margin-top: 0.5rem;
  max-height: 300px;
  overflow-y: auto;
  z-index: 1000;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.resultado-item {
  padding: 0.8rem 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
  border-bottom: 1px solid #eee;
}

.resultado-item:last-child {
  border-bottom: none;
}

.resultado-item:hover {
  background-color: #f0f0f0;
}

.formulario-amonestacion {
  background-color: rgba(255, 255, 255, 0.9);
  padding: 2rem;
  border-radius: 5px;
}

.info-alumno {
  margin-bottom: 2rem;
}

.info-alumno h3 {
  color: #333;
  margin-bottom: 1rem;
}

.info-alumno p {
  margin: 0.5rem 0;
  color: #666;
}

.opciones-notificacion {
  display: flex;
  gap: 2rem;
  margin-bottom: 2rem;
}

.checkbox-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.form-group {
  margin: 1.5rem 0;
}

.form-control {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  resize: vertical;
}

.btn-crear {
  width: 100%;
  padding: 1rem;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 1.1em;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-crear:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

.btn-crear:hover:not(:disabled) {
  background-color: #45a049;
}

@media (max-width: 768px) {
  .amonestacion-rapida {
    margin: 1rem;
    padding: 1rem;
  }

  .opciones-notificacion {
    flex-direction: column;
    gap: 1rem;
  }
}
</style>
