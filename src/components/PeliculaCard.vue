<template>
  <div class="peliculaCard">

      <div class="card d-block" @click="verDetalles">
        
        <div class="card-poster"
        v-bind:style="{ 'background-image': 'url(https://image.tmdb.org/t/p/w500/' + pelicula.poster_path + ')' }">
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

<style>
    .card {
      width: 140px;
      height: 100%;
      border-radius: 5px;
      background-color: whitesmoke;
      border: 3px solid white;
      box-shadow: black 0px 0px 5px;
      margin: 0px 5px;
    }

    .card:hover {
      box-shadow: blueviolet 0px 0px 8px;
      transition: 0.5s;
      cursor: pointer;
    }

    .card-body {
      padding: 5px;
    }

    .card-poster {
      background: url('https://www.themoviedb.org/t/p/w220_and_h330_face/q6j9Dn3iiXoCjpVitDppNNZXwVq.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      border-radius: 5px 5px 0px 0px;
      height: 200px;

    }

    .card .detalles {
      display: flex;
      flex-direction: row nowrap;
      justify-content: space-between;
    }

    .card .valoracion i {
      color: blueviolet;
    }

    .card .valoracion,
    .card .info {
      margin: 3px 0px;
    }

    .card-title span {
        font-weight: bold;
        font-size: 0.9em;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2; /* número máximo de líneas */
    }
</style>