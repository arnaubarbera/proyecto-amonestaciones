import { createRouter, createWebHistory } from 'vue-router';
import LoginComponent from '../components/LoginComponent.vue';
import HomeView from '../views/Home.vue';
import AdminPanel from '../components/AdminPanel.vue';
import InformesComponent from '../components/Informes.vue';
import CursosComponent from '../components/CursosComponent.vue';
import AlumnosComponent from '../components/AlumnosComponent.vue';
import AlumnosCursoComponent from '../components/AlumnosCursoComponent.vue';
import CursoComponent from '@/components/CursoComponent.vue';
import AlumnoPerfilComponent from '../components/AlumnoPerfilComponent.vue';
import CrearAmonestacionComponent from '../components/CrearAmonestacionComponent.vue';
import AmonestacionRapidaComponent from '../components/AmonestacionRapidaComponent.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/login',
    name: 'login',
    component: LoginComponent,
  },
  {
    path: '/admin',
    name: 'admin',
    component: AdminPanel,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/informes',
    name: 'informes',
    component: InformesComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/cursos',
    name: 'cursos',
    component: CursosComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/alumnos',
    name: 'alumnos',
    component: AlumnosComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/curso/:id/alumnos',
    name: 'alumnos-curso',
    component: AlumnosCursoComponent,
    meta: { requiresAuth: true },
  },
  {
    path: '/curso/:id',
    name: 'curso',
    component: CursoComponent,
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
  const isAuthenticated = localStorage.getItem('token');
  const isAdmin = localStorage.getItem('userRole') === 'admin';

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.meta.requiresAdmin && !isAdmin) {
    next('/');
  } else {
    next();
  }
});

export default router;
