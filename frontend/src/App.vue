<template>
  <div id="app">
    <!-- Muestra BienvenidaComponent solo en la ruta raíz -->
    <BienvenidaComponent v-if="$route.path === '/'" />

    <!-- Vista principal de la aplicación -->
    <router-view></router-view>

    <!-- Footer que aparece en todas las rutas -->
    <FooterComponent />
  </div>
</template>

<script>
//import HeaderComponent from './components/HeaderComponent.vue';
//import CursosComponent from './components/CursosComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import BienvenidaComponent from './components/BienvenidaComponent.vue';
//  import LoginComponent from './components/LoginComponent.vue';

export default {
  name: 'App',
  components: {
    //HeaderComponent,
    BienvenidaComponent,
    FooterComponent,
    //LoginComponent,
    //CursosComponent
  },
};
</script>

<style>
@import './assets/styles/global.css';
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
</style>
