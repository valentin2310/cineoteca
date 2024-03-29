import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PeliculaView from '../views/PeliculaView.vue';
import LoginView from '../views/LoginView.vue';
import Page404 from '../views/Page404View.vue';
import BuscarPelisView from '../views/BuscarPelisView.vue';
import PelisPopularesView from '../views/PeliculasPopulares.vue';
import SerieView from '../views/SerieView.vue';
import SeriesPopularesView from '../views/SeriesPopulares.vue';
import BuscarSeriesView from '../views/BuscarSeriesView.vue';
import PerfilView from '../views/PerfilView.vue';
import ListaView from '../views/ListaView.vue';
import PelisMasValoradasView from '../views/PeliculasMasValoradas.vue';
import SeriesMasValoradasView from '../views/SeriesMasValoradas.vue';
import PerfilConfiguracionView from '../views/PerfilConfiguracion.vue';
import Page403 from '../views/Page403View.vue';
import AboutView from '../views/AboutView.vue';
import ContactoView from "../views/ContactoView.vue";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'sobre nosotros',
    component: AboutView
  },
  {
    path: '/contacto',
    name: 'contacto',
    component: ContactoView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/perfil',
    name: 'perfil',
    component: PerfilView
  },
  {
    path: '/perfil/configuracion',
    name: 'perfil configuracion',
    component: PerfilConfiguracionView
  },
  {
    path: '/pelicula/:id',
    name: 'pelicula',
    component: PeliculaView
  },
  {
    path: '/serie/:id',
    name: 'serie',
    component: SerieView
  },
  {
    path: '/peliculas/populares',
    name: 'peliculas populares',
    component: PelisPopularesView
  },
  {
    path: '/peliculas/masvaloradas',
    name: 'peliculas mas valoradas',
    component: PelisMasValoradasView
  },
  {
    path: '/series/populares',
    name: 'series populares',
    component: SeriesPopularesView
  },
  {
    path: '/series/masvaloradas',
    name: 'series mas valradas',
    component: SeriesMasValoradasView
  },
  {
    path: '/peliculas/buscar',
    name: 'buscar peliculas',
    component: BuscarPelisView
  },
  {
    path: '/series/buscar',
    name: 'buscar series',
    component: BuscarSeriesView
  },
  {
    path: '/listas/:id',
    name: 'lista',
    component: ListaView
  },
  {
    path: '/403',
    name: 'sin acceso',
    component: Page403
  },
  {
    path: '/:catchAll(.*)',
    name: '404 Not found',
    component: Page404
  }
]

const router = new VueRouter({
  mode: 'hash',
  //base: process.env.BASE_URL,
  routes
})

export default router
