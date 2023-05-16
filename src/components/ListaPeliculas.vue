<template>
  <div class="seccion">


    <div class="seccion-titulo">
      <h2 class="mx-5 mb-0">{{ titulo }} <b-button class="m-2">Ver mas ...</b-button></h2>
    </div>


    <div class="seccion-cuerpo">

      <div v-if="peliculas.length > 0">

        <div class="peliculas">
          <PeliculaCard v-for="pelicula in peliculas" :key="pelicula.id" :pelicula="pelicula"></PeliculaCard>
        </div>

      </div>


      <div v-else>
        <p>No hay películas populares para mostrar</p>
      </div>

    </div>

  </div>
</template>

<script>
import PeliculaCard from '@/components/PeliculaCard.vue';

export default {
  name: 'ListaPeliculas',
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
.seccion-cuerpo, .peliculas{
  overflow-x: auto;
  display: flex;
  flex-flow: row nowrap;
  padding: 5px 20px 20px 20px;
}
</style>