<template>
    <div class="pantallaSeries box">

        <h1 class="title">{{ titulo }}</h1>
        <h2 v-if="total_resultados" class="subtitle">Numero de resultados: {{ total_resultados }}</h2>
        
        <b-switch
        class="mx-4"
            v-model="card2"
            :rounded="true"
            :outlined="true"
            type="is-primary"
            passive-type='is-dark'
            :left-label="true"
        >
            Cambiar diseño
          </b-switch>

        <div v-if="card2" class="series">
          <SerieCard2  v-for="serie in series" :key="serie.id" :serie="serie"/>
        </div>
        <div v-else class="series">
          <SerieCard v-for="serie in series" :key="serie.id" :serieId="serie.id"/>
        </div>

    </div>
</template>

<script>
import SerieCard from '@/components/SerieCard.vue';
import SerieCard2 from '@/components/SerieCard2.vue';

export default {
  name: 'PantallaSeries',
  components: {
    SerieCard,
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
    total_paginas: {
        type: Number,
        required: true
    },
    total_resultados: {
        type: Number,
        required: false
    }
  },
  data() {
    return {
      card2: true,
    }
  },
  methods: {
    cambiarDiseño() {
      this.card2 = !this.card2;
    }
  }
};

</script>

<style scoped>

    .title{
        color: blueviolet;
    }
    .series{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        margin: 10px 0px;

    }
    .serieCard, .serieCard2{
        margin: 5px 0px;
    }


</style>