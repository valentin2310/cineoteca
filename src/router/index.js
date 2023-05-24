import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PeliculaView from '../views/PeliculaView.vue';
import LoginView from '../views/LoginView.vue';
import Page404 from '../views/Page404View.vue';
import BuscarPelisView from '../views/BuscarView.vue';
import PelisPopularesView from '../views/PeliculasPopulares.vue';

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/pelicula/:id',
    name: 'pelicula',
    component: PeliculaView
  },
  {
    path: '/peliculas/populares',
    name: 'peliculas populares',
    component: PelisPopularesView
  },
  {
    path: '/peliculas/buscar',
    name: 'buscar peliculas',
    component: BuscarPelisView
  },
  {
    path: '/:catchAll(.*)',
    name: '404 Not found',
    component: Page404
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
