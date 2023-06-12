<template>
    <div class="listaUsuario">

        
        <div v-if="lista" class="lista rounded custom-shadow my-2 p-3 bg-dark text-white" v-bind:style="{
                'background-image': lista.backdrop_path?`linear-gradient(52deg, rgba(0,0,0,0.94) 29%, rgba(61,61,61,0.5) 100%), url(https://image.tmdb.org/t/p/original/${lista.backdrop_path})`:'',
                'background-size': 'cover',
                'background-repeat': 'no-repeat',
                'background-position': 'center center'
            }">
          
            <div v-if="idUsuario == lista.id_creador" class="lista-menu float-end">
              <b-dropdown :triggers="['hover']" aria-role="list">
                <template #trigger>
                  <i class="fa-solid fa-ellipsis shadow bg-transparente p-2 rounded"></i>
                </template>
                          
                
                <b-dropdown-item aria-role="listitem" @click="isModalEditarLista = true"><i class="fa-solid fa-pen-to-square"></i> Editar detalles</b-dropdown-item>
                <b-dropdown-item aria-role="listitem" @click="alertDeleteLista"><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</b-dropdown-item>
              </b-dropdown>

              <b-modal
                  v-model="isModalEditarLista"
                  has-modal-card
                  trap-focus
                  :destroy-on-hide="false"
                  aria-role="dialog"
                  aria-label="Editar Lista"
                  close-button-aria-label="Close"
                  aria-modal
              >
                  <form @submit.prevent="editarLista">
                      <div class="modal-card" style="width: 320px">
                          <header class="modal-card-head">
                              <p class="modal-card-title">Editar Lista</p>
                          </header>
                          <section class="modal-card-body">
                              <b-field label="Titulo">
                                  <b-input
                                      type="text"
                                      v-model="editarListaTitulo"
                                      placeholder="El titulo de tu nueva lista.."
                                      maxlength="25"
                                      minlength="4"
                                      required>
                                  </b-input>
                              </b-field>
                              <b-field label="Privacidad">
                                <div class="block text-dark">
                                    <b-radio
                                        v-model="editarListaPrivacidad"
                                        name="name"
                                        native-value="0"
                                    >
                                    <i class="fa-solid fa-lock"></i> Privada
                                    </b-radio>
                                    <b-radio
                                        v-model="editarListaPrivacidad"
                                        name="name"
                                        native-value="1"
                                    >
                                    <i class="fa-solid fa-earth-americas"></i> Pública
                                    </b-radio>
                                </div>
                            </b-field>
                              <b-field label="Descripcion">
                                  <b-input
                                      type="textarea"
                                      v-model="editarListaDescripcion"
                                      maxlength="120"
                                      placeholder="Pon una descripcion sobre tu lista..">
                                  </b-input>
                              </b-field>
                              <b-button native-type="submit" type="is-primary" expanded>Guardar</b-button>
                          </section>
                      </div>
                  </form>

              </b-modal>
            </div>
          
            <router-link :to="`/listas/${idLista}`" class="router-link-reset">
                <div class="titulo d-flex flex-row flex-wrap align-items-center">
                    <span class="d-flex flex-row flex-nowrap">
                        <span class="fw-bold fs-3">
                            {{ lista.titulo }}
                        </span>
                        <b-icon v-if="lista.id_tmdb" class="ms-1" size="is-small" type="is-info" pack="fas" icon="cloud" title="Esta sincronizado con tmdb"></b-icon>
                    </span>
                </div>

                <div class="text-white-50">
                    <div class="text-white-50 ms-2 fs-6 mb-0">
                        <span v-if="lista.privacidad == 0"> <i class="fa-solid fa-lock"></i> Privada</span>
                        <span v-else><i class="fa-solid fa-earth-americas"></i> Pública</span>
                        <span class="ms-1">({{ listaItems.length }} items)</span>
                    </div>
                    <span>Ultima modificacion: {{ lista.fecha_modificacion }}</span>
                </div>

                
            </router-link>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
//import SerieCard2 from '@/components/SerieCard2.vue';

export default {
  name: 'ListaUsuario',
  components: {
    //SerieCard2,
  },
  props: {
    idLista: {
      type: String,
      required: true,
    },
    idUsuario: {
      type: String,
      required: true,
    },
    access_token: {
        type: String,
        required: false,
    }
  },
  data() {
    return {
      lista: {},
      listaItems: {},

      apiUrlv4: 'https://api.themoviedb.org/4',
      language: 'es',

      isModalEditarLista: false,
      editarListaTitulo: null,
      editarListaDescripcion: null,
      editarListaPrivacidad: "0"
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

              if(typeof response.data === "object" && response.data !== null) {
                  this.lista = response.data;
                  this.editarListaTitulo = this.lista.titulo;
                  this.editarListaDescripcion = this.lista.descripcion;
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

                if(typeof response.data === "object" && response.data !== null) {
                    this.listaItems = response.data;
                }

            })
            .catch(error => console.log(error));
      },
      editarLista(){
        const data = {
              id: this.idLista,
              titulo: this.editarListaTitulo,
              descripcion: this.editarListaDescripcion,
              privacidad: this.editarListaPrivacidad
          }
          axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/modificarLista.php`, data, {
              headers: {
              "Content-Type": "application/json",
              },
          }
          )
          .then(response => {

              if(!response.data.includes('Error')) {

                if (this.access_token && this.lista.id_tmdb) {
                    this.editarListaTMDB();
                }

                this.getLista();

                this.isModalEditarLista = false;
              }

          })
          .catch(error => console.log(error));
      },
      alertDeleteLista(){
        this.$swal({
            title: `Estas seguro que quieres eliminar la lista ${this.lista.titulo}?`,
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
                this.deleteLista();
            } 
        })
      },
      deleteLista(){
        const data = {
                id: this.idLista,
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarLista.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {

                if(!response.data.includes('Error')) {

                    if(this.access_token && this.lista.id_tmdb){
                        this.deleteListaTMDB();
                    }

                    //Ocultar esta lista
                    this.lista = null;
                }

            })
            .catch(error => console.log(error));
      },
      async deleteListaTMDB(){
        const options = {
            method: 'DELETE',
            url: `${this.apiUrlv4}/list/${this.lista.id_tmdb}`,
            headers: {
                accept: 'application/json',
                'content-type': 'application/json',
                Authorization: `Bearer ${this.access_token}`
        },
        };

        await axios
            .request(options)
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.error(error);
                this.$swal(error.response.data.status_message, '', 'error')
            });
        },
        editarListaTMDB(){
            const options = {
                method: 'PUT',
                url: `${this.apiUrlv4}/list/${this.lista.id_tmdb}`,
                headers: {
                    accept: 'application/json',
                    'content-type': 'application/json',
                    Authorization: `Bearer ${this.access_token}`
            },
            data: {
                description: this.editarListaDescripcion,
                name: this.editarListaTitulo,
                iso_639_1: this.language,
                public: this.editarListaPrivacidad == "0" ?false:true
            }
            };

            axios
                .request(options)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.error(error);
                    //this.$swal(error.response.data.status_message, '', 'error')
                });
        }
  },
  mounted() {
    this.getLista();
    this.getListaItems();
  }
};

</script>

<style scoped>

.lista-add{
    height: 200px;
}
.descripcion{
    border-left: 5px solid white;
    padding-left: 5px;
}

.bg-transparente{
    background-color: rgba(0, 0, 0, 0.15);
}

.router-link-reset {
  color: inherit;
  text-decoration: none;
  /* Otros estilos personalizados */
}


</style>