<template>
  <div class="home">

    <div class="banner bg-dark p-5">
      <h3 class="title is-3 text-center text-white pt-3">MiCineoteca</h3>
      <div class="banner-cuerpo text-center text-white">
        <p>¡Bienvenidos a MiCineoteca! En nuestra página web, podrás encontrar una amplia selección de películas y series
          para ver en cualquier momento y lugar. Desde clásicos hasta las últimas novedades, en MiCineoteca tenemos todo
          lo que necesitas para disfrutar del mejor contenido audiovisual.</p>
      </div>
    </div>

    <ListaSeries :series="seriesPopulares" :titulo="'Series populares'" />
    <ListaPeliculas :peliculas="peliculasPopulares" :titulo="'Peliculas populares'" ruta="/peliculas/populares" />
    <ListaSeries :series="seriesTransmitiendoHoy" :titulo="'Series transmitiendose hoy'" />
    <ListaPeliculas :peliculas="peliculasRecientes" :titulo="'Peliculas recientes'" />
    <ListaSeries :series="seriesMasValoradas" :titulo="'Series mas valoradas'" />
    <ListaPeliculas :peliculas="peliculasMasValoradas" :titulo="'Peliculas mas valoradas'" />




  </div>
</template>

<script>
import axios from 'axios';
import ListaPeliculas from '@/components/ListaPeliculas.vue';
import ListaSeries from '@/components/ListaSeries.vue';

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
    ListaSeries
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

<style>
.banner-cuerpo {
  font-size: larger;
}
.bg-linear{
  background: linear-gradient(30deg, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.05) 100%);
}
</style>
