<template>
    <div class="btn-crear-lista">

        <b-button @click="isModalEditarLista = true" icon-pack="fas" icon-left="pen-to-square" type="is-dark is-small" rounded title="Editar lista">Editar</b-button>

                    <b-modal
                        v-model="isModalEditarLista"
                        has-modal-card
                        trap-focus
                        :destroy-on-hide="false"
                        aria-role="dialog"
                        aria-label="Crear Lista"
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
                                    <b-button native-type="submit" type="is-primary" expanded>Editar</b-button>
                                </section>
                            </div>
                        </form>

                    </b-modal>

    </div>
</template>

<script>
  
  import axios from 'axios';

  //const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
  
  export default {
    name: 'BtnEditarLista',
    props: {
      lista: {
        type: Object,
        required: true
      },
      access_token:{
        type: String,
        required: false,
      }
    },
    data() {
        return {
            apiUrlv4: 'https://api.themoviedb.org/4',
            language: 'es',
            
            isModalEditarLista: false,
            editarListaTitulo: null,
            editarListaDescripcion: null,
            editarListaPrivacidad: "0"
        }
    },
    mounted(){
        if(this.lista){
            this.editarListaTitulo = this.lista.titulo;
            this.editarListaDescripcion = this.lista.descripcion;
            this.editarListaPrivacidad = this.lista.privacidad;
        }
    },
    methods: {
        editarLista(){
            const data = {
                id: this.lista.id,
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
                console.log(response.data);

                if(!response.data.includes('Error')) {
                    console.log("Exito");

                    if (this.access_token && this.lista.id_tmdb) {
                        this.editarListaTMDB();
                    }

                    ///emitir el cambio
                    this.$emit('listaEditada', true);

                    this.$swal({
                        title: 'Lista modificada exitosamente',
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
                    
                    this.isModalEditarLista = false;
            })
            .catch(error => console.log(error));
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
    }
  };
  </script>