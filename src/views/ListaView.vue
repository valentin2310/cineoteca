<template>
    <div class="lista-view p-5">
        
        <div class="cabecera-lista bg-dark rounded text-white p-5 custom-shadow" v-bind:style="{
                'background-image': lista.backdrop_path?`linear-gradient(52deg, rgba(0,0,0,0.94) 29%, rgba(61,61,61,0.5) 100%), url(https://image.tmdb.org/t/p/original/${lista.backdrop_path})`:'',
                'background-size': 'cover',
                'background-repeat': 'no-repeat',
                'background-position': 'center center'
            }">

            <div v-if="idUsuario == lista.id_creador" class="botones-gestion-lista">
                <!-- BtnEditarLista -->
                <BtnEditarLista v-if="access_token" class="float-end" @listaEditada="editarLista" :lista="lista" :access_token="access_token"></BtnEditarLista>
                <BtnEditarLista v-else class="float-end" @listaEditada="editarLista" :lista="lista"></BtnEditarLista>
            </div>
            <p class="mb-3 d-flex flex-row flex-wrap align-items-baseline">
                <span class="title fw-bold me-1 mb-0">
                    {{ lista.titulo }}
                </span> 
                <b-icon v-if="lista.id_tmdb" class="mx-1" size="is-small" type="is-info" pack="fas" icon="cloud" title="Esta sincronizado con tmdb"></b-icon>
                {{ `(${obtenerFecha(lista.fecha_creacion)})` }}
            </p>
            <div v-if="lista.id_tmdb" class="">
                <a  :href="`https://www.themoviedb.org/list/${lista.id_tmdb}`" target="_blank" class="text-info">Ver lista en TMDB</a>
                <br>
            </div>
            <span v-if="lista.privacidad == 0"> <i class="fa-solid fa-lock"></i> Privada</span>
            <span v-else><i class="fa-solid fa-earth-americas"></i> Pública</span>
            <br>
            <span class="text-white-50">Descripcion: </span>{{ lista.descripcion }}
            <br>
            <span class="text-white-50">Cantidad de series: </span>{{ listaItems.filter(item => item.media_type == 'tv').length }}
            <br>
            <span class="text-white-50">Cantidad de peliculas: </span>{{ listaItems.filter(item => item.media_type == 'movie').length }}
            <br>
            <span class="text-white-50">Total series y peliculas: </span>{{ listaItems.length }}
            <br>
            <span class="text-white-50">Última modificación: </span>{{ obtenerFecha(lista.fecha_modificacion) }}


        </div>

        <b-row class="mt-4">
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
                                Todo
                            </b-radio>
                        </b-field>
                        <b-field>
                            <b-radio 
                                v-model="mostrar"
                                native-value="1"
                                type="is-info"
                            >
                                Series
                            </b-radio>
                        </b-field>
                        <b-field>
                            <b-radio 
                                v-model="mostrar"
                                native-value="2"
                                type="is-success"
                            >
                                Peliculas
                            </b-radio>
                        </b-field>

                    </div>
                </div>

            </b-col>

            <b-col sm="9" class="">

                <div class="contenido custom-shadow rounded">

                    <div class="contenido-cabecera bg-dark p-3 text-white rounded-top">

                        <b-field class="my-2">
                            <b-switch v-model="elegirOpcionBuscar">
                                {{ !elegirOpcionBuscar?'Buscar en la lista':'Buscar para agregar items a la lista' }}
                            </b-switch>
                        </b-field>
        
                        <div v-show="elegirOpcionBuscar" class="buscador">
                            <b-autocomplete
                              class="navbar-item rounded my-2 p-0"
                              :data="data"
                              placeholder="Busca una pelicula o serie... "
                              icon-pack="fas"
                              icon="magnifying-glass"
                              clearable
                              :expanded="true"
                              :loading="isFetching"
                              :check-infinite-scroll="true"
                              @typing="getAsyncData"
                              @select="option => (addItemLista(option))"
                              @infinite-scroll="getMoreAsyncData">
        
                              <template slot-scope="props">
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
                              </template>
                              <template #footer>
                                  <span v-show="page > totalPages" class="has-text-grey"> Eso es todo!! Ya no hay mas resultados </span>
                              </template>
                          </b-autocomplete>
                        </div>
        
                        <div v-show="!elegirOpcionBuscar" class="buscador">
                            <b-field class="my-2 p-0">
                                <b-input v-model="filtro" @input="filtrarItems" icon-pack="fas" icon="magnifying-glass" placeholder="Busca una pelicula o serie en esta lista..." expanded></b-input>
                            </b-field>
                        </div>

                    </div>

                    
                    <div class="items pt-5 pb-5 px-3 rounded-bottom bg-gris">
                        
                        <b-field class="mb-2">
                            <b-switch type="is-danger" v-model="elegirOpcionEliminar">
                                Eliminar items lista?
                            </b-switch>
                        </b-field>                    

                        <div v-if="!elegirOpcionEliminar" class="">
                            <PantallaItems  :listaItems="itemsFiltrados"></PantallaItems>
                        </div>

                        <div v-else class="">
                            <div v-for="item in itemsFiltrados" :key="item.id+item.title" class="lista rounded my-2 p-3 bg-dark text-white">
                                <div class="lista-menu float-end" @click="alertDeleteItemLista(item)">
                                    <i class="fa-solid fa-trash-can text-danger" title="Eliminar item de la lista"></i>
                                </div>

                                <div class="d-flex flex-row-flex-nowrap align-items-center">
                                    <div class="poster-img">
                                        <img v-if="item.poster_path" width="32" :src="`https://image.tmdb.org/t/p/w500/${item.poster_path}`">
                                        <img v-else src="../assets/img/poster_fail.png" alt="x">
                                    </div>
                                    
                                    <div class="titulo p-2">
                                        {{ item.title }}
                                    </div>
                                </div>

                            </div>
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
import BtnEditarLista from '@/components/BtnEditarLista.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default{
    data(){
        return{
            idUsuario: null,
            idLista: null,
            lista: {},
            listaItems: [],

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
    components: {
        PantallaItems,
        BtnEditarLista
},
    watch: {
        mostrar: {
            handler: 'filtrarItems',
            immediate: true
        }
    },
    methods: {
        getLista() {
            const data = {
                id: this.idLista,
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getLista.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(typeof response.data === "object" && response.data !== null) {
                    console.log("Exito");
                    this.lista = response.data;
                }

            })
            .catch(error => console.log(error));
      },
      getListaItems(){
        const data = {
                id: this.idLista,
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getListaItems.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(typeof response.data === "object" && response.data !== null) {
                    console.log("Exito");
                    console.log("Lista items:")
                    this.listaItems = response.data;
                    this.itemsFiltrados = this.listaItems;
                    console.log(this.listaItems)
                }

            })
            .catch(error => console.log(error));
      },
      editarLista(valor){
        if(valor) this.getLista();
      },
      addItemLista(item){
        const data = {
                id_lista: this.idLista,
                id_item: item.id,
                media_type: item.media_type,
                poster_path: item.poster_path,
                backdrop_path: item.backdrop_path,
                vote_average: item.vote_average,
                overview: item.overview,
                titulo: item.media_type == 'movie'?item.title:item.name
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/setItemLista.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(!response.data.includes('Error')) {
                    console.log("Exito");
                    this.getListaItems();
                }

            })
            .catch(error => console.log(error));
      },
      alertDeleteItemLista(item){
        this.$swal({
            title: `Estas seguro que quieres eliminar ${item.title} de la lista?`,
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: 'red',
        })
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                this.deleteItemLista(item);
            } 
        })
      },
      deleteItemLista(item){
        const data = {
                id_lista: this.idLista,
                id_item: item.id,
                media_type: item.media_type
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarItemLista.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(!response.data.includes('Error')) {
                    console.log("Exito");
                    this.getListaItems();
                }

            })
            .catch(error => console.log(error));
      },
      obtenerFecha(fecha){
            const fechaObj = new Date(fecha);
            const dia = fechaObj.getDate().toString().padStart(2, '0');
            const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
            const año = fechaObj.getFullYear();
            const horas = fechaObj.getHours().toString().padStart(2, '0');
            const minutos = fechaObj.getMinutes().toString().padStart(2, '0');

            return `${dia}/${mes}/${año} ${horas}:${minutos}h`;
        },
        filtrarItems() {
            const textoBusqueda = this.filtro.toLowerCase();
            this.itemsFiltrados = this.listaItems.filter(item => {
                const tituloIncluyeTexto = item.title.toLowerCase().includes(textoBusqueda);
                if (this.mostrar == 0) {
                    return tituloIncluyeTexto;
                } else if (this.mostrar == 1) {
                    return tituloIncluyeTexto && item.media_type === 'tv';
                } else if (this.mostrar == 2) {
                    return tituloIncluyeTexto && item.media_type === 'movie';
                }
            });
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
    mounted(){
        const id_usuario = this.$cookies.get('id_usuario');
        const access_token = this.$cookies.get('access_token') // 

        if(id_usuario){
            this.idUsuario = id_usuario;

            if(access_token){
                this.access_token = access_token;
            }
        }

        this.idLista = this.$route.params.id;
        this.getLista();
        this.getListaItems();
    }
}
</script>

<style scoped>

.title{
    color: whitesmoke;
}

.custom-shadow{
    box-shadow: black 0px 0px 5px;
}



</style>

<style>

.autocomplete .control{
    width: 100%;
}
.bg-gris{
    background-color: #ededed !important;
}
</style>