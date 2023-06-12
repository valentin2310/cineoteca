<template>
    <div class="repartoCard">
  
        <div class="card d-block">
          <div v-if="persona.profile_path" class="card-poster"
            v-bind:style="{ 'background-image': 'url(https://image.tmdb.org/t/p/w500/' + persona.profile_path + ')' }">
            <b-icon pack="fas" icon="user-astronaut" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
          </div>
          <div v-else class="card-poster">
            <b-icon pack="fas" icon="user-astronaut" class="rounded float-end mx-1 p-1 bg-linear" type="is-white"></b-icon>
          </div>

        
        <div class="card-body p-2">
          
          <div class="detalles ps-2 float-end">
            <div class="info">
              <i v-b-popover.hover.right="persona.known_for_department" :title="persona.name" class="fa-solid fa-circle-info"></i>
            </div>
          </div>
          <div class="card-title">
            <span class="fw-bold">{{ persona.character?persona.character:'N/A' }}</span>
          </div>
          <div class="card-cuerpo">
            <span>{{ persona.name?persona.name:'N/A' }}</span>
          </div>
        </div>

      </div>
    
    </div>
  </template>
  
  <script>
  
  export default {
    name: 'RepartoCard',
    props: {
      persona: {
        type: Object,
        required: true
      }
    }
  };
  </script>
  
  <style scoped>
      .repartoCard .card {
        width: 140px;
        height: 100% !important;
        border-radius: 15px 0px 15px 0px;
        background-color: whitesmoke;
        border: 3px solid white;
        box-shadow: black 0px 0px 5px;
        margin: 0px 5px;
      }
  
      .repartoCard .card:hover {
        box-shadow: blueviolet 0px 0px 8px;
        transition: 0.5s;
        cursor: pointer;
      }
  
      .repartoCard .card-body {
        padding: 5px;
      }
  
      .repartoCard .card-poster {
        background-image: url('./../assets/img/poster_fail.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border-radius: 15px 5px 0px 0px;
        height: 200px;
  
      }
  
      .repartoCard .card .detalles {
        display: flex;
        flex-direction: row nowrap;
        justify-content: space-between;
      }
  
      .repartoCard .card .valoracion i {
        color: blueviolet;
      }
  
      .repartoCard .card .valoracion,
      .repartoCard .card .info {
        margin: 3px 0px;
      }
  
      .repartoCard .card-title span {
          font-weight: bold;
          font-size: 0.9em;
          display: -webkit-box;
          -webkit-box-orient: vertical;
          overflow: hidden;
          text-overflow: ellipsis;
          -webkit-line-clamp: 2; /* número máximo de líneas */
      }
      .repartoCard .card-title span:hover{
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