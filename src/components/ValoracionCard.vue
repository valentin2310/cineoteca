<template>
    <div class="itemCard custom-shadow rounded">
  
        <div class="valoracion h-100 bg-dark p-2 rounded d-flex flex-row flex-nowrap align-items-center justify-content-evently">
            <div v-if="valoracion.media_type == 'tv'" class="item">
                <SerieCard2 :serie="item"></SerieCard2>
            </div>
            <div v-else class="item">
                <PeliculaCard :pelicula="item"></PeliculaCard>
            </div>

            <div class="puntuacion p-3 text-white-50 has-text-centered">
                Tu puntuación:
                <br>
                <span class="fs-3 text-white fw-bold">
                    {{ valoracion.valor }} <b-icon pack="fas" icon="star" type="is-primary"></b-icon>
                </span>
            </div>
        </div>
       
    
    </div>
  </template>
  
  <script>
  
  import axios from 'axios';

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

  import PeliculaCard from '@/components/PeliculaCard.vue';
  import SerieCard2 from '@/components/SerieCard2.vue';  
  
  export default {
    name: 'ValoracionCard',
    props: {
      valoracion:{
        type: Object,
        required: true,
      }
    },
    components: {
        PeliculaCard,
        SerieCard2
    },
    data() {
        return {
            apiUrl: 'https://api.themoviedb.org/3',
            language: 'es-ES',
            item: {}
        }
    },
    mounted() {
        this.getSerieDetalles();
    },
    methods: {
        getSerieDetalles() {
            axios.get(`${this.apiUrl}/${this.valoracion.media_type}/${this.valoracion.id_item}`, {
                params: {
                    api_key: API_KEY,
                    language: this.language
                }
            })
                .then(response => {
                    this.item = response.data;
                    //console.log(this.peliculasMasValoradas);
                }

                )
                .catch(error => console.log(error))
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