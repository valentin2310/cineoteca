<template>
    <div class="serieCard">
  
        <div class="card" v-bind:style="{
            'background-image': serie.backdrop_path ? 'linear-gradient(0deg, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.9) 100%), url(https://image.tmdb.org/t/p/w500/' + serie.backdrop_path + ')' : (serie.poster_path ? 'linear-gradient(0deg, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.9) 100%), url(https://image.tmdb.org/t/p/w500/' + serie.poster_path + ')' : 'linear-gradient(0deg, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.9) 100%)'),
            'background-color': '#17202A',
            'background-size': 'cover',
            'background-repeat': 'no-repeat',
            'background-position': 'center center'
        }">
            <router-link :to="`/serie/${serieId}`" class="router-link-reset">
                <div class="card-body">
                    <div class="card-title">
                        <b-row >
                            <b-col cols="11" class="title is-4 text-white mb-0 pb-0">
                                {{ serie.name }}
                            </b-col>
                            <b-col cols="1" class="mb-0 pb-0">
                                <b-icon v-b-popover.hover.right="serie.overview" :title="serie.name" pack="fas" icon="circle-info" size="is-medium" type="is-primary" class="float-end"></b-icon>
                            </b-col>
                        </b-row>
                    </div>
    
                    <div :class="'fechas fw-bold ms-2 '+(serie.in_production == true?'text-success':'text-danger')">
                        {{ serie.first_air_date }} - {{ serie.in_production == true? 'Presente':serie.last_air_date }}
                    </div>
    
                    <div class="datos text-white ms-3">
                        <b-row >
                            <b-col cols="5" class="ms-1">
                                {{ serie.number_of_seasons? serie.number_of_seasons : 'x' }} Temporadas
                            </b-col>
                            <b-col cols="5" class="ms-1">
                                {{ serie.number_of_episodes? serie.number_of_episodes : 'x' }} Epidodios
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col cols="5">
                                <b-icon pack="fas" icon="clock" type="is-primary"></b-icon> 
                                <span v-if="serie.episode_run_time">
                                    {{ serie.episode_run_time[0]? serie.episode_run_time[0] : 'x' }} min
                                </span>
                            </b-col>
                            <b-col cols="5">
                                <b-icon pack="fas" icon="star" type="is-primary"></b-icon> {{ serie.vote_average? serie.vote_average : 'x' }}
                            </b-col>
                        </b-row>
    
                        <div class="generos">
                            <b-taglist class="mt-2 ms-1">
                                <b-tag v-for="genero in serie.genres" :key="genero.id" type="is-primary is-light" rounded>
                                {{ genero.name }}
                                </b-tag>
                            </b-taglist>
                        </div>
                    </div>
    
                </div>
            </router-link>

        </div>
    
    </div>
  </template>
  
  <script>
  
  import axios from 'axios';
  import router from '@/router'

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  
  export default {
    name: 'SerieCard',
    props: {
      serieId: {
        type: Number,
        required: true
      }
    },
    data() {
        return {
            apiUrl: 'https://api.themoviedb.org/3',
            language: 'es-ES',
            serie: {}
        }
    },
    mounted() {
        this.getSerieDetalles();
    },
    methods: {
        getSerieDetalles() {
            axios.get(`${this.apiUrl}/tv/${this.serieId}`, {
                params: {
                    api_key: API_KEY,
                    language: this.language
                }
            })
                .then(response => {
                    this.serie = response.data;
                    //console.log(this.peliculasMasValoradas);
                }

                )
                .catch(error => console.log(error))
        },
        verDetalles() {
            const id = this.serie.id;
            router.push({ name: 'serie', params: { id } });
        }
    }
  };
  </script>
  
  <style scoped>

    .card{
        margin: 5px;
        width: 450px;
        height: 200px;
        border-radius: 15px 0px 15px 0px;
        border: 3px solid white;
        background-color: whitesmoke;
        box-shadow: black 0px 0px 5px;
    }
    .card-img img{
        border-radius: 15px 0px 0px 0px;
        padding: 3px;
    }
    .card-img, .card-img img, .card-body{
        height: 100%;
    }
    .card-body h4{
        margin-bottom: 5px;
    }
    .card:hover{
        box-shadow: blueviolet 0px 0px 8px;
        transition: 0.5s;
        cursor: pointer;
    }
    .card-title .title:hover{
      color: blueviolet;
      transition: 0.5ms;
    }

    .card-title .title{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 1; /* número máximo de líneas */
    }

    .text-success{
        color: rgb(9, 219, 6) !important;
    }

    .router-link-reset {
      color: inherit;
      text-decoration: none;
      /* Otros estilos personalizados */
    }

  </style>