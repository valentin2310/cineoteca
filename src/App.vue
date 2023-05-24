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
                          <div class="media">
                              <div class="media-left">
                                  <img v-if="props.option.poster_path" width="32" :src="`https://image.tmdb.org/t/p/w500/${props.option.poster_path}`">
                                  <img v-else src="./assets/img/poster_fail.png" alt="no tiene poster">
                              </div>
                              <div class="media-content">
                                  {{ props.option.media_type == 'movie'? props.option.title : props.option.name }}
                                  <br>
                                  <small>
                                      {{ props.option.release_date }}<b-icon pack="fas" icon="calendar"></b-icon> 
                                      <b>{{ props.option.vote_average }}</b><b-icon pack="fas" icon="star" type="is-primary"></b-icon>
                                  </small>
                              </div>
                          </div>
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
import { debounce } from 'vue-debounce'

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

  export default{
    data() {
      return {
        apiUrl: 'https://api.themoviedb.org/3',
        sessionId: null,
        access_token: null,
        usuarioObj: null,


        data: [],
                selected: null,
                isFetching: false,
                name: '',
                page: 1,
                totalPages: 1
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
                          console.log(item)
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