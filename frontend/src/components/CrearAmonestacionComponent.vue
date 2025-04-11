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
              <option :value="1">Convivencia</option>
              <option :value="2">Leve</option>
              <option :value="3">Grave</option>
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
        observaciones: 'Sin observaciones',
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
        if (!this.amonestacion.gravedad) {
          throw new Error('Por favor, seleccione una gravedad');
        }
        if (!this.amonestacion.motivo.trim()) {
          throw new Error('Por favor, ingrese un motivo');
        }
        if (!this.amonestacion.fecha) {
          throw new Error('Por favor, seleccione una fecha');
        }

        const formData = new FormData();
        formData.append('alumno_id', Math.abs(parseInt(this.alumnoId)));
        formData.append('gravedad', this.amonestacion.gravedad);
        formData.append('motivo', this.amonestacion.motivo.trim());
        formData.append('observaciones', this.amonestacion.observaciones.trim());
        formData.append('fecha_amonestacion', this.amonestacion.fecha);
        formData.append('notificacion_casa', this.amonestacion.notificarCasa ? '1' : '0');
        formData.append('comiconvi_id', '1');
        formData.append('curso_id', Math.abs(parseInt(this.alumno.idCurso)));

        if (this.amonestacion.documentos.length > 0) {
          formData.append('documentos_adjuntos', this.amonestacion.documentos[0].name);
        }

        console.log('Enviando datos:', Object.fromEntries(formData));

        const response = await fetch('http://localhost:8000/api/amonestaciones', {
          method: 'POST',
          headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          credentials: 'include',
          body: formData,
        });

        const responseText = await response.text();
        console.log('Respuesta del servidor:', responseText);

        let errorData;
        try {
          errorData = JSON.parse(responseText);
        } catch (e) {
          console.error('Error al parsear la respuesta:', e);
          throw new Error('Error en la respuesta del servidor');
        }

        if (!response.ok) {
          console.error('Error response:', errorData);
          throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        console.log('Amonestación creada:', errorData);
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
      const response = await fetch(`http://localhost:8000/api/alumnos/${this.alumnoId}`, {
        headers: {
          Accept: 'application/json',
        },
        credentials: 'include',
      });
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
