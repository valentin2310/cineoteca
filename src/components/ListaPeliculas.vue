<template>
  <div class="seccion">


    <div class="seccion-titulo">
      <h2 class="title mx-5 d-flex flex-row flex-wrap align-items-baseline">{{ titulo }} <b-button v-if="ruta" type="is-primary is-light" rounded class="m-2" tag="router-link" :to="ruta">Ver más ...</b-button></h2>
    </div>


    <div class="seccion-cuerpo">

      <div v-if="peliculas.length > 0">

        <div class="peliculas">
          <PeliculaCard v-for="pelicula in peliculas" :key="pelicula.id" :pelicula="pelicula"></PeliculaCard>
        </div>

      </div>


      <div v-else>
        <p>No hay películas para mostrar</p>
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
.seccion-cuerpo, .peliculas{
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
  .seccion-cuerpo, .peliculas{
  padding: 5px 2px 20px 2px;
}

}
</style>