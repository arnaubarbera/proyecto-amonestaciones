<template>
  <header>
    <div class="header-left">
      Gestión de <br />
      Convivencia
    </div>
    <div class="header-right">
      <div class="ies">
        IES Mestre<br />
        Ramón Esteve
      </div>
      <img src="../assets/IES-Logo.jpg" alt="Logo del Instituto" />
    </div>
  </header>
  <main>
    <div class="container">
      <div class="form-container">
        <form @submit.prevent="handleSubmit()">
          <h2>Acceso</h2>
          <div class="input-box">
            <i class="bx bxs-user"></i>
            <input type="text" v-model="dni" placeholder="DNI" required title="Introduce tu DNI" />
          </div>
          <div class="input-box">
            <i class="bx bxs-lock-alt"></i>
            <input
              type="password"
              v-model="password"
              placeholder="Contraseña"
              required
              title="Introduce tu Contraseña"
            />
          </div>
          <div class="recordar-ayuda">
            <label><input type="checkbox" v-model="rememberMe" /> Recordar</label>
            <a href="#">Ayuda</a>
          </div>
          <button type="submit" class="btn">Entrar</button>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
/* eslint-disable */
import HeaderComponent from './HeaderComponent.vue';
import '../assets/styles/login.css';

export default {
  name: 'LoginComponent',
  data() {
    return {
      dni: '',
      password: '',
      rememberMe: false,
    };
  },
  methods: {
    async handleSubmit() {
      try {
        console.log('Iniciando petición de login...');
        const response = await fetch('http://127.0.0.1:8000/api/profesores/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          },
          body: JSON.stringify({
            dni: this.dni,
            password: this.password
          })
        });

        console.log('Respuesta recibida:', response.status);
        
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Datos recibidos:', data);

        if (data) {
          // Guardar el token
          if (data.token) {
            localStorage.setItem('token', data.token);
          }
          
          // Guardar los datos del usuario
          localStorage.setItem('usuario', JSON.stringify(data.profesor));
          
          // Guardar el rol del usuario
          if (data.profesor && data.profesor.rol) {
            localStorage.setItem('userRole', data.profesor.rol);
          }

          // Redirigir según el rol
          if (data.profesor && data.profesor.rol === 'admin') {
            this.$router.push('/admin');
          } else {
            this.$router.push('/cursos');
          }
        } else {
          throw new Error('No se recibieron datos del servidor');
        }
      } catch (error) {
        console.error('Error en la solicitud:', error);
        alert(error.message || 'Error al intentar iniciar sesión');
      }
    },
  },
  mounted() {
    const token = localStorage.getItem('token');
    if (token) {
      const userRole = localStorage.getItem('userRole');
      if (userRole === 'admin') {
        this.$router.push('/admin');
      } else {
        this.$router.push('/cursos');
      }
    }
  },
};
</script>
