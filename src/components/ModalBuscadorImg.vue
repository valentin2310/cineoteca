<template>
    <div class="btn-crear-lista">

        <div class="modalBuscadorImg" @click="isOpen = true">
        
            <!-- Insertar comtenido desde la view padre -->
            <slot></slot>
        
        </div>

        <b-modal
            v-model="isOpen"
            has-modal-card
            full-screen
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="Elegir Imagen"
            close-button-aria-label="Close"
            aria-modal
        >
            <div class="modal-card text-dark">
                <header class="modal-card-head">
                    <p class="modal-card-title">Selecciona una imagen</p>
                </header>
                <section class="modal-card-body">
                   <div class="buscador rounded mb-2 p-3 mx-3 bg-dark text-white">
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
                      @select="option => getImgItem(option)"
                      @infinite-scroll="getMoreAsyncData">

                        <template slot-scope="props">
                            <div class="media">
                                <div class="media-left">
                                    <img v-if="props.option.poster_path" width="32" :src="`${apiImg}${props.option.poster_path}`">
                                    <img v-else src="../assets/img/poster_fail.png" alt="x">
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
                        </template>
                        <template #footer>
                            <span v-show="page > totalPages" class="has-text-grey"> Eso es todo!! Ya no hay mas resultados </span>
                        </template>
                    </b-autocomplete>

                   </div>

                   <b-row class="p-3">
                    <b-col sm="3" class="mb-2">

                        <div class="filtro rounded custom-shadow">
                            <b-field class="bg-dark text-white p-3 mb-0 fw-bold rounded-top"><i class="fa-solid fa-filter me-2 "></i> Mostrar</b-field>
                            <div class="opciones py-3 px-3 bg-gris rounded-bottom">

                                <b-field>
                                    <b-radio 
                                        v-model="mostrar"
                                        native-value="0"
                                        type="is-dark"
                                    >
                                        Fondos ({{ resultadosBackground.length }})
                                    </b-radio>
                                </b-field>
                                <b-field>
                                    <b-radio 
                                        v-model="mostrar"
                                        native-value="1"
                                        type="is-info"
                                    >
                                        Posters ({{ resultadosPoster.length }})
                                    </b-radio>
                                </b-field>
                                <b-field>
                                    <b-radio 
                                        v-model="mostrar"
                                        native-value="2"
                                        type="is-success"
                                    >
                                        Logos ({{ resultadosLogos.length }})
                                    </b-radio>
                                </b-field>
                                <b-field v-show="usuarioTMDB">
                                    <b-radio 
                                        v-model="mostrar"
                                        native-value="3"
                                        type="is-success"
                                    >
                                        Avatar TMDB
                                    </b-radio>
                                </b-field>

                            </div>
                        </div>

                    </b-col>
                    <b-col sm="9">

                        <div class="resultados custom-shadow bg-gris rounded p-3">
                            
                             <div class="media rounded mb-2 p-3 bg-dark text-white d-flex align-items-center" v-if="selectedItem">
                                 <div class="media-left">
                                     <img v-if="selectedItem.poster_path" width="32" :src="`${apiImg}${selectedItem.poster_path}`">
                                     <img v-else src="../assets/img/poster_fail.png" alt="x">
                                 </div>
                                 <div class="media-content ">
                                     <span class="fs-5">
                                         <b-icon v-if="selectedItem.media_type == 'tv'" pack="fas" icon="tv"></b-icon>
                                         <b-icon v-else pack="fas" icon="film"></b-icon>
                                         {{ selectedItem.media_type == 'movie'? selectedItem.title : selectedItem.name }}
                                     </span>
                                 </div>
                             </div>
                             <span class="fs-4 fw-bold mb-3">
                                Resultados de imagenes:
                            </span>
                             <div v-if="mostrar == 0" class="resultados-img">
                                 <div v-for="(img, i) in resultadosBackground" :key="i" class="img" :class="selected == img.file_path?'rounded border border-4 border-info':'rounded border border-4 border-opacity-10'" @click="selected = img.file_path">
                                     <img :src="`${apiImgBackdrop}${img.file_path}`" width="275" class="rounded">
                                 </div>
                             </div>
                             <div v-if="mostrar == 1" class="resultados-img">
                                 <div v-for="(img, i) in resultadosPoster" :key="i" class="img" :class="selected == img.file_path?'rounded border border-4 border-info':'rounded border border-4 border-opacity-10'" @click="selected = img.file_path">
                                     <img :src="`${apiImgPoster}${img.file_path}`" width="185" class="rounded">
                                 </div>
                             </div>
                             <div v-if="mostrar == 2" class="resultados-img">
                                 <div v-for="(img, i) in resultadosLogos" :key="i" class="img" :class="selected == img.file_path?'rounded border border-4 border-info':'rounded border border-4 border-opacity-10'" @click="selected = img.file_path">
                                     <img :src="`${apiImgLogo}${img.file_path}`" width="92" class="rounded">
                                 </div>
                             </div>
                             <div v-if="usuarioTMDB && mostrar == 3" class="resultados-img">
                                 <div class="img" :class="selected == usuarioTMDB.avatar.tmdb.avatar_path?'rounded border border-4 border-info':'rounded border border-4 border-opacity-10'" @click="selected = usuarioTMDB.avatar.tmdb.avatar_path">
                                     <img :src="`${apiImg}${usuarioTMDB.avatar.tmdb.avatar_path}`" width="250" class="rounded">
                                 </div>
                             </div>
                        </div>

                    </b-col>
                   </b-row>
                </section>
                <footer class="modal-card-foot">
                    <b-button type="is-primary" @click="enviarImg()">Aceptar</b-button>
                    <b-button class="bg-secondary text-white" @click="isOpen = false">Cancelar</b-button>
                </footer>
            </div>

        </b-modal>

    </div>
