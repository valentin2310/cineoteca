<template>
    <div class="seccion" v-bind:style="{
                'background-image': series[0]?`linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,8) 100%), url(https://image.tmdb.org/t/p/original/${series[0].backdrop_path})`:'',
                'background-color': '#17202A',
                'background-size': 'cover',
                'background-repeat': 'no-repeat',
                'background-position': 'center center'
            }">
  
  
      <div class="seccion-titulo">
        <h2 class="title mx-5 text-white d-flex flex-row flex-wrap align-items-baseline">{{ titulo }} <b-button v-if="ruta" type="is-primary is-light" class="m-2" rounded tag="router-link" :to="ruta">Ver más ...</b-button></h2>
      </div>
  
  
      <div class="seccion-cuerpo">
  
        <div v-if="series.length > 0">
  
          <div class="series">
            <SerieCard2 v-for="serie in series" :key="serie.id" :serie="serie"></SerieCard2>
          </div>
  
        </div>
  
  
        <div v-else>
          <p>No hay series para mostrar</p>
        </div>
  
      </div>
  
    </div>
  </template>
  
  <script>
  import SerieCard2 from '@/components/SerieCard2.vue';
  
  export default {
    name: 'ListaSeries',
    components: {
      SerieCard2,
    },
    props: {
      series: {
        type: Array,
        required: true,
      },
      titulo: {
        type: String,
        required: true
      },
      ruta: {
        type: String,
        required: false
      }
    },
  };
  
  </script>
  
  <style scoped>
  .seccion {
    padding: 10px 30px;
  }
  
  .seccion-titulo {
    margin-top: 20px;
  }
  .seccion-cuerpo{
    margin: 5px 20px;
  }
  .seccion-cuerpo, .series{
    overflow-x: auto;
    display: flex;
    flex-flow: row nowrap;
    padding: 5px 0px 20px 0px;
  }

  @media screen and (max-width: 400px) {
    .seccion{
      padding: 10px 2px;
    }
    .seccion-cuerpo{
      margin: 5px 2px;
    }
    .seccion-cuerpo, .series{
    padding: 5px 2px 20px 2px;
    }
  }

  </style>