<template>
  <div class="estadisticas-container">
    <h2>Estadísticas de Amonestaciones</h2>

    <div class="filtros">
      <div class="filtro-grupo">
        <label for="periodo">Periodo:</label>
        <select id="periodo" v-model="periodo">
          <option value="actual">Curso Actual</option>
          <option value="anterior">Curso Anterior</option>
          <option value="todos">Todos los Cursos</option>
        </select>
      </div>

      <div class="filtro-grupo" v-if="periodo === 'actual'">
        <label for="curso">Curso:</label>
        <select id="curso" v-model="cursoSeleccionado">
          <option value="">Todos los Cursos</option>
          <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
            {{ curso.nombre }}
          </option>
        </select>
      </div>
    </div>

    <div class="estadisticas-grid">
      <!-- Amonestaciones por Curso -->
      <div class="estadistica-card">
        <h3>Amonestaciones por Curso</h3>
        <canvas ref="graficoCursos"></canvas>
      </div>

      <!-- Amonestaciones por Mes -->
      <div class="estadistica-card">
        <h3>Amonestaciones por Mes</h3>
        <canvas ref="graficoMeses"></canvas>
      </div>

      <!-- Tipos de Amonestaciones -->
      <div class="estadistica-card">
        <h3>Tipos de Amonestaciones</h3>
        <canvas ref="graficoTipos"></canvas>
      </div>

      <!-- Profesores -->
      <div class="estadistica-card">
        <h3>Profesores</h3>
        <canvas ref="graficoProfesores"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Chart from 'chart.js/auto';

export default {
  name: 'EstadisticasComponent',
  data() {
    return {
      periodo: 'actual',
      cursoSeleccionado: '',
      cursos: [],
      graficos: {
        cursos: null,
        meses: null,
        tipos: null,
        profesores: null,
      },
    };
  },
  methods: {
    async cargarDatos() {
      try {
        // Cargar cursos
        const cursosRes = await axios.get('http://localhost:8000/api/cursos');
        this.cursos = cursosRes.data;

        // Cargar estadísticas
        const estadisticasRes = await axios.get(
          'http://localhost:8000/api/amonestaciones/estadisticas',
          {
            params: {
              periodo: this.periodo,
              curso: this.cursoSeleccionado,
            },
          }
        );

        if (estadisticasRes.data) {
          this.actualizarGraficos(estadisticasRes.data);
        } else {
          console.warn('No se recibieron datos de estadísticas');
          this.mostrarMensajeNoDatos();
        }
      } catch (error) {
        console.error('Error al cargar datos:', error);
        this.mostrarMensajeNoDatos();
      }
    },
    actualizarGraficos(datos) {
      // Destruir gráficos existentes
      Object.values(this.graficos).forEach((grafico) => {
        if (grafico) {
          grafico.destroy();
        }
      });

      // Amonestaciones por Curso
      if (datos.porCurso && datos.porCurso.length > 0) {
        this.graficos.cursos = new Chart(this.$refs.graficoCursos, {
          type: 'bar',
          data: {
            labels: datos.porCurso.map((item) => item.curso),
            datasets: [
              {
                label: 'Amonestaciones',
                data: datos.porCurso.map((item) => item.total),
                backgroundColor: '#3498db',
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      } else {
        this.$refs.graficoCursos.parentElement.innerHTML +=
          '<p class="no-data">No hay datos disponibles</p>';
      }

      // Amonestaciones por Mes
      if (datos.porMes && datos.porMes.length > 0) {
        this.graficos.meses = new Chart(this.$refs.graficoMeses, {
          type: 'line',
          data: {
            labels: datos.porMes.map((item) => item.mes),
            datasets: [
              {
                label: 'Amonestaciones',
                data: datos.porMes.map((item) => item.total),
                borderColor: '#2ecc71',
                tension: 0.1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      } else {
        this.$refs.graficoMeses.parentElement.innerHTML +=
          '<p class="no-data">No hay datos disponibles</p>';
      }

      // Tipos de Amonestaciones
      if (datos.porTipo && datos.porTipo.length > 0) {
        this.graficos.tipos = new Chart(this.$refs.graficoTipos, {
          type: 'pie',
          data: {
            labels: datos.porTipo.map((item) => item.tipo),
            datasets: [
              {
                data: datos.porTipo.map((item) => item.total),
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f1c40f'],
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      } else {
        this.$refs.graficoTipos.parentElement.innerHTML +=
          '<p class="no-data">No hay datos disponibles</p>';
      }

      // Profesores
      if (datos.porProfesor && datos.porProfesor.length > 0) {
        this.graficos.profesores = new Chart(this.$refs.graficoProfesores, {
          type: 'bar',
          data: {
            labels: datos.porProfesor.map((item) => item.profesor),
            datasets: [
              {
                label: 'Amonestaciones',
                data: datos.porProfesor.map((item) => item.total),
                backgroundColor: '#9b59b6',
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
          },
        });
      } else {
        this.$refs.graficoProfesores.parentElement.innerHTML +=
          '<p class="no-data">No hay datos disponibles</p>';
      }
    },
    mostrarMensajeNoDatos() {
      const mensaje = '<p class="no-data">No hay datos disponibles para mostrar</p>';
      this.$refs.graficoCursos.parentElement.innerHTML = mensaje;
      this.$refs.graficoMeses.parentElement.innerHTML = mensaje;
      this.$refs.graficoTipos.parentElement.innerHTML = mensaje;
      this.$refs.graficoProfesores.parentElement.innerHTML = mensaje;
    },
  },
  mounted() {
    this.cargarDatos();
  },
  watch: {
    periodo() {
      this.cargarDatos();
    },
    cursoSeleccionado() {
      this.cargarDatos();
    },
  },
};
</script>

<style scoped>
.estadisticas-container {
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

.filtro-grupo select {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.estadisticas-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.estadistica-card {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  height: 400px;
}

.estadistica-card h3 {
  color: #2c3e50;
  margin-bottom: 1rem;
}

.no-data {
  color: #7f8c8d;
  text-align: center;
  font-size: 1.1rem;
  margin-top: 2rem;
}

@media (max-width: 768px) {
  .estadisticas-grid {
    grid-template-columns: 1fr;
  }

  .estadistica-card {
    height: 300px;
  }
}
</style>
