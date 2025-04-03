import { createRouter, createWebHistory } from 'vue-router';
//import Cookies from 'js-cookie';
import LoginComponent from '../components/LoginComponent.vue';
import CursosComponent from '../components/CursosComponent.vue';
import AlumnosComponent from '../components/AlumnosComponent.vue';
import AlumnosCursoComponent from '../components/AlumnosCursoComponent.vue';
import CursoComponent from '@/components/CursoComponent.vue';
import AlumnoPerfilComponent from '../components/AlumnoPerfilComponent.vue';
import CrearAmonestacionComponent from '../components/CrearAmonestacionComponent.vue';
import AmonestacionRapidaComponent from '../components/AmonestacionRapidaComponent.vue';

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginComponent,
  },
  {
    path: '/cursos',
    name: 'Cursos',
    component: CursosComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/alumnos',
    name: 'Alumnos',
    component: AlumnosComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/curso/:id/alumnos',
    name: 'AlumnosCurso',
    component: AlumnosCursoComponent,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: '/curso/:curso',
    component: CursoComponent,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: '/alumno/:id',
    name: 'alumno-perfil',
    component: AlumnoPerfilComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/alumno/:id/crear-amonestacion',
    name: 'crear-amonestacion',
    component: CrearAmonestacionComponent,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: '/amonestacion-rapida',
    name: 'amonestacion-rapida',
    component: AmonestacionRapidaComponent,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const usuario = JSON.parse(localStorage.getItem('usuario')); // Verificar si el usuario está autenticado

  if (to.meta.requiresAuth && !usuario) {
    // Si la ruta requiere autenticación y no hay usuario autenticado
    next({ path: '/login' });
  } else if (usuario && to.path === '/login') {
    // Si el usuario está autenticado, no debería acceder al login
    next({ path: '/cursos' });
  } else {
    // En cualquier otro caso, continuar con la navegación
    next();
  }
});

export default router;
