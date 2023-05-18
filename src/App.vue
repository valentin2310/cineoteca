<template>
  <div id="app">
    <!-- Menu -->
    <!-- 

      <nav class="cabecera navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <router-link to="/" class="navbar-brand logo-img" href="#"><img src="./assets/img/logo_simple.png" alt="logo"></router-link>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Peliculas
              </a>
              <ul class="dropdown-menu">
                <li><router-link to="/" class="dropdown-item" href="#">Popular</router-link></li>
                <li><router-link to="/" class="dropdown-item" href="#">Nuevas</router-link></li>
                <li><router-link to="/buscar" class="dropdown-item" href="#">Busqueda avanzada</router-link></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Series
              </a>
              <ul class="dropdown-menu">
                <li><router-link to="/" class="dropdown-item" href="#">Popular</router-link></li>
                <li><router-link to="/" class="dropdown-item" href="#">Nuevas</router-link></li>
                <li><router-link to="/" class="dropdown-item" href="#">Busqueda avanzada</router-link></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Listas
              </a>
              <ul class="dropdown-menu">
                <li><router-link to="/" class="dropdown-item" href="#">Ver mis listas</router-link></li>
                <li><router-link to="/" class="dropdown-item" href="#">Another action</router-link></li>
                <li><router-link to="/" class="dropdown-item" href="#">Something else here</router-link></li>
              </ul>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link" href="#">Sobre Nosotros</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link" href="#">Contacto</router-link>
            </li>
          </ul>
        -->
          
          <!-- Login/Sing Up -->

          <!--

            <ul v-if="usuarioObj == null" class="navbar-nav text-white">
              <li class="nav-item"><router-link to="/login" href="#" class="nav-link"><i class="fa-solid fa-right-to-bracket"></i> Acceder</router-link></li>
            </ul>
            <ul v-else class="navbar-nav user-img">
              
              <b-dropdown variant="link" toggle-class="text-decoration-none" right>
                <template #button-content>
                  <b-avatar v-if="usuarioObj.avatar.tmdb.avatar_path != null" class="mx-2" :src="'https://image.tmdb.org/t/p/w500'+usuarioObj.avatar.tmdb.avatar_path"></b-avatar>
                  <b-avatar v-else class="mx-2 text-white text-center bg-primary" v-text="'AC'"></b-avatar>
                </template>
                <b-dropdown-item><router-link to="/"  class="dropdown-item">Ver perfil</router-link></b-dropdown-item>
                <b-dropdown-item><router-link to="/"  class="dropdown-item">Mis listas</router-link></b-dropdown-item>
                <b-dropdown-item><router-link to="/"  class="dropdown-item">Crear lista</router-link></b-dropdown-item>
                <b-dropdown-item class="dropdawn-item" @click="cerrarSesion()">Cerrar sesion</b-dropdown-item>
              </b-dropdown>
              
            </ul>
          </div>
        </div>
      </nav>
    -->
      
      <!-- Nuevo navbar buetify-->
    <b-navbar class="cabecera">
        <template #brand>
            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                <img
                    src="./assets/img/logo_simple.png"
                    alt="Logo MiCineoteca"
                >
            </b-navbar-item>
        </template>
        <template #start>

          <b-navbar-dropdown label="Peliculas">
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Popular
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Nuevas
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/buscar' }">
                    Busqueda avanzada
                </b-navbar-item>
            </b-navbar-dropdown>

            <b-navbar-dropdown label="Series">
              <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Popular
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Nuevas
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Busqueda avanzada
                </b-navbar-item>
            </b-navbar-dropdown>

            <b-navbar-dropdown label="Listas">
              <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Popular
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Nuevas
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Busqueda avanzada
                </b-navbar-item>
            </b-navbar-dropdown>

            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                Sobre nosotros
            </b-navbar-item>

            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                Contacto
            </b-navbar-item>
        </template>

        <template #end>

          <div class="navbar-end">

                  <div class="navbar-item" v-if="usuarioObj == null">
                    <router-link to="/login" href="#" class="nav-link"><i class="fa-solid fa-right-to-bracket"></i> Acceder</router-link>
                  </div>

                  <b-dropdown v-else
                    position="is-bottom-left"
                    append-to-body
                    aria-role="menu"
                    scrollable
                    max-height="200"
                    trap-focus
                  >

                      <template #trigger>
                      <div
                          class="navbar-item user-img"
                          role="button">
                          
                          <span>{{ usuarioObj.username }}</span>
                          <b-avatar v-if="usuarioObj.avatar.tmdb.avatar_path != null" class="mx-2 px-1" :src="'https://image.tmdb.org/t/p/w500'+usuarioObj.avatar.tmdb.avatar_path"></b-avatar>
                          <b-avatar v-else class="mx-2 text-white text-center bg-primary" v-text="'AC'"></b-avatar>
                          
                        </div>
                      </template>
                      
                      <b-dropdown-item tag="router-link" :to="{ path: '/' }">Ver perfil</b-dropdown-item>
                      <b-dropdown-item tag="router-link" :to="{ path: '/' }">Mis listas</b-dropdown-item>
                      <b-dropdown-item tag="router-link" :to="{ path: '/' }">Crear lista</b-dropdown-item>
                      <b-dropdown-item class="dropdawn-item" @click="cerrarSesion()">Cerrar sesion</b-dropdown-item>

                  </b-dropdown>
          </div>

        </template>
    </b-navbar>

    <div class="">
      <router-view />
    </div>
  </div>
