<template>
  <div class="pelicula-view">
    <b-row align-v="end" id="banner" class="mx-0" v-bind:style="{
      'background-image': 'url(https://image.tmdb.org/t/p/original/' + pelicula.backdrop_path + ')',
      'background-size': 'cover',
      'background-repeat': 'no-repeat',
      'background-position': 'center center'
    }">

      <b-col class="info-pelicula text-center">
        <span id="titulo">{{ pelicula.title }}</span>

        <div class="botones">
          <b-button id="btn-lista" variant="primary">
              <i class="fa-solid fa-plus me-2"></i>Añadir lista
          </b-button>
          <b-button id="btn-favorito" variant="danger">
              <i class="fa-solid fa-heart me-2"></i>Favorito
          </b-button>
          <b-button id="btn-seguimiento" variant="success">
              <i class="fa-solid fa-calendar me-2"></i>Lista seguimiento
          </b-button>
          <b-button id="btn-valorar">
              <i class="fa-solid fa-star me-2"></i>Valorar
          </b-button>
        </div>
      </b-col>
      
    </b-row>

    <div class="container">
      <b-row>

        <b-col sm="3">
          <div class="menu-pelicula">

            <div class="portada my-3">
              <img :src="'https://image.tmdb.org/t/p/w500/' + pelicula.poster_path" alt="poster">
            </div>
            <div class="menu-secciones">
  
              <ul class="mx-3 p-0 text-center text-info fw-bold">
                <li>Detalles</li>
                <li>Sinapsis</li>
                <li>Reparto</li>
                <li>Comentarios</li>
              </ul>
  
            </div>

          </div>
        </b-col>
        <b-col sm="8">

          <div class="detalles my-3">
            <h4 class="text-dark ms-2">Detalles</h4>
            <hr>
            <div class="ms-3">
              <b-row class="w-100 my-2">
                <b-col sm="6"><span class="fw-bold">Titulo original: </span>{{ pelicula.original_title }}</b-col>
                <b-col sm="6"><span class="fw-bold">Idioma original: </span>{{ pelicula.original_language }}</b-col>
              </b-row>
              
              <b-row class="w-100 my-2">
                <b-col sm="6"><span class="fw-bold">Fecha de estreno: </span>{{ pelicula.release_date }}</b-col>
                <b-col sm="6"><span class="fw-bold">Duracion: </span>{{ pelicula.runtime }} min</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col><span class="fw-bold">Generos: </span>{{ obtenerGeneros() }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col sm="10">
                  <span class="fw-bold">Valoracion: </span>
                  <b-form-rating v-model="pelicula.vote_average" stars="10" color="blueviolet" show-value readonly precision="2"></b-form-rating>
                </b-col>
                <b-col sm="6"><span class="fw-bold">Votos realizados: </span>{{ pelicula.vote_count }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col><span class="fw-bold">Presupuesto: </span>{{ pelicula.budget.toLocaleString('en-EN', {style: 'currency', currency: 'USD'}) }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col><span class="fw-bold">Productoras: </span>{{ obtenerProductoras() }}</b-col>
              </b-row>

            </div>
          </div>

          <div class="sinopsis my-3">
            <h4 class="text-dark ms-2">Sinopsis</h4>
            <hr>
            <div class="seccion-cuerpo">
              <span>{{ pelicula.overview }}</span>
            </div>
          </div>

          <div class="sinopsis my-3">
            <h4 class="text-dark ms-2">Reparto</h4>
            <hr>
          </div>

          <div class="sinopsis my-3">
            <h4 class="text-dark ms-2">Comentarios</h4>
            <hr>
            <div class="seccion-cuerpo">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio ducimus necessitatibus sit assumenda quas minus! Quisquam, pariatur veritatis non iste cupiditate, explicabo nesciunt aperiam a quas placeat enim? Suscipit, voluptates?
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde accusamus quidem, cumque animi maxime vero! Veritatis beatae placeat consequatur suscipit ullam sint odio, atque unde reiciendis voluptatibus explicabo ipsum tenetur?
              Temporibus amet quisquam vitae esse obcaecati repellendus veritatis facilis ab dolore modi. Cupiditate officiis quibusdam repudiandae quam voluptatem animi praesentium adipisci, amet, fugiat laboriosam tempore accusamus earum placeat incidunt consequatur?
              Soluta veniam sapiente dolorum aliquid cumque itaque ea beatae! Est officiis deleniti ea nisi assumenda eligendi quasi, possimus magnam rem fugiat accusantium repudiandae illum in consectetur tempora, iure mollitia! Impedit.
              Voluptas quia sint rerum consequatur! Sit aliquid iure accusamus ipsam libero praesentium. Eius, quos corrupti maiores vero minima, nostrum consectetur quaerat consequuntur dolores tempore quisquam perferendis laudantium, amet ipsa repellat.
              Tenetur, qui. Autem consectetur, eveniet distinctio assumenda eius fugiat sapiente optio laudantium libero dicta mollitia est minima! Ullam, natus ducimus tempora aut inventore repellat magnam provident sunt minima impedit architecto?
            </div>
          </div>

        </b-col>

      </b-row>
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
  methods: {
    obtenerProductoras(){
        let productoras = ""

        if (this.pelicula.production_companies) {
          for (let i = 0; i < this.pelicula.production_companies.length; i++) {
            if (i !== 0) productoras += ", "
            productoras += this.pelicula.production_companies[i].name
          }
        }
        return productoras
    },
    obtenerGeneros(){
        let generos = ""

        if (this.pelicula.genres) {
          for (let i = 0; i < this.pelicula.genres.length; i++) {
            if (i !== 0) generos += ", ";
            generos += this.pelicula.genres[i].name;
          }
        }
        return generos;
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
.pelicula-view{
  background-color: whitesmoke;
}
#banner {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 70vh;
  color: whitesmoke;
}
.info-pelicula{
  padding: 20px 20% !important;
  background-color: rgba(0, 0, 0, 0.75);
}
#titulo{
  font-size: xx-large;
}
.botones{
  display: flex;
  flex-flow: row wrap;
  justify-content: center;
  
}
#btn-valorar{
  background-color: blueviolet;
}
.botones .btn{
  margin: 10px 10px 0px 10px;
}
.menu-pelicula{
  position: sticky;
  top: 85px;
}
.portada{
  width: 100%;
  padding: 5px;
  background-color: whitesmoke;
  border-radius: 5px;
  box-shadow: black 0px 0px 5px;
}
.portada img{
  width: 100%;
}
.menu-secciones li{
  text-decoration: none;
  list-style: none;
  border-bottom: black solid 1px;
  margin: 0;
  padding: 5px;
}
.menu-secciones li:hover{
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.2);
  color: white;
}
</style>