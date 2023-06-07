<template>
    <div class="pantallaItems">

        <div v-if="listaItems.length > 0" class="lista">
            <div v-for="(item, i) in listaItems" :key="item.id+(item.title?item.title:item.name)+i" class="item">
                <PeliculaCard v-if="item.title" :pelicula="item"></PeliculaCard>
                <SerieCard2 v-if="item.name" :serie="item" ></SerieCard2>
            </div>
        </div>
        <div v-else class="">No hay ningun item en la lista :(</div>

    </div>
</template>

<script>

import PeliculaCard from '@/components/PeliculaCard.vue';
import SerieCard2 from '@/components/SerieCard2.vue';

export default {
  name: 'PantallaItems',
  components: {
    PeliculaCard,
    SerieCard2
  },
  props: {
    listaItems: {
      type: Array,
      required: true,
    }
  },
};

</script>

<style scoped>
    .lista{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        margin: 10px 0px;

    }
    .item{
        margin: 5px 0px;
    }

    .peliculaCard, .serieCard, .serieCard2{
    height: 100%;
  }


</style>