</template>

<script>
import axios from 'axios';

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

  export default{
    data() {
      return {
        apiUrl: 'https://api.themoviedb.org/3',
        sessionId: null,
        access_token: null,
        usuarioObj: null
      }
    },
    methods: {
      getDatosUsuario(){
        axios.get(`${this.apiUrl}/account`, {
          params: {
            api_key: API_KEY,
            session_id: this.sessionId
          }
        })
        .then(response => {
          
          this.usuarioObj = response.data;
          console.log(this.usuarioObj);

        })
        .catch(error => console.log(error));
      },
      cerrarSesion() {
        axios.delete(`${this.apiUrl}/authentication/session`, {
            params: {
              api_key: API_KEY
            },
            data: {
              session_id: this.sessionId
            }
          })
          .then(response => {

            console.log(response.data);
            //eliminar session_id
            this.$cookies.remove('sessionId');
            this.sessionId = null;

            //eliminar access_token
            this.eliminarAccessToken();
            
            //devolver a la pagina de inicio
            location.reload();
            
          })
          .catch(error => console.log(error));
      },
      eliminarAccessToken() {
        axios.delete(`https://api.themoviedb.org/4/auth/access_token`, {
          headers: {
            accept: 'application/json',
            'content-type': 'application/json',
            Authorization: `Bearer ${TOKEN_LECTURA_V4}`
          },
          data: {
            access_token: this.access_token
          }
        })
        .then(response => {

          console.log(response.data);

          //eliminar access_token
          this.$cookies.remove('access_token');
          this.access_token = null;

        })
        .catch(error => console.log(error));
      }
    },
    created () {
      const sessionId = this.$cookies.get('sessionId') // 
      const access_token = this.$cookies.get('access_token') // 

      if (sessionId) {
        console.log('Ya esta iniciada la sesion, sessionId: '+sessionId);
        this.sessionId = sessionId;
        //mostrar info del usuario
        this.getDatosUsuario();

      }
    
      if (access_token) {
        this.access_token = access_token;
        console.log('Ya esta iniciada la sesion, access_token: '+this.access_token);
      }
    }
  }

</script>

<style>

  .cabecera{
    box-shadow: black 0px 0px 5px;
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.95) 0%, rgba(255,255,255,1) 100%) !important;
    z-index: 2000;
    position: sticky !important;
    top: 0;
  }

  .user-img .btn{
    box-shadow: none;
    color: black;
  }

</style>