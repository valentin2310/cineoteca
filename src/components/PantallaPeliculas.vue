<template>
    <div class="pantallaPeliculas box">

        <h1 class="title">{{ titulo }}</h1>
        <h2 v-if="total_resultados" class="subtitle">Numero de resultados: {{ total_resultados }}</h2>

        <div class="peliculas">
          <PeliculaCard v-for="pelicula in peliculas" :key="pelicula.id" :pelicula="pelicula"></PeliculaCard>
        </div>

    </div>
</template>

<script>
import PeliculaCard from '@/components/PeliculaCard.vue';

export default {
  name: 'PantallaPeliculas',
  components: {
    PeliculaCard,
  },
  props: {
    peliculas: {
      type: Array,
      required: true,
    },
    titulo: {
      type: String,
      required: true
    },
    total_paginas: {
        type: Number,
        required: true
    },
    total_resultados: {
        type: Number,
        required: false
    }
  },
};

</script>

<style scoped>

    .title{
        color: blueviolet;
    }
    .peliculas{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        margin: 10px 0px;

    }
    .peliculaCard{
        margin: 5px 0px;
    }

    @media screen and (max-width: 480px) {
      .box{
        padding: 0;
      }
      h1{
        padding: 10px;
      }
    }


</style>