<template>
  <div class="">
    <div id="banner" v-bind:style="{
      'background-image': 'linear-gradient(30deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0.75) 49%, rgba(0,0,0,0.52) 100%), url(https://image.tmdb.org/t/p/original/' + pelicula.backdrop_path + ')',
      'background-size': 'cover',
      'background-repeat': 'no-repeat',
      'background-position': 'center center'
    }">

      <h1 id="titulo">{{ pelicula.title }}</h1>
      <p id="descripcion">{{ pelicula.overview }}</p>
      <p><span id="duracion">{{ pelicula.runtime }}</span> min · <span id="annio">{{ pelicula.release_date }}</span></p>

      <div class="botones">
        <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Añadir lista</button>
        <button type="button" class="btn btn-primary"><i class="fa-solid fa-heart"></i>Favorito</button>
        <button type="button" class="btn btn-primary"><i class="fa-solid fa-calendar"></i>Lista seguimiento</button>
        <button type="button" class="btn btn-primary"><i class="fa-solid fa-star"></i>Valorar</button>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
  data() {
    return {
      apiUrl: 'https://api.themoviedb.org/3',
      language: 'es-ES',
      peliculaId: null,
      pelicula: {}
    }
  },
  mounted() {
    this.peliculaId = this.$route.params.id;
    axios.get(`${this.apiUrl}/movie/${this.peliculaId}`, {
      params: {
        api_key: API_KEY,
        language: this.language,
      },
    })
      .then(response => {
        this.pelicula = response.data;
        console.log(this.pelicula);
      })
      .catch(error => {
        console.error(error);
      });
  }
}
</script>

<style>
#banner {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 70vh;
  color: whitesmoke;
  padding: 20px 20%;
}
</style>