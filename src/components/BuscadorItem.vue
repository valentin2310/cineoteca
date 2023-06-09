<template>
    <div class="buscador">

        <b-autocomplete
            class="navbar-item"
            :data="data"
            placeholder="Busca una pelicula o serie... "
            icon-pack="fas"
            icon="magnifying-glass"
            clearable
            :expanded="true"
            :loading="isFetching"
            :check-infinite-scroll="true"
            @typing="getAsyncData"
            @select="option => selected = option"
            @infinite-scroll="getMoreAsyncData">

            <template slot-scope="props">
                <router-link class="router-link-reset" :to="props.option.media_type == 'movie' ? `/pelicula/${props.option.id}` : `/serie/${props.option.id}`" @click="recargarPag">
                  <div class="media">
                      <div class="media-left">
                          <img v-if="props.option.poster_path" width="32" :src="`https://image.tmdb.org/t/p/w500/${props.option.poster_path}`">
                          <img v-else src="../assets/img/poster_fail.png" alt="x">
                      </div>
                      <div class="media-content">
                        <b-icon v-if="props.option.media_type == 'tv'" pack="fas" icon="tv"></b-icon>
                        <b-icon v-else pack="fas" icon="film"></b-icon>
                          {{ props.option.media_type == 'movie'? props.option.title : props.option.name }}
                          <br>
                          <small>
                              {{ props.option.release_date }}<b-icon pack="fas" icon="calendar"></b-icon> 
                              <b>{{ props.option.vote_average }}</b><b-icon pack="fas" icon="star" type="is-primary"></b-icon>
                          </small>
                      </div>
                  </div>
                </router-link>
            </template>
            <template #footer>
                <span v-show="page > totalPages" class="has-text-grey"> Eso es todo!! Ya no hay mas resultados </span>
            </template>
        </b-autocomplete>

    </div>
</template>

<script>
import axios from 'axios';
import { debounce } from 'vue-debounce'

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
    name: 'BuscadorItem',
    data() {
        return{
            apiUrl: 'https://api.themoviedb.org/3',

            data: [],
            selected: null,
            isFetching: false,
            name: '',
            page: 1,
            totalPages: 1
        }
    },
    methods: {
        getAsyncData: debounce(function (name) {
          // String update
          if (this.name !== name) {
              this.name = name
              this.data = []
              this.page = 1
              this.totalPages = 1
          }
          // String cleared
          if (!name.length) {
              this.data = []
              this.page = 1
              this.totalPages = 1
              return
          }
          // Reached last page
          if (this.page > this.totalPages) {
              return
          }
          this.isFetching = true
          axios.get(`${this.apiUrl}/search/multi`, {
            params: {
              api_key: API_KEY,
              language: this.language,
              page: this.page,
              include_adult: true,
              query: this.name
            }
          })
              .then(({ data }) => {
                  data.results.forEach((item) => {
                    if(item.media_type == 'movie' || item.media_type == 'tv')
                      this.data.push(item)
                  })

                  this.page++
                  this.totalPages = data.total_pages
              })
              .catch((error) => {
                  throw error
              })
              .finally(() => {
                  this.isFetching = false
              })
      }, 500),
      getMoreAsyncData: debounce(function () {
          this.getAsyncData(this.name)
      }, 250),
      recargarPag: debounce(function (){
        location.reload();
      }, 100),
    }
}
</script>
