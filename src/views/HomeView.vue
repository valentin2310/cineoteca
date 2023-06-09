<template>
  <div class="home">

    <div class="banner bg-dark p-5"  v-bind:style="{
        'background-image': 'linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,7) 100%), url(https://image.tmdb.org/t/p/original/a6ptrTUH1c5OdWanjyYtAkOuYD0.jpg)',
        'background-color': '#17202A',
        'background-size': 'cover',
        'background-repeat': 'no-repeat',
        'background-position': 'center center'
    }">
      <div class="d-flex flex-row flex-wrap justify-content-center align-items-center">
        <img src="../assets/logo.png" width="58">
        <h3 class="title is-2 fw-bold text-center text-white">MiCineoteca</h3>
      </div>
      <div class="banner-cuerpo text-center text-white">
        <b-carousel
            :autoplay="true"
            :indicator="true"
            :indicator-background="false"
            :indicator-inside="false"
            indicator-mode="hover"
            indicator-style="is-dots"
            icon-pack="fas"
            icon-prev="chevron-left"
            icon-next="chevron-right"
            :pause-hover="true"
            :pause-info="false"
            :repeat="true"
            :interval="8000"
            >
            <b-carousel-item>
                <section class="hero is-medium is-dark rounded custom-shadow">
                    <div class="hero-body has-text-centered mx-5 py-3 d-flex flex-column align-items-center justify-content-center">
                      <b-icon pack="fas" icon="face-smile-wink" size="is-large" type="is-primary"></b-icon>
                      <span class="fs-2 fw-bold is-primary">
                        ¡Bienvenidos a MiCineoteca!
                      </span>
                      <p>En nuestra página web, podrás encontrar una amplia selección de películas y series
                        para ver en cualquier momento y lugar. Desde clásicos hasta las últimas novedades, en MiCineoteca tenemos todo
                        lo que necesitas para disfrutar del mejor contenido audiovisual. Toda la informacion sobre el contenido mostrado 
                        proviene de diferentes API`s como la de TMDB</p>
                    </div>
                </section>
            </b-carousel-item>
            <b-carousel-item>
                <section class="hero is-medium is-dark rounded custom-shadow">
                    <div class="hero-body has-text-centered mx-5 py-3 d-flex flex-column align-items-center justify-content-center">
                      <b-icon pack="fas" icon="magnifying-glass-plus" size="is-large" type="is-primary"></b-icon>
                      <span class="fs-2 fw-bold is-primary">¡Descubre el buscador avanzado de películas y series en MiCineoteca!</span>
                      <p>En MiCineoteca, hemos desarrollado un buscador avanzado que te permitirá encontrar fácilmente las películas y series que estás buscando. 
                        Ya sea que estés interesado en un clásico del cine o las últimas novedades, nuestro buscador te proporcionará resultados 
                        precisos y relevantes.</p>
                    </div>
                </section>
            </b-carousel-item>
            <b-carousel-item>
                <section class="hero is-medium is-dark rounded custom-shadow">
                    <div class="hero-body has-text-centered mx-5 py-3 d-flex flex-column align-items-center justify-content-center">
                      <b-icon pack="fas" icon="puzzle-piece" size="is-large" type="is-primary"></b-icon>
                      <span class="fs-2 fw-bold is-primary">¡Personaliza y lleva un registro de tu contenido visto en MiCineoteca!</span>
                      <p>Personaliza tu experiencia en MiCineoteca y lleva un registro de tu contenido visto. Puedes valorar películas y series, añadir favoritos 
                        y crear listas de seguimiento. Además, marca los episodios como vistos para llevar un historial detallado. Disfruta de una experiencia 
                        de entretenimiento a tu medida.</p>
                    </div>
                </section>
            </b-carousel-item>
            <b-carousel-item>
                <section class="hero is-medium is-dark rounded custom-shadow">
                    <div class="hero-body has-text-centered py-3 d-flex flex-column align-items-center justify-content-center">
                      <b-icon pack="fas" icon="cloud" size="is-large" type="is-primary"></b-icon>
                      <span class="fs-2 fw-bold is-primary">
                        ¡Sincroniza tu cuenta de MiCineoteca con la API de TMDB!
                      </span>
                      <p>En MiCineoteca, entendemos la importancia de mantener tus datos y preferencias actualizadas. Por eso, hemos integrado la opción de vincular 
                        tu cuenta de MiCineoteca con la API de TMDB (The Movie Database).</p>
                      <p>Para ver como es el proceso puedes hacer click <router-link to="/login" class="router-link-reset is-primary fw-bold">AQUÍ</router-link></p>
                    </div>
                </section>
            </b-carousel-item>
        </b-carousel>
      </div>
    </div>

    <!-- Buscador series y peliculas -->
    <section class="hero is-primary custom-shadow">
      <div class="hero-body text-white has-text-centered">
        <b-icon pack="fas" icon="magnifying-glass" size="is-large" type="is-white" class="m-3"></b-icon>
        <br>
        <span class="fs-2 fw-bold is-dark">
          Busca peliculas y series
        </span>
        <BuscadorItem></BuscadorItem>
      </div>
    </section>

    <ListaPeliculas :peliculas="peliculasPopulares" :titulo="'Peliculas populares'" ruta="/peliculas/populares" />
    <ListaSeries :series="seriesPopulares" :titulo="'Series populares'" ruta="/series/populares" />

    <!-- Ejemplo listas -->
    <section class="hero is-success custom-shadow">
      <div class="hero-body text-white">
        <b-row>
          <b-col sm="5" class="mb-3 px-3 has-text-centered d-flex flex-column align-items-center justify-content-center">
            <b-icon pack="fas" icon="list" size="is-large" type="is-white"></b-icon>
            <br>
            <span class="fs-2 fw-bold is-dark">
              Crea listas personalizadas
            </span>
            <p>En MiCineoteca, te ofrecemos la posibilidad de crear listas personalizadas y darles tu toque único. Puedes organizar tus películas y series favoritas, 
              así como cualquier otro contenido que desees, en listas temáticas y tenerlas siempre a tu alcance.
            </p>
          </b-col>
          <b-col sm="7" class="bg-black rounded p-3 custom-shadow">
            <div class="has-text-centered">
              <span class="fs-4 fw-bold is-dark">
                Ejemplos de listas creadas en MiCineoteca
              </span>
            </div>
            <ListaUsuario :idLista="'38'" :idUsuario="'-1'"></ListaUsuario>
            <ListaUsuario :idLista="'39'" :idUsuario="'-1'"></ListaUsuario>
            <ListaUsuario :idLista="'40'" :idUsuario="'-1'"></ListaUsuario>
          </b-col>
        </b-row>
      </div>
    </section>

    <ListaPeliculas :peliculas="peliculasMasValoradas" :titulo="'Peliculas mas valoradas'" ruta="/peliculas/masvaloradas" />
    <ListaSeries :series="seriesMasValoradas" :titulo="'Series mas valoradas'" ruta="/series/masvaloradas" />

  </div>
</template>

<script>
import axios from 'axios';
import ListaPeliculas from '@/components/ListaPeliculas.vue';
import ListaSeries from '@/components/ListaSeries.vue';
import ListaUsuario from '@/components/ListaUsuario.vue';
import BuscadorItem from '@/components/BuscadorItem.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
  data() {
    return {
      apiUrl: 'https://api.themoviedb.org/3',
      language: 'es-ES',
      peliculasPopulares: [],
      peliculasRecientes: [],
      peliculasMasValoradas: [],
      seriesPopulares: [],
      seriesMasValoradas: [],
      seriesTransmitiendoHoy: []
    }
  },
  components: {
    ListaPeliculas,
    ListaSeries,
    ListaUsuario,
    BuscadorItem
},
  mounted() {
    this.getPeliculasPopulares(),
      this.getPeliculasRecientes(),
      this.getPeliculasMasValoradas(),
      this.getSeriesPopulares(),
      this.getSeriesMasValoradas(),
      this.getSeriesTransmitiendoHoy()
  },
  methods: {
    getPeliculasPopulares() {
      axios.get(`${this.apiUrl}/movie/popular`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.peliculasPopulares = response.data.results;
          //console.log(this.peliculasPopulares);
        }

        )
        .catch(error => console.log(error))
    },
    getPeliculasRecientes() {
      axios.get(`${this.apiUrl}/movie/now_playing`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.peliculasRecientes = response.data.results;
          //console.log(this.peliculasRecientes);
        }

        )
        .catch(error => console.log(error))
    },
    getPeliculasMasValoradas() {
      axios.get(`${this.apiUrl}/movie/top_rated`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.peliculasMasValoradas = response.data.results;
          //console.log(this.peliculasMasValoradas);
        }

        )
        .catch(error => console.log(error))
    },
    getSeriesPopulares() {
      axios.get(`${this.apiUrl}/tv/popular`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.seriesPopulares = response.data.results;
          //console.log(this.seriesPopulares[0].id);
        }

        )
        .catch(error => console.log(error))
    },
    getSeriesMasValoradas() {
      axios.get(`${this.apiUrl}/tv/top_rated`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.seriesMasValoradas = response.data.results;
          //console.log(this.seriesPopulares[0].id);
        }

        )
        .catch(error => console.log(error))
    },
    getSeriesTransmitiendoHoy() {
      axios.get(`${this.apiUrl}/tv/airing_today`, {
        params: {
          api_key: API_KEY,
          language: this.language
        }
      })
        .then(response => {
          this.seriesTransmitiendoHoy = response.data.results;
          //console.log(this.seriesPopulares[0].id);
        }

        )
        .catch(error => console.log(error))
    }
  }
}

</script>

<style scoped>
.banner-cuerpo {
  font-size: larger;
}
.bg-linear{
  background: linear-gradient(30deg, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.05) 100%);
}
.is-primary{
  color: blueviolet !important;
}

.banner-cuerpo .hero{
  background-color: #000000a0;
  border-radius: 20px !important;
  height: 50vh;
  overflow-y: auto;
}
.carousel-item {
  /* Estilos personalizados para sobrescribir los estilos de BootstrapVue */
  position: static;
  display: block;
  float: none;
  width: 100%;
  margin-right: 0;
  backface-visibility: visible;
  transition: none;
}

.custom-shadow{
    box-shadow: black 0px 0px 5px;
}

</style>
