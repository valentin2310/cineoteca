<template>
  <div id="app">
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
                <b-navbar-item tag="router-link" :to="{ path: '/peliculas/populares' }">
                    Popular
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Nuevas
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/peliculas/buscar' }">
                    Busqueda avanzada
                </b-navbar-item>
            </b-navbar-dropdown>

            <b-navbar-dropdown label="Series">
              <b-navbar-item tag="router-link" :to="{ path: '/series/populares' }">
                    Popular
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    Nuevas
                </b-navbar-item>
                <b-navbar-item tag="router-link" :to="{ path: '/series/buscar' }">
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

                  <b-autocomplete
                      class="navbar-item"
                      :data="data"
                      placeholder="Busca una pelicula o serie... "
                      icon-pack="fas"
                      icon="magnifying-glass"
                      clearable
                      :expanded="true"
                      :loading="isFetching"
                      :check-infinite-scroll="true"
                      @typing="getAsyncData"
                      @select="option => selected = option"
                      @infinite-scroll="getMoreAsyncData">

                      <template slot-scope="props">
                          <a :href="props.option.media_type == 'movie' ? `/pelicula/${props.option.id}` : `/serie/${props.option.id}`" class="router-link-reset">
                            <div class="media">
                                <div class="media-left">
                                    <img v-if="props.option.poster_path" width="32" :src="`https://image.tmdb.org/t/p/w500/${props.option.poster_path}`">
                                    <img v-else src="./assets/img/poster_fail.png" alt="x">
                                </div>
                                <div class="media-content">
                                  <b-icon v-if="props.option.media_type == 'tv'" pack="fas" icon="tv"></b-icon>
                                  <b-icon v-else pack="fas" icon="film"></b-icon>
                                    {{ props.option.media_type == 'movie'? props.option.title : props.option.name }}
                                    <br>
                                    <small>
                                        {{ props.option.release_date }}<b-icon pack="fas" icon="calendar"></b-icon> 
                                        <b>{{ props.option.vote_average }}</b><b-icon pack="fas" icon="star" type="is-primary"></b-icon>
                                    </small>
                                </div>
                            </div>
                          </a>
                      </template>
                      <template #footer>
                          <span v-show="page > totalPages" class="has-text-grey"> Eso es todo!! Ya no hay mas resultados </span>
                      </template>
                  </b-autocomplete>

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
                          
                          <span>{{ usuarioObj.usuario }}</span>
                          <b-avatar v-if="usuarioObj.img_avatar != null" class="mx-2 px-1" :src="'https://image.tmdb.org/t/p/w500'+usuarioObj.img_avatar"></b-avatar>
                          <b-avatar v-else class="mx-2 text-white text-center bg-dark"></b-avatar>
                          
                        </div>
                      </template>
                      
                      <b-dropdown-item><router-link class="router-link-reset" to="/perfil">Ver perfil</router-link></b-dropdown-item>
                      <b-dropdown-item><router-link class="router-link-reset" to="/perfil#listas">Mis listas</router-link></b-dropdown-item>
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
import { debounce } from 'vue-debounce'

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

  export default{
    data() {
      return {
        apiUrl: 'https://api.themoviedb.org/3',
        apiUrlv4: 'https://api.themoviedb.org/4',
        sessionId: null,
        access_token: null,

        id_usuario: null,

        usuarioObj: null,
        usuarioTMDB: null,

        data: [],
        selected: null,
        isFetching: false,
        name: '',
        page: 1,
        totalPages: 1
      }
    },
    methods: {
      getDatosUsuario() {
        const data = {
            id: this.id_usuario,
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          console.log(response.data);

          if(typeof response.data === "object" && response.data !== null) {
            console.log("Exito");
            this.usuarioObj = response.data;
          }

        })
        .catch(error => console.log(error));
      },
      getDatosUsuarioTMDB(){
        axios.get(`${this.apiUrl}/account`, {
          params: {
            api_key: API_KEY,
            session_id: this.sessionId
          }
        })
        .then(response => {
          
          this.usuarioTMDB = response.data;
          console.log(this.usuarioTMDB);

        })
        .catch(error => console.log(error));
      },
      cerrarSesion(){
        //Intar eliminar el sessionid
        try{
          this.eliminarSessionId();
        }catch(error){
          console.log(error);
        }
        this.eliminarAccessToken();

        //intentar eliminar el accessToken
        try{
          this.eliminarAccessToken();
        }catch(error){
          console.log(error);
        }

        //eliminar la cookie que verificada que esta iniciado sesion.
        this.$cookies.remove('id_usuario');
        this.id_usuario = null;

        //devolver a la pagina de inicio
        this.$router.push('/');
        location.reload();
      },
      eliminarSessionId() {
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
            
          })
          .catch(error => {
            console.log(error);
          });
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
      },
      getAsyncData: debounce(function (name) {
          // String update
          if (this.name !== name) {
              this.name = name
              this.data = []
              this.page = 1
              this.totalPages = 1
          }
          // String cleared
          if (!name.length) {
              this.data = []
              this.page = 1
              this.totalPages = 1
              return
          }
          // Reached last page
          if (this.page > this.totalPages) {
              return
          }
          this.isFetching = true
          axios.get(`${this.apiUrl}/search/multi`, {
            params: {
              api_key: API_KEY,
              language: this.language,
              page: this.page,
              include_adult: true,
              query: this.name
            }
          })
              .then(({ data }) => {
                  data.results.forEach((item) => {
                    if(item.media_type == 'movie' || item.media_type == 'tv')
                      this.data.push(item)
                  })

                  this.page++
                  this.totalPages = data.total_pages
              })
              .catch((error) => {
                  throw error
              })
              .finally(() => {
                  this.isFetching = false
              })
      }, 500),
      getMoreAsyncData: debounce(function () {
          this.getAsyncData(this.name)
      }, 250)
    },
    created () {
      const id_usuario = this.$cookies.get('id_usuario');
      const sessionId = this.$cookies.get('sessionId') // 
      const access_token = this.$cookies.get('access_token') // 

      if(id_usuario){
        console.log("Ya esta iniciada la sesion");
        console.log("Tu id_usuario es: "+id_usuario);

        this.id_usuario = id_usuario;
        this.getDatosUsuario();

        // comprobar si tengo acceso a la cuenta de TMDB
        if (sessionId && access_token) {
          console.log('Ya tengo acceso a TMDB')
          console.log('sessionId: '+sessionId);
          console.log('access_token: '+access_token);
  
          this.sessionId = sessionId;
          this.access_token = access_token;
  
          //mostrar info del usuario
          //this.getDatosUsuarioTMDB();

        }


      }
    }
  }

</script>

<style>

  .cabecera{
    box-shadow: black 0px 0px 5px;
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.95) 0%, rgba(255,255,255,1) 100%) !important;
    z-index: 20;
    position: sticky !important;
    top: 0;
  }

  .user-img .btn{
    box-shadow: none;
    color: black;
  }

  .navbar-end .autocomplete .input{
    width: 300px;
  }

  .router-link-reset {
      color: inherit;
      text-decoration: none;
      /* Otros estilos personalizados */
    }

</style>