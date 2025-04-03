/* eslint-disable */
<template>
  <div class="crear-amonestacion-page">
    <HeaderComponent />
    <main class="main-content">
      <div class="crear-amonestacion">
        <h2>Crear Amonestación</h2>
        <form @submit.prevent="enviarAmonestacion" class="formulario">
          <div class="form-group">
            <label for="gravedad">Gravedad:</label>
            <select id="gravedad" v-model="amonestacion.gravedad" required>
              <option value="">Seleccione una gravedad</option>
              <option value="grave">Grave</option>
              <option value="leve">Leve</option>
              <option value="convivencia">Convivencia</option>
            </select>
          </div>

          <div class="form-group">
            <label for="motivo">Motivo:</label>
            <textarea id="motivo" v-model="amonestacion.motivo" required />
          </div>

          <div class="form-group">
            <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" v-model="amonestacion.observaciones" />
          </div>

          <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" v-model="amonestacion.fecha" required />
          </div>

          <div class="form-group">
            <label for="documentos">Documentos adjuntos:</label>
            <input type="file" id="documentos" @change="handleFileUpload" multiple />
          </div>

          <div class="form-group checkbox">
            <label>
              <input type="checkbox" v-model="amonestacion.notificarCasa" />
              Notificar a casa
            </label>
          </div>

          <div class="botones">
            <button type="submit" class="btn-enviar">Enviar</button>
            <button type="button" class="btn-cancelar" @click="cancelar">Cancelar</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue';

export default {
  name: 'CrearAmonestacionComponent',
  components: {
    HeaderComponent,
  },
  data() {
    return {
      alumnoId: null,
      alumno: null,
      amonestacion: {
        gravedad: '',
        motivo: '',
        observaciones: '',
        fecha: new Date().toISOString().split('T')[0],
        documentos: [],
        notificarCasa: false,
      },
    };
  },
  methods: {
    handleFileUpload(event) {
      this.amonestacion.documentos = Array.from(event.target.files);
    },
    async enviarAmonestacion() {
      try {
        const formData = new FormData();
        formData.append('alumno_id', this.alumnoId);
        formData.append('gravedad', this.amonestacion.gravedad);
        formData.append('motivo', this.amonestacion.motivo);
        formData.append('observaciones', this.amonestacion.observaciones);
        formData.append('fecha_amonestacion', this.amonestacion.fecha);
        formData.append('notificacion_casa', this.amonestacion.notificarCasa ? 'true' : 'false');
        formData.append('comiconvi_id', 1);
        formData.append('curso_id', this.alumno.idCurso);

        // Añadir documentos si hay alguno
        if (this.amonestacion.documentos.length > 0) {
          formData.append('documentos_adjuntos', this.amonestacion.documentos[0]);
        }

        const response = await fetch('http://127.0.0.1:8000/api/amonestaciones', {
          method: 'POST',
          body: formData,
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Amonestación creada:', data);
        this.$router.push(`/alumno/${this.alumnoId}`);
      } catch (error) {
        console.error('Error al crear la amonestación:', error);
        alert('Error al crear la amonestación: ' + error.message);
      }
    },
    cancelar() {
      this.$router.push(`/alumno/${this.alumnoId}`);
    },
  },
  async mounted() {
    this.alumnoId = this.$route.params.id;
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/alumnos/${this.alumnoId}`);
      if (!response.ok) {
        throw new Error('Error al cargar los datos del alumno');
      }
      this.alumno = await response.json();
    } catch (error) {
      console.error('Error:', error);
      alert('Error al cargar los datos del alumno');
      this.$router.push('/cursos');
    }
  },
};
</script>

<style scoped>
.crear-amonestacion-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
  padding-top: 80px;
}

.crear-amonestacion {
  margin: 2rem auto;
  max-width: 800px;
  backdrop-filter: blur(10px);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.3);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  padding: 2rem;
}

h2 {
  color: #333;
  margin-bottom: 2rem;
  text-align: center;
  font-size: 1.8em;
}

.formulario {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

label {
  color: #333;
  font-weight: 500;
}

input[type='text'],
input[type='date'],
select,
textarea {
  padding: 0.8rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  background-color: rgba(255, 255, 255, 0.9);
}

textarea {
  min-height: 100px;
  resize: vertical;
}

.checkbox {
  flex-direction: row;
  align-items: center;
  gap: 0.5rem;
}

.checkbox input[type='checkbox'] {
  width: 18px;
  height: 18px;
}

.botones {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.btn-enviar,
.btn-cancelar {
  flex: 1;
  padding: 1rem;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-enviar {
  background-color: #4caf50;
  color: white;
}

.btn-enviar:hover {
  background-color: #45a049;
}

.btn-cancelar {
  background-color: #f44336;
  color: white;
}

.btn-cancelar:hover {
  background-color: #da190b;
}
</style>
