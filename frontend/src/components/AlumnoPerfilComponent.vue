<template>
  <div class="alumno-perfil-page">
    <HeaderComponent />
    <main class="main-content">
      <div class="alumno-perfil">
        <div class="perfil-header">
          <div class="foto-perfil">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"
              />
            </svg>
          </div>
          <div class="info-principal">
            <h1>{{ alumno.nombre }} {{ alumno.apellidos }}</h1>
            <div class="detalles">
              <p><strong>Curso:</strong> {{ alumno.nombreCurso }} {{ alumno.grupoCurso }}</p>
              <p><strong>Edad:</strong> {{ alumno.edad }}</p>
              <p><strong>Amonestaciones:</strong> {{ alumno.amonestaciones }}</p>
            </div>
            <div class="btn-container">
              <button class="btn-crear-amonestacion" @click="crearAmonestacion">
                Crear amonestacion
              </button>
            </div>
          </div>
        </div>

        <hr class="linea-divisiora" />

        <div class="contacto-casa">
          <h2>Contacto a casa:</h2>
          <div class="info-contacto">
            <p><strong>Nombre:</strong> {{ alumno.nombrePadre }} | {{ alumno.nombreMadre }}</p>
            <p><strong>Correo:</strong> {{ alumno.correoPadre }} | {{ alumno.correoMadre }}</p>
            <p>
              <strong>Teléfono:</strong> {{ alumno.telefonoPadre }} | {{ alumno.telefonoMadre }}
            </p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
/* eslint-disable */
import HeaderComponent from './HeaderComponent.vue';
import FooterComponent from './FooterComponent.vue';

export default {
  name: 'AlumnoPerfilComponent',
  components: {
    HeaderComponent,
    FooterComponent
  },
  data() {
    return {
      alumno: {
        nombre: '',
        apellidos: '',
        nombreCurso: '',
        grupoCurso: '',
        edad: null,
        amonestaciones: 0,
        nombrePadre: '',
        nombreMadre: '',
        correoPadre: '',
        correoMadre: '',
        telefonoPadre: '',
        telefonoMadre: ''
      }
    }
  },
  methods: {
    async obtenerDatosAlumno() {
      try {
        const alumnoId = this.$route.params.id;
        console.log('Obteniendo datos del alumno:', alumnoId);
        
        const response = await fetch(`http://127.0.0.1:8000/api/alumnos/${alumnoId}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          credentials: 'include'
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Datos completos del alumno:', data);

        // Actualizar los datos del alumno
        this.alumno = {
          nombre: data.nombre || '',
          apellidos: data.apellidos || '',
          nombreCurso: data.curso?.nombreCurso || '',
          grupoCurso: data.curso?.grupoCurso || '',
          edad: data.edad || '',
          amonestaciones: data.amonestaciones?.length || 0,
          nombrePadre: data.nombrePadre || '',
          nombreMadre: data.nombreMadre || '',
          correoPadre: data.correoPadre || '',
          correoMadre: data.correoMadre || '',
          telefonoPadre: data.telefonoPadre || '',
          telefonoMadre: data.telefonoMadre || ''
        };
      } catch (error) {
        console.error('Error al obtener los datos del alumno:', error);
      }
    },
    crearAmonestacion() {
      console.log('Botón de crear amonestación pulsado para el alumno:', this.alumno.nombre);
    }
  },
  mounted() {
    this.obtenerDatosAlumno();
  }
}
</script>

<style scoped>
.alumno-perfil-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
  padding-top: 80px;
}

.alumno-perfil {
  margin: 15vh 20vh 0 20vh;
  backdrop-filter: blur(10px);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.3);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  padding: 10px;
}

.perfil-header {
  display: flex;
  gap: 2rem;
  align-items: center;
  margin-bottom: 2rem;
}

.foto-perfil {
  width: 150px;
  height: 150px;
  background-color: white;
  border-radius: 50%;
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.foto-perfil svg {
  width: 100%;
  height: 100%;
  color: #333;
}

.info-principal {
  flex: 1;
}

.info-principal h1 {
  font-size: 2em;
  color: white;
  margin-bottom: 1rem;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.detalles {
  margin-bottom: 1.5rem;
}

.detalles p {
  margin: 0.5rem 0;
  font-size: 1.1em;
  color: #333;
}

.btn-container {
  width: 100%;
}

.btn-crear-amonestacion {
  width: 100%;
  background-color: #333;
  color: white;
  border: none;
  padding: 1rem;
  border-radius: 5px;
  font-size: 1.1em;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-transform: uppercase;
  font-weight: bold;
}

.btn-crear-amonestacion:hover {
  background-color: #555;
}

.linea-divisiora {
  border: none;
  height: 2px;
  background-color: white;
  margin: 2rem 0;
  width: 100%;
  border-radius: 2px;
}

.contacto-casa {
  padding: 1rem 0;
}

.contacto-casa h2 {
  color: #000;
  margin-bottom: 1rem;
  font-size: 1.5em;
}

.info-contacto p {
  margin: 0.5rem 0;
  font-size: 1.1em;
  color: #000;
  font-weight: 500;
}

.info-contacto strong {
  color: #000;
  font-weight: 600;
}

@media (max-width: 768px) {
  .alumno-perfil {
    margin: 20vh 3vw 0 3vw;
  }

  .perfil-header {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }

  .foto-perfil {
    width: 120px;
    height: 120px;
    margin: 0 auto;
  }

  .info-principal h1 {
    font-size: 1.5em;
  }

  .detalles p, .info-contacto p {
    font-size: 1em;
  }
}

@media (max-width: 480px) {
  .alumno-perfil {
    margin: 20vh 2vw 0 2vw;
    padding: 5px;
  }

  .perfil-header {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }

  .foto-perfil {
    width: 120px;
    height: 120px;
    margin: 0 auto;
  }

  .info-principal h1 {
    font-size: 1.5em;
  }

  .detalles p, .info-contacto p {
    font-size: 1em;
  }
}
</style> 