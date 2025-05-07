<template>
  <div class="informes-container">
    <h2>Generación de Informes</h2>

    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <p>Generando informe...</p>
    </div>

    <div class="filtros">
      <div class="filtro-grupo">
        <label for="tipoInforme">Tipo de Informe:</label>
        <select id="tipoInforme" v-model="tipoInforme">
          <option value="diario">Informe Diario</option>
          <option value="mensual">Informe Mensual</option>
          <option value="curso">Informe por Curso</option>
          <option value="alumno">Informe por Alumno</option>
          <option value="profesor">Informe por Profesor</option>
        </select>
      </div>

      <!-- Filtros específicos según el tipo de informe -->
      <div class="filtro-grupo" v-if="tipoInforme === 'diario'">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" v-model="fecha" />
      </div>

      <div class="filtro-grupo" v-if="tipoInforme === 'mensual'">
        <label for="mes">Mes:</label>
        <select id="mes" v-model="mes">
          <option value="1">Enero</option>
          <option value="2">Febrero</option>
          <option value="3">Marzo</option>
          <option value="4">Abril</option>
          <option value="5">Mayo</option>
          <option value="6">Junio</option>
          <option value="7">Julio</option>
          <option value="8">Agosto</option>
          <option value="9">Septiembre</option>
          <option value="10">Octubre</option>
          <option value="11">Noviembre</option>
          <option value="12">Diciembre</option>
        </select>
        <label for="año">Año:</label>
        <input type="number" id="año" v-model="año" min="2024" max="2100" />
      </div>

      <div class="filtro-grupo" v-if="tipoInforme === 'curso'">
        <label for="curso">Curso:</label>
        <select id="curso" v-model="cursoSeleccionado">
          <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
            {{ curso.nombre }}
          </option>
        </select>
      </div>

      <div class="filtro-grupo" v-if="tipoInforme === 'alumno'">
        <label for="alumno">Alumno:</label>
        <select id="alumno" v-model="alumnoSeleccionado">
          <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
            {{ alumno.nombre }} {{ alumno.apellidos }}
          </option>
        </select>
      </div>

      <div class="filtro-grupo" v-if="tipoInforme === 'profesor'">
        <label for="profesor">Profesor:</label>
        <select id="profesor" v-model="profesorSeleccionado">
          <option v-for="profesor in profesores" :key="profesor.id" :value="profesor.id">
            {{ profesor.nombre }} {{ profesor.apellidos }}
          </option>
        </select>
      </div>
    </div>

    <div class="acciones">
      <button class="btn-generar" @click="generarInforme" :disabled="loading">
        <i class="fas fa-file-alt"></i>
        {{ loading ? 'Generando...' : 'Generar Informe' }}
      </button>
      <button class="btn-exportar" @click="exportarPDF" :disabled="!informeGenerado || loading">
        <i class="fas fa-file-pdf"></i>
        {{ loading ? 'Exportando...' : 'Exportar a PDF' }}
      </button>
    </div>

    <div v-if="error" class="error-message">
      <i class="fas fa-exclamation-circle"></i>
      {{ error }}
    </div>

    <div v-if="informeGenerado" class="informe-preview">
      <h3>Vista Previa del Informe</h3>
      <div class="informe-contenido" v-html="informeContenido"></div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'InformesComponent',
  data() {
    return {
      tipoInforme: 'diario',
      fecha: new Date().toISOString().split('T')[0],
      mes: new Date().getMonth() + 1,
      año: new Date().getFullYear(),
      cursoSeleccionado: null,
      alumnoSeleccionado: null,
      profesorSeleccionado: null,
      cursos: [],
      alumnos: [],
      profesores: [],
      informeGenerado: false,
      informeContenido: '',
      loading: false,
      error: null,
    };
  },
  methods: {
    async cargarDatos() {
      this.loading = true;
      this.error = null;
      try {
        // Cargar cursos
        const cursosRes = await axios.get('http://localhost:8000/api/cursos');
        this.cursos = cursosRes.data;

        // Cargar profesores
        const profesoresRes = await axios.get('http://localhost:8000/api/profesores');
        this.profesores = profesoresRes.data;

        // Cargar alumnos si es necesario
        if (this.tipoInforme === 'alumno') {
          const alumnosRes = await axios.get('http://localhost:8000/api/alumnos');
          this.alumnos = alumnosRes.data;
        }
      } catch (error) {
        console.error('Error al cargar datos:', error);
        this.error = 'Error al cargar los datos necesarios para el informe';
      } finally {
        this.loading = false;
      }
    },
    validarFiltros() {
      if (this.tipoInforme === 'diario' && !this.fecha) {
        throw new Error('Por favor, seleccione una fecha');
      }
      if (this.tipoInforme === 'mensual' && (!this.mes || !this.año)) {
        throw new Error('Por favor, seleccione mes y año');
      }
      if (this.tipoInforme === 'curso' && !this.cursoSeleccionado) {
        throw new Error('Por favor, seleccione un curso');
      }
      if (this.tipoInforme === 'alumno' && !this.alumnoSeleccionado) {
        throw new Error('Por favor, seleccione un alumno');
      }
      if (this.tipoInforme === 'profesor' && !this.profesorSeleccionado) {
        throw new Error('Por favor, seleccione un profesor');
      }
    },
    async generarInforme() {
      this.loading = true;
      this.error = null;
      this.informeGenerado = false;

      try {
        this.validarFiltros();

        const params = {
          tipo: this.tipoInforme,
        };

        switch (this.tipoInforme) {
          case 'diario':
            params.fecha = this.fecha;
            break;
          case 'mensual':
            params.mes = this.mes;
            params.año = this.año;
            break;
          case 'curso':
            params.curso_id = this.cursoSeleccionado;
            break;
          case 'alumno':
            params.alumno_id = this.alumnoSeleccionado;
            break;
          case 'profesor':
            params.profesor_id = this.profesorSeleccionado;
            break;
        }

        const response = await axios.get('http://localhost:8000/api/informes/generar', { params });

        if (response.data) {
          this.informeContenido = this.formatearInforme(response.data);
          this.informeGenerado = true;
        } else {
          this.informeContenido =
            '<div class="no-data">No hay datos disponibles para el período seleccionado</div>';
          this.informeGenerado = true;
        }
      } catch (error) {
        console.error('Error al generar informe:', error);
        this.error =
          error.response?.data?.message || error.message || 'Error al generar el informe';
      } finally {
        this.loading = false;
      }
    },
    async exportarPDF() {
      try {
        const params = {
          tipo: this.tipoInforme,
        };

        switch (this.tipoInforme) {
          case 'diario':
            params.fecha = this.fecha;
            break;
          case 'mensual':
            params.mes = this.mes;
            params.año = this.año;
            break;
          case 'curso':
            params.curso_id = this.cursoSeleccionado;
            break;
          case 'alumno':
            params.alumno_id = this.alumnoSeleccionado;
            break;
          case 'profesor':
            params.profesor_id = this.profesorSeleccionado;
            break;
        }

        const response = await axios.get('http://localhost:8000/api/informes/exportar', {
          params,
          responseType: 'blob',
        });

        const blob = new Blob([response.data], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `informe-${this.tipoInforme}-${new Date().toISOString().split('T')[0]}.pdf`;
        link.click();
        window.URL.revokeObjectURL(url);
      } catch (error) {
        console.error('Error al exportar PDF:', error);
        alert('Error al exportar el PDF. Por favor, intente nuevamente.');
      }
    },
    formatearInforme(data) {
      if (!data.amonestaciones || data.amonestaciones.length === 0) {
        return '<div class="no-data">No hay amonestaciones para mostrar</div>';
      }

      let html = `
        <div class="informe-header">
          <h4>Resumen</h4>
          <p>Total de Amonestaciones: ${data.resumen['Total Amonestaciones']}</p>
          
          <h5>Por Tipo:</h5>
          <ul>
            ${Object.entries(data.resumen['Por Tipo'])
              .map(([tipo, cantidad]) => `<li>${tipo}: ${cantidad}</li>`)
              .join('')}
          </ul>

          <h5>Por Gravedad:</h5>
          <ul>
            ${Object.entries(data.resumen['Por Gravedad'])
              .map(([gravedad, cantidad]) => `<li>${gravedad}: ${cantidad}</li>`)
              .join('')}
          </ul>
        </div>

        <div class="informe-content">
          <h4>Listado de Amonestaciones</h4>
          <table>
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Alumno</th>
                <th>Profesor</th>
                <th>Motivo</th>
                <th>Tipo</th>
                <th>Gravedad</th>
              </tr>
            </thead>
            <tbody>
              ${data.amonestaciones
                .map(
                  (a) => `
                <tr>
                  <td>${new Date(a.fecha_amonestacion).toLocaleDateString()}</td>
                  <td>${a.alumno ? `${a.alumno.nombre} ${a.alumno.apellidos}` : 'N/A'}</td>
                  <td>${a.comiconvi && a.comiconvi.profesores && a.comiconvi.profesores[0] 
                    ? `${a.comiconvi.profesores[0].nombre} ${a.comiconvi.profesores[0].apellidos}`
                    : 'N/A'}</td>
                  <td>${a.motivo || 'N/A'}</td>
                  <td>${a.tipo || 'N/A'}</td>
                  <td>${a.gravedad || 'N/A'}</td>
                </tr>
              `
                )
                .join('')}
            </tbody>
          </table>
        </div>
      `;

      return html;
    },
  },
  mounted() {
    this.cargarDatos();
  },
  watch: {
    tipoInforme() {
      this.informeGenerado = false;
      this.informeContenido = '';
      this.cargarDatos();
    },
  },
};
</script>

