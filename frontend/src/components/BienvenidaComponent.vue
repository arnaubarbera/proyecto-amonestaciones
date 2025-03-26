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

  <div class="welcome-wrapper">
    <div class="welcome">
      <div class="logo">
        <img src="../assets/XVo6.gif" alt="" />
      </div>
      <div class="content">
        <div class="texto">
          <h1>Bienvenid@s</h1>
        </div>

        <div class="buttondiv">
          <button class="animated-button" @click="redirect">
            <svg xmlns="http://www.w3.org/2000/svg" class="arr-2" viewBox="0 0 24 24">
              <path
                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
              ></path>
            </svg>
            <span class="text">Iniciar sesión</span>
            <span class="circle"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="arr-1" viewBox="0 0 24 24">
              <path
                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
              ></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'BienvenidaComponent',
  methods: {
    redirect() {
      this.$router.push('/login'); // Navega a la ruta /login
    },
  },
};
</script>
<style scoped>
/* ESTILOS PARA EL HEADER*/
header {
  min-height: 8.5vh;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  backdrop-filter: blur(20px);
  background-color: rgba(255, 255, 255, 1);
}

.header-left {
  font-size: 1.7em;
  font-weight: bold;
  line-height: 1;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 10px;
  text-align: right; /* Alinear el texto a la derecha */
  line-height: 1; /* Controlar el espaciado entre líneas */
  white-space: nowrap; /* Evita que las palabras se partan */
  font-weight: 700;
  color: rgb(0, 0, 0);
}

header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

/* ESTILOS PARA EL RESTO DE LA PÁGINA*/
.welcome-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  /* border: 1px red solid; */
}

.welcome {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  width: 65%;
  min-height: 400px;
  background-color: transparent;
  backdrop-filter: blur(20px);
  border: 2px rgba(255, 255, 255, 0.7) solid;
  box-shadow: 0 0 60px white;
  border-radius: 20px;
}

.logo {
  display: flex;
  justify-content: center;
  align-items: center;
}

.logo img {
  width: 50%;
  height: auto;
}

.content {
  color: white;
  display: flex; /* Activar Flexbox */
  flex-direction: column; /* Alinear los elementos en columna */
  justify-content: center; /* Centrar los elementos verticalmente */
  align-items: center; /* Centrar horizontalmente el contenedor de texto */
  height: 100%; /* Asegurarte de que ocupe todo el espacio del contenedor */
  text-align: left; /* Mantener el texto alineado a la izquierda */
  gap: 20px; /* Espacio entre los elementos dentro de .content */
}

.texto h1 {
  font-size: 2.5em;
  text-align: center;
  line-height: 1; /* Controlar el espaciado entre líneas */
}

.texto {
  width: 80%; /* Limitar el ancho para que no ocupe todo el contenedor */
  text-align: left; /* Alinear el texto a la izquierda */
}

.content .buttondiv {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Ocultar el logo en dispositivos con ancho de pantalla menor a 768px */
@media (max-width: 768px) {
  .logo {
    display: none;
  }

  /* Ajustar el tamaño del contenedor para que se vea mejor sin el logo */
  .welcome {
    grid-template-columns: 1fr; /* Cambiar a una sola columna */
    height: auto; /* Ajustar la altura automáticamente */
    width: 80%;
  }
}

/*ESTILOS PARA EL BOTON ANIMADO*/

/* From Uiverse.io by ryota1231 */
.animated-button {
  position: relative;
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 16px 36px;
  border: 4px solid;
  border-color: transparent;
  font-size: 16px;
  background-color: rgb(236, 236, 236);
  border-radius: 100px;
  font-weight: 600;
  color: #1f387e;
  box-shadow: 0 0 0 2px #ffffff;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.animated-button svg {
  position: absolute;
  width: 24px;
  fill: #1f387e;
  z-index: 9;
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.animated-button .arr-1 {
  right: 16px;
}

.animated-button .arr-2 {
  left: -25%;
}

.animated-button .circle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 20px;
  height: 20px;
  background-color: #c5e5e4;
  border-radius: 50%;
  opacity: 0;
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.animated-button .text {
  position: relative;
  z-index: 1;
  transform: translateX(-12px);
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.animated-button:hover {
  box-shadow: 0 0 0 12px transparent;
  color: #212121;
  border-radius: 12px;
}

.animated-button:hover .arr-1 {
  right: -25%;
}

.animated-button:hover .arr-2 {
  left: 16px;
}

.animated-button:hover .text {
  transform: translateX(12px);
}

.animated-button:hover svg {
  fill: #1f387e;
}

.animated-button:active {
  scale: 0.95;
  box-shadow: 0 0 0 4px greenyellow;
}

.animated-button:hover .circle {
  width: 220px;
  height: 220px;
  opacity: 1;
}
</style>
