<template>
    <div class="filtroPantallaItems">

        <b-row>
            <b-col sm="3" class="mb-3">
                
                <div class="filtro rounded custom-shadow">
                    <b-field class="bg-dark text-white p-3 mb-0 fw-bold rounded-top"><i class="fa-solid fa-filter me-2 "></i> Mostrar</b-field>
                    <div class="opciones py-3 px-3 bg-gris rounded-bottom">

                        <b-field>
                            <b-radio 
                                v-model="mostrar"
                                native-value="0"
                                type="is-dark"
                            >
                                Todo ({{ listaItems.length }})
                            </b-radio>
                        </b-field>
                        <b-field>
                            <b-radio 
                                v-model="mostrar"
                                native-value="1"
                                type="is-info"
                            >
                                Series ({{ listaItems.filter(item => item.media_type == 'tv').length }})
                            </b-radio>
                        </b-field>
                        <b-field>
                            <b-radio 
                                v-model="mostrar"
                                native-value="2"
                                type="is-success"
                            >
                                Peliculas ({{ listaItems.filter(item => item.media_type == 'movie').length }})
                            </b-radio>
                        </b-field>

                    </div>
                </div>

            </b-col>

            <b-col sm="9" class="">

                <div class="contenido custom-shadow rounded">

                    <div class="contenido-cabecera bg-dark p-3 text-white rounded-top">
        
                        <div class="buscador">
                            <b-field class="my-2 p-0">
                                <b-input v-model="filtro" @input="filtrarItems" icon-pack="fas" icon="magnifying-glass" placeholder="Busca una pelicula o serie en esta lista..." expanded></b-input>
                            </b-field>
                        </div>

                    </div>

                    
                    <div class="items pt-5 pb-5 px-3 rounded-bottom bg-gris">                 

                        <div class="">
                            <PantallaItems v-if="itemsFiltrados"  :listaItems="itemsFiltrados"></PantallaItems>
                        </div>

                    </div>

                </div>


            </b-col>
        </b-row>

    </div>
</template>

<script>

import axios from 'axios';
import { debounce } from 'vue-debounce';
import PantallaItems from '@/components/PantallaItems.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
  name: 'FiltroPantallaItems',
  components: {
    PantallaItems
  },
  props: {
    listaItems: {
      type: Array,
      required: true,
    }
  },
  data() {
    return{
        listaItemsObj: [],

        apiUrl: 'https://api.themoviedb.org/3',
        access_token: null,

        mostrar: "0",
        elegirOpcionBuscar: false,
        elegirOpcionEliminar: false,

        data: [],
        selected: null,
        isFetching: false,
        name: '',
        page: 1,
        totalPages: 1,

        filtro: '',
        itemsFiltrados: [],
    }
  },
  watch: {
        mostrar: {
            handler: 'filtrarItems',
            immediate: true
        }
    },
    methods: {
      filtrarItems() {
            const textoBusqueda = this.filtro.toLowerCase();

            this.itemsFiltrados = this.listaItemsObj.filter(item => {
                const tituloIncluyeTexto = item.title?item.title.toLowerCase().includes(textoBusqueda):item.name.toLowerCase().includes(textoBusqueda);
                console.log("Texto busqueda: "+tituloIncluyeTexto)

                if (this.mostrar == 0) {
                    return tituloIncluyeTexto;
                } else if (this.mostrar == 1) {
                    return tituloIncluyeTexto && item.name;
                } else if (this.mostrar == 2) {
                    return tituloIncluyeTexto && item.title;
                }
            });
        },
        async getSerieDetalles(itemId) {

            try{
            const response = await axios.get(`${this.apiUrl}/tv/${itemId}`, {
                params: {
                    api_key: API_KEY,
                    language: this.language
                }
            });

            return response.data;

            }catch (error){
            console.log(error);
            throw error;
            }
        },
        async getPeliculaDetalles(itemId) {

            try{
                const response = await axios.get(`${this.apiUrl}/movie/${itemId}`, {
                params: {
                    api_key: API_KEY,
                    language: this.language,
                },
                });

                return response.data;

            }catch(error){
                console.log(error);
                throw error;
            }

        },
        async getDetallesListaItems() {
            const itemPromises = this.listaItems.map(async (item) => {
                if (item.media_type === 'tv') {
                try {
                    return await this.getSerieDetalles(item.id_item);
                } catch (error) {
                    console.log(error);
                }
                } else if (item.media_type === 'movie') {
                try {
                    return await this.getPeliculaDetalles(item.id_item);
                } catch (error) {
                    console.log(error);
                }
                }
            });

            try {
                const items = await Promise.all(itemPromises);
                this.listaItemsObj = items.filter((item) => item !== null && item !== undefined);

                
                this.itemsFiltrados = this.listaItemsObj;

            } catch (error) {
                console.log(error);
            }
        },
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
      }, 250)
    },
    mounted: debounce(async function(){
        this.getDetallesListaItems();
    }, 1500)
};

</script>

<style scoped>
    .item{
        margin: 5px 0px;
    }

    .peliculaCard, .serieCard, .serieCard2{
    height: 100%;
  }
  .title{
    color: whitesmoke;
}

.custom-shadow{
    box-shadow: black 0px 0px 5px;
}



</style>