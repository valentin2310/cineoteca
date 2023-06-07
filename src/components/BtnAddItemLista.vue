<template>
    <div class="btn-add-item-lista">

        <b-button type="is-info is-light" title="Añadir a una lista" class="rounded-circle" icon-pack="fas" icon-left="list" @click="isModal = true"></b-button>

                    <b-modal
                        v-model="isModal"
                        has-modal-card
                        trap-focus
                        :destroy-on-hide="false"
                        aria-role="dialog"
                        aria-label="Crear Lista"
                        close-button-aria-label="Close"
                        aria-modal
                    >
                        <form @submit.prevent="addItemLista">
                            <div class="modal-card" style="width: 320px">
                                <header class="modal-card-head">
                                    <p class="text-black fs-5 fw-bold">Añade {{ item.title?item.title:item.name }} a una lista</p>
                                </header>
                                <section class="modal-card-body">
                                    
                                    <b-button tag="router-link" to="/perfil">Crear lista</b-button>

                                    <b-field :label="`Añade la ${item.media_type=='tv'?'serie':'pelicula'} a una lista`">
                                        <b-taginput
                                            v-model="listasSeleccionadas"
                                            :data="listas"
                                            autocomplete
                                            :allow-new="false"
                                            :open-on-focus="true"
                                            field="titulo"
                                            icon-pack="fas"
                                            icon="list"
                                            placeholder="Selecciona una lista..">
                                        </b-taginput>
                                    </b-field>


                                    <b-button native-type="submit" type="is-primary" expanded>Aceptar</b-button>
                                </section>
                            </div>
                        </form>

                    </b-modal>

    </div>
</template>

<script>
  
  import axios from 'axios';

  //const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  //const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";
  
  export default {
    name: 'BtnAddItemLista',
    props: {
      idUsuario: {
        type: String,
        required: true,
      },
      item: {
        type: Object,
        required: true,
      }
    },
    data() {
        return {
            apiUrlv4: 'https://api.themoviedb.org/4',
            language: 'es',

            access_token: null,
            
            isModal: false,
            listas: [],
            listasSeleccionadas: [],
        }
    },
    mounted() {
        this.getListasUsuario();
    },
    methods: {
        async crearLista(){
            let id_tmdb = null;

            if (this.access_token) {
                try {
                    id_tmdb = await this.crearListaTMDB();
                    console.log("El id de la lista tmdb: " + id_tmdb);

                    
                } catch (error) {
                    console.log(error);
                    this.$swal(error.response.data.errors[0], '', 'error');
                }
            }

            this.crearListaPHP(id_tmdb);
        },
        getListasUsuario() {
            const data = {
                id_creador: this.idUsuario,
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getListasUsuario.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(typeof response.data === "object" && response.data !== null) {
                    console.log("Exito");
                    this.listas = response.data;
                }

            })
            .catch(error => console.log(error));
        },
        crearListaPHP(id_tmdb){
            const data = {
                id_creador: this.creadorId,
                titulo: this.crearListaTitulo,
                descripcion: this.crearListaDescripcion,
                privacidad: this.crearListaPrivacidad,
                id_tmdb: id_tmdb
            }
            axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/crearLista.php`, data, {
                headers: {
                "Content-Type": "application/json",
                },
            }
            )
            .then(response => {
                console.log(response.data);

                if(!response.data.includes('Error')) {
                    console.log("Exito");

                    ///emitir el cambio
                    this.$emit('listaCreada', true);

                    this.$swal({
                        title: 'Lista creada exitosamente',
                        icon: 'success',
                        position: 'top-end',
                        showConfirmaButton: false,
                        timer: 1200
                    })
                    }else{
                        this.$swal({
                            title: response.data,
                            icon: 'error',
                            position: 'top-end',
                            showConfirmaButton: false,
                            timer: 1200
                        })
                    }
                    
                    this.isModalCrearLista = false;
            })
            .catch(error => console.log(error));
        },
        async crearListaTMDB(){
            const options = {
                method: 'POST',
                url: `${this.apiUrlv4}/list`,
                headers: {
                    accept: 'application/json',
                    'content-type': 'application/json',
                    Authorization: `Bearer ${this.access_token}`
            },
            data: {
                description: this.crearListaDescripcion,
                name: this.crearListaTitulo,
                iso_639_1: this.language,
                public: this.crearListaPrivacidad?false:true
            }
            };

            let id_tmdb = null; // Variable auxiliar para almacenar el ID

            try {
                const response = await axios.request(options);
                console.log(response.data);
                id_tmdb = response.data.id; // Asignar el ID a la variable auxiliar
            } catch (error) {
                console.error(error);
                throw error; // Lanzar el error para que sea capturado por el bloque catch en crearLista()
            }

                return id_tmdb; // Devolver el ID
            }
    }
  };
  </script>