<style scoped>
.informes-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.filtros {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
  margin-bottom: 2rem;
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filtro-grupo {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.filtro-grupo label {
  font-weight: 500;
  color: #2c3e50;
}

.filtro-grupo select,
.filtro-grupo input {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.acciones {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
}

.btn-generar,
.btn-exportar {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-generar {
  background-color: #3498db;
  color: white;
}

.btn-generar:hover {
  background-color: #2980b9;
}

.btn-exportar {
  background-color: #2ecc71;
  color: white;
}

.btn-exportar:hover {
  background-color: #27ae60;
}

.btn-exportar:disabled {
  background-color: #95a5a6;
  cursor: not-allowed;
}

.informe-preview {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.informe-preview h3 {
  color: #2c3e50;
  margin-bottom: 1rem;
}

.informe-contenido {
  margin-top: 1rem;
}

.informe-contenido table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.informe-contenido th,
.informe-contenido td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.informe-contenido th {
  background-color: #f8f9fa;
  font-weight: 500;
}

.informe-contenido tr:hover {
  background-color: #f8f9fa;
}

@media (max-width: 768px) {
  .filtros {
    grid-template-columns: 1fr;
  }

  .acciones {
    flex-direction: column;
  }

  .btn-generar,
  .btn-exportar {
    width: 100%;
  }
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.error-message {
  background-color: #fee2e2;
  border: 1px solid #ef4444;
  color: #dc2626;
  padding: 1rem;
  border-radius: 4px;
  margin: 1rem 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.error-message i {
  font-size: 1.25rem;
}

.no-data {
  text-align: center;
  padding: 2rem;
  color: #6b7280;
  font-style: italic;
}
</style>
