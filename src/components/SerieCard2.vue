<template>
    <div class="serieCard2">
  
        <div class="card d-block">
          <router-link :to="`/serie/${serie.id}`" class="router-link-reset">
  
            <div v-if="serie.poster_path" class="card-poster"
              v-bind:style="{ 'background-image': 'url(https://image.tmdb.org/t/p/w500/' + serie.poster_path + ')' }">
              
              <b-icon pack="fas" icon="tv" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
            </div>
            <div v-else class="card-poster">
                <b-icon pack="fas" icon="tv" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
            </div>
  
          
          <div class="card-body p-2">
            
            <div class="detalles">
              <div class="valoracion">
                <i class="fa-solid fa-star"></i> <span>{{ serie.vote_average }}</span>
              </div>
              <div class="info">
                <i v-b-popover.hover.right="serie.overview" :title="serie.name" class="fa-solid fa-circle-info"></i>
              </div>
            </div>
            <div class="card-title">
              <span>{{ serie.name }}</span>
            </div>
          </div>
  
          </router-link>
      </div>
    
    </div>
  </template>
  
  <script>
  
  export default {
    name: 'SerieCard2',
    props: {
      serie: {
        type: Object,
        required: true
      }
    },
  };
  </script>
  
  <style scoped>
      .card {
        width: 140px;
        height: 100% !important;
        border-radius: 15px 0px 15px 0px;
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
        background-image: url('./../assets/img/poster_fail.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border-radius: 15px 5px 0px 0px;
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
      .card-title span:hover{
        color: blueviolet;
        transition: 0.5ms;
      }
      .router-link-reset {
        color: inherit;
        text-decoration: none;
        /* Otros estilos personalizados */
      }
      
      .bg-linear{
        background: linear-gradient(30deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 100%);
      }
  </style>