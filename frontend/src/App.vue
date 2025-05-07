<template>
  <div id="app">
    <HeaderComponent v-if="$route.path !== '/'" />
    <router-view></router-view>
    <FooterComponent />
  </div>
</template>

<script>
import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';

export default {
  name: 'App',
  components: {
    HeaderComponent,
    FooterComponent,
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
