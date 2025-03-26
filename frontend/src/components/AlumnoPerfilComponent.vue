<template>
  <div class="alumno-perfil-page">
    <HeaderComponent />
    <main class="main-content">
      <div class="alumno-perfil">
        <div class="perfil-header">
          <div class="foto-perfil">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
            </svg>
          </div>
          <div class="info-principal">
            <h1>{{ alumno.nombre }} {{ alumno.apellidos }}</h1>
            <div class="detalles">
              <p><strong>Curso:</strong> {{ alumno.curso }}</p>
              <p><strong>Edad:</strong> {{ alumno.edad }}</p>
              <p><strong>Amonestaciones:</strong> {{ alumno.amonestaciones }}</p>
            </div>
            <button class="btn-crear-amonestacion" @click="crearAmonestacion">
              Crear amonestacion
            </button>
          </div>
        </div>

        <hr class="linea-divisiora" />

        <div class="contacto-casa">
          <h2>Contacto a casa:</h2>
          <div class="info-contacto">
            <p><strong>Nombre ({{ alumno.parentesco }}):</strong> {{ alumno.nombreContacto }}</p>
            <p><strong>Correo:</strong> {{ alumno.correoContacto }}</p>
            <p><strong>Teléfono:</strong> {{ alumno.telefonoContacto }}</p>
          </div>
        </div>
      </div>
    </main>
    <FooterComponent />
  </div>
</template>

<script>
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
        nombre: 'Juan',
        apellidos: 'García Pérez',
        curso: '1 ESO (A)',
        edad: 13,
        amonestaciones: 3,
        parentesco: 'Madre',
        nombreContacto: 'María Pérez',
        correoContacto: 'maria.perez@email.com',
        telefonoContacto: '666777888'
      }
    }
  },
  methods: {
    crearAmonestacion() {
      console.log('Botón de crear amonestación pulsado');
      // Aquí irá la lógica para crear una amonestación
    }
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
  margin: 2rem auto;
  max-width: 1000px;
  backdrop-filter: blur(10px);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.3);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  padding: 2rem;
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

.btn-crear-amonestacion {
  background-color: #333;
  color: white;
  border: none;
  padding: 0.8rem 2rem;
  border-radius: 5px;
  font-size: 1.1em;
  cursor: pointer;
  transition: background-color 0.3s ease;
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
  color: #333;
  margin-bottom: 1rem;
  font-size: 1.5em;
}

.info-contacto p {
  margin: 0.5rem 0;
  font-size: 1.1em;
  color: #333;
}

@media (max-width: 768px) {
  .alumno-perfil {
    margin: 1rem;
    padding: 1rem;
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