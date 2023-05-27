<template>
    <div class="seccion">
  
  
      <div class="seccion-titulo">
        <h2 class="title mx-5">{{ titulo }} <b-button v-if="ruta" type="is-primary is-light" class="m-2" tag="router-link" :to="ruta">Ver mas ...</b-button></h2>
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
    padding: 5px 20px 20px 20px;
  }
  </style>