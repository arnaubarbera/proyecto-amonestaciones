<template>
  <div class="home">
    <BienvenidaComponent />
  </div>
</template>

<script>
import BienvenidaComponent from '@/components/BienvenidaComponent.vue';

export default {
  name: 'HomeView',
  components: {
    BienvenidaComponent,
  },
};
</script>

<style scoped>
.home {
  width: 100%;
  min-height: 100vh;
}
</style>
