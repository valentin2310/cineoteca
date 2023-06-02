<template>
  <div class="peliculaCard">

      <div class="card d-block">
        <router-link :to="`/pelicula/${pelicula.id}`" class="router-link-reset">

          <div v-if="pelicula.poster_path" class="card-poster"
            v-bind:style="{ 'background-image': 'url(https://image.tmdb.org/t/p/w500/' + pelicula.poster_path + ')' }">
            <b-icon pack="fas" icon="film" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
          </div>
          <div v-else class="card-poster">
            <b-icon pack="fas" icon="film" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
          </div>

        
        <div class="card-body p-2">
          
          <div class="detalles">
            <div class="valoracion">
              <i class="fa-solid fa-star"></i> <span>{{ pelicula.vote_average }}</span>
            </div>
            <div class="info">
              <i v-b-popover.hover.right="pelicula.overview" :title="pelicula.title" class="fa-solid fa-circle-info"></i>
            </div>
          </div>
          <div class="card-title">
            <span>{{ pelicula.title }}</span>
          </div>
        </div>

        </router-link>
    </div>
  
  </div>
</template>

<script>

import router from '@/router'

export default {
  name: 'PeliculaCard',
  props: {
    pelicula: {
      type: Object,
      required: true
    }
  },
  methods: {
    verDetalles() {
      const id = this.pelicula.id;
      router.push({ name: 'pelicula', params: { id } });
    }
  }
};
</script>

<style scoped>
    .peliculaCard .card {
      width: 140px;
      height: 100% !important;
      border-radius: 15px 0px 15px 0px;
      background-color: whitesmoke;
      border: 3px solid white;
      box-shadow: black 0px 0px 5px;
      margin: 0px 5px;
    }

    .peliculaCard .card:hover {
      box-shadow: blueviolet 0px 0px 8px;
      transition: 0.5s;
      cursor: pointer;
    }

    .peliculaCard .card-body {
      padding: 5px;
    }

    .peliculaCard .card-poster {
      background-image: url('./../assets/img/poster_fail.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      border-radius: 15px 5px 0px 0px;
      height: 200px;

    }

    .peliculaCard .card .detalles {
      display: flex;
      flex-direction: row nowrap;
      justify-content: space-between;
    }

    .peliculaCard .card .valoracion i {
      color: blueviolet;
    }

    .peliculaCard .card .valoracion,
    .peliculaCard .card .info {
      margin: 3px 0px;
    }

    .peliculaCard .card-title span {
        font-weight: bold;
        font-size: 0.9em;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2; /* número máximo de líneas */
    }
    .peliculaCard .card-title span:hover{
      color: blueviolet;
      transition: 0.5ms;
    }
    .router-link-reset {
      color: inherit;
      text-decoration: none;
      /* Otros estilos personalizados */
    }
</style>

<style>

  .bg-linear{
    background: linear-gradient(30deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 100%);
    box-shadow: 0px 0px 3px black;
  }

</style>