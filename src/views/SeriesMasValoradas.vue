<template>
    <div class="series-populares">

        <!-- Contenido -->
        <PantallaSeries :series="listaSeries" :titulo="'Series populares'" :total_paginas="total_paginas"/>

        <b-pagination
            @change="getListaSeries()"
            :total="total_paginas"
            v-model="pagina_actual"
            range-before="2"
            range-after="1"
            order="is-centered"
            size="default"
            :simple="false"
            :rounded="true"
            :per-page="1"
            icon-pack="fas"
            icon-prev="chevron-left"
            icon-next="chevron-right"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
            :page-input="true"
            page-input-position="dafault"
            :debounce-page-input="0">
        </b-pagination>


    </div>
</template>

<script>
import axios from 'axios';
import PantallaSeries from '@/components/PantallaSeries.vue';


const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
  data() {
    return {
        apiUrl: 'https://api.themoviedb.org/3',
        laguage: 'es-ES',

        listaSeries: [],
        total_paginas: 0,

        pagina_actual: 1,
        
    }
  },
  components: {
    PantallaSeries
  },
  created () {
    this.getListaSeries();
  },
  methods: {
    getListaSeries() {
      axios.get(`${this.apiUrl}/tv/top_rated`, {
        params: {
          api_key: API_KEY,
          language: this.language,
          page: this.pagina_actual
        }
      })
        .then(response => {
          //console.log(response.data);
          this.listaSeries = response.data.results;
          this.total_paginas = response.data.total_pages > 500 ? 500 : response.data.total_pages;

          //console.log(this.peliculasPopulares);
        }

        )
        .catch(error => console.log(error))
    },
  }
}
</script>

<style scoped>
    .pagination{
        margin: 30px 10px;
    }

</style>