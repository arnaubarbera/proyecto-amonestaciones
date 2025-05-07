<template>
  <div class="generalHeader">
    <!-- Menú -->
    <div class="menu">
      <button class="btnMenu" @click="toggleMenu">
        <img class="icon" src="../assets/svg/menu.svg" alt="Abrir menú" />
      </button>
    </div>

    <!-- Contenedor del menú deslizante -->
    <div class="menu-container" :class="{ 'menu-open': isMenuOpen }">
      <div class="subMenu">
        <ul>
          <li @click="navigate('/alumnos')">Alumnos</li>
          <li @click="navigate('/cursos')">Cursos</li>
          <li @click="navigate('/amonestacion-rapida')">Amonestación Rápida</li>
          <li @click="navigate('/informes')">Informes</li>
          <li @click="navigate('/estadisticas')">Estadísticas</li>
          <li v-if="isAdmin" @click="navigate('/admin')">Administración</li>
          <li
            @click="navigate('https://portal.edu.gva.es/iesmestreramonesteve/es/centro/contacte/')"
          >
            Contacto
          </li>
        </ul>
        <!-- Línea divisoria -->
        <hr class="styled-hr" />

        <button class="close-menu" @click="toggleMenu">Cerrar</button>
      </div>
    </div>

    <!-- Logo -->
    <div class="logo">
      <h1 @click="navigate('/cursos')">Gestión de Convivencia</h1>
    </div>

    <!-- Usuario -->
    <div class="user">
      <p>{{ userName }}</p>
      <button class="btnMenu" @click="toggleUserPopup">
        <img class="icon" src="../assets/svg/user.svg" alt="Usuario" />
      </button>

      <!-- Popup del menú de usuario -->
      <div class="user-popup" v-if="isUserPopupOpen" ref="userPopup">
        <ul>
          <!-- <li class="config" @click="openSettings">Configuración</li> -->
          <li class="logout" @click="logout">Cerrar sesión</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import '../assets/styles/header.css';

export default {
  name: 'HeaderComponent',
  data() {
    return {
      userName: '',
      isMenuOpen: false,
      isUserPopupOpen: false,
      isAdmin: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    toggleUserPopup() {
      this.isUserPopupOpen = !this.isUserPopupOpen;
    },
    closeUserPopup(event) {
      if (this.$refs.userPopup && !this.$refs.userPopup.contains(event.target)) {
        this.isUserPopupOpen = false;
      }
    },
    navigate(destination) {
      if (destination.startsWith('http')) {
        //Navegar y redirigir a una pagina externa
        window.location.href = destination;
      } else {
        //Navegar dentro de nuestra aplicacion
        this.$router.push(destination);
      }
      this.isMenuOpen = false; // Cierra el menú después de seleccionar
    },
    openSettings() {
      console.log('Abriendo configuración...');
    },
    logout() {
      localStorage.removeItem('usuario'); // Elimina el elemento del almacenamiento local
      window.location.reload(); // Recarga la página automáticamente
    },
    async fetchUserName() {
      try {
        const usuario = JSON.parse(localStorage.getItem('usuario'));
        if (usuario) {
          this.userName = `${usuario.nombre} ${usuario.apellidos}`;
          this.isAdmin = usuario.role === 'admin';
        }
      } catch (error) {
        console.error('Error al obtener el nombre del usuario: ', error);
      }
    },
  },
  mounted() {
    this.fetchUserName(); // Llama a la función para cargar el nombre del usuario al montar el componente
  },
  beforeUnmount() {
    window.removeEventListener('click', this.closeUserPopup);
  },
};
</script>
