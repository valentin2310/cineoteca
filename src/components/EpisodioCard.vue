<template>
    <div class="episodioCard">
  
        <div v-if="episodio" class="lista rounded m-1 p-3 bg-dark text-white custom-shadow rounded">
          
            <div class="portada d-flex flex-row flex-nowrap">
                <img v-if="temporada.poster_path" :src="`https://image.tmdb.org/t/p/w500/${temporada.poster_path}`" class="rounded">
                <img v-else src="../assets/img/poster_fail.png" alt="x" class="rounded">

                <div class="ms-3">
                    <div class="titulo d-flex flex-row flex-wrap align-items-center">
                        <span class="d-flex flex-row flex-nowrap">
                            <span class="fw-bold fs-5 nombre-serie">
                                {{ serie.name }}
                            </span>
                        </span>
                    </div>
        
                    <div class="text-white-50">
                        <div class="text-white-50 fs-6 mb-0 nombre-episodio">
                            <span>{{ episodio.num_temporada }}x{{ episodio.num_episodio }}</span> - <span class="text-white">{{ episodio.titulo }}</span>
                        </div>
                        <div class="">
                            <span class="">{{ obtenerFecha(episodio.fecha_alta) }}</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>



    </div>
  </template>
  
  <script>
  
  import axios from 'axios';

  const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  
  export default {
    name: 'EpisodioCard',
    props: {
      episodio: {
        type: Object,
        required: true
      },
    },
    data() {
        return {
            apiUrl: 'https://api.themoviedb.org/3',
            language: 'es-ES',

            serie: {},
            temporada: {},
        }
    },
    mounted() {
        this.getSerieDetalles();
        this.getTemporadaDetalles();
    },
    methods: {
        getSerieDetalles() {
            axios.get(`${this.apiUrl}/tv/${this.episodio.id_tmdb}`, {
                params: {
                    api_key: API_KEY,
                    language: this.language
                }
            })
                .then(response => {
                    this.serie = response.data;
                }

                )
                .catch(error => console.log(error))
        },
        getTemporadaDetalles() {
            axios.get(`${this.apiUrl}/tv/${this.episodio.id_tmdb}/season/${this.episodio.num_temporada}`, {
                params: {
                    api_key: API_KEY,
                }
            })
                .then(response => {
                    this.temporada = response.data;
                }

                )
                .catch(error => console.log(error))
        },
        obtenerFecha(fecha){
            const fechaObj = new Date(fecha);
            const dia = fechaObj.getDate().toString().padStart(2, '0');
            const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
            const año = fechaObj.getFullYear();
            const horas = fechaObj.getHours().toString().padStart(2, '0');
            const minutos = fechaObj.getMinutes().toString().padStart(2, '0');

            return `${dia}/${mes}/${año} ${horas}:${minutos}h`;
        },
    }
  };
  </script>
  
  <style scoped>
    .episodioCard{
        width: 290px;
    }

    .lista .portada{
        height: 100px !important;
    }
    .portada img{
        height: 100%;
    }

    .nombre-serie{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 1; /* número máximo de líneas */
    }

    .nombre-episodio{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2; /* número máximo de líneas */
    }

  </style>