<template>
  <footer>
    <span
      ><a class="centro" href="https://portal.edu.gva.es/iesmestreramonesteve/es/centro/"
        >&copy; 2025 IESMRE</a
      ></span
    >
    <span> <a href="#">Aviso legal</a> | <a href="#">Contacto</a> </span>
  </footer>
</template>

<script>
export default {
  name: 'FooterComponent',
};
</script>

<style scoped>
* {
  color: white;
}
footer {
  margin-top: auto;
  text-align: center;
  padding: 10px 20px;
  font-size: 14px;
  display: flex;
  justify-content: space-between;
}

span {
  backdrop-filter: blur(20px);
  background: rgba(0, 0, 0, 0.5);
  border: 1px rgba(255, 255, 255, 0.5) solid;
  padding: 5px;
  padding-right: 10px;
  padding-left: 10px;
  border-radius: 20px;
}

footer a {
  text-decoration: none;
}

footer a:hover {
  text-decoration: underline;
}
</style>