</template>

<script>
  
  import axios from 'axios';
  import { debounce } from 'vue-debounce'

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  //const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";
  
  export default {
    name: 'ModalBuscadorImg',
    props: {
        usuarioTMDB: {
            type: Object,
            required: false
        }
    },
    data() {
        return {
            
            isOpen: false,
            selected: null,

            apiUrl: 'https://api.themoviedb.org/3',
            apiImg: 'https://image.tmdb.org/t/p/w500/',
            apiImgBackdrop: 'https://image.tmdb.org/t/p/w780/',
            apiImgLogo: 'https://image.tmdb.org/t/p/w154/',
            apiImgPoster: 'https://image.tmdb.org/t/p/w500/',

            data: [],
            selectedItem: null,
            isFetching: false,
            name: '',
            page: 1,
            totalPages: 1,

            resultadosPoster: [],
            resultadosBackground: [],
            resultadosLogos: [],

            mostrar: "0",
        }
    },
    methods: {
        enviarImg(){
            //devolver la imagen seleccionada
            if(this.selected){
                this.$emit('img', this.selected);
                this.isOpen = false;
            }else{
                this.$buefy.notification.open({
                    message: 'No has seleccionado ninguna imagen',
                    type: 'is-warning',
                    'icon-pack': 'fas',
                    position: 'is-top-right'
                })
            }
        },
        getImgItem(option){
            this.selectedItem = option;

            axios.get(`${this.apiUrl}/${option.media_type}/${option.id}/images`, {
                params: {
                api_key: API_KEY,
                },
            })
                .then(response => {
                    const imagenes = response.data;

                    this.resultadosBackground = imagenes.backdrops;
                    this.resultadosPoster = imagenes.posters;
                    this.resultadosLogos = imagenes.logos;
                })
                .catch(error => {
                    console.error(error);
                });
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
              language: 'es-ES',
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
    }
  };
  </script>

  <style scoped>

.resultados-img{
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    align-items: center;
}
  .resultados-img .img{
    margin: 5px;
  }

  .custom-shadow{
    box-shadow: black 0px 0px 5px;
}

</style>