<template>
  <div id="app">
    <!-- Menu -->
    <nav class="cabecera sticky-top navbar navbar-expand-lg bg-body-tertiary">
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
                <li><router-link to="/" class="dropdown-item" href="#">Busqueda avanzada</router-link></li>
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

          <!-- Login/Sing Up -->
          <ul v-if="usuarioObj == null" class="navbar-nav text-white">
            <li class="nav-item"><router-link to="/login" href="#" class="nav-link"><i class="fa-solid fa-right-to-bracket"></i> Acceder</router-link></li>
          </ul>
          <ul v-else class="navbar-nav">
            <li class="nav-item">
              <b-avatar variant="info" :src="'https://image.tmdb.org/t/p/w500'+usuarioObj.avatar.tmdb.avatar_path"></b-avatar>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="">
      <router-view />
    </div>
  </div>
</template>

<script>
import axios from 'axios';


  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

  export default{
    data() {
      return {
        apiUrl: 'https://api.themoviedb.org/3',
        sessionId: '',
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
      }
    },
    created () {
      const sessionId = this.$cookies.get('sessionId') // "ada564802fc409daf6add800ae7ec3d826c06c2c"
      if (sessionId) {
        console.log('Ya esta iniciada la sesion, sessionId: '+sessionId);
        this.sessionId = sessionId;
        //mostrar info del usuario
        this.getDatosUsuario();

      }
    }
  }

</script>

<style>

  .cabecera{
    box-shadow: black 0px 0px 5px;
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.95) 0%, rgba(255,255,255,1) 100%);
    font-weight: bold;
  }

  .logo-img img{
    width: 150px; 
  }

</style>