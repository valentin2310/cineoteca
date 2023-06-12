<template>
    <div class="btn-crear-lista">

        <b-button @click="isModalCrearLista = true" icon-pack="fas" icon-left="plus" type="is-success">Crear Lista</b-button>

                    <b-modal
                        v-model="isModalCrearLista"
                        has-modal-card
                        trap-focus
                        :destroy-on-hide="false"
                        aria-role="dialog"
                        aria-label="Crear Lista"
                        close-button-aria-label="Close"
                        aria-modal
                    >
                        <form @submit.prevent="crearLista">
                            <div class="modal-card" style="width: 320px">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Crear Lista</p>
                                </header>
                                <section class="modal-card-body">
                                    <b-field label="Titulo">
                                        <b-input
                                            type="text"
                                            v-model="crearListaTitulo"
                                            placeholder="El titulo de tu nueva lista.."
                                            maxlength="25"
                                            minlength="4"
                                            required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Privacidad">
                                        <div class="block">
                                            <b-radio
                                                v-model="crearListaPrivacidad"
                                                name="name"
                                                native-value="0"
                                            >
                                            <i class="fa-solid fa-lock"></i> Privada
                                            </b-radio>
                                            <b-radio
                                                v-model="crearListaPrivacidad"
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
                                            v-model="crearListaDescripcion"
                                            maxlength="120"
                                            placeholder="Pon una descripcion sobre tu lista..">
                                        </b-input>
                                    </b-field>
                                    <b-button native-type="submit" type="is-primary" expanded>Crear</b-button>
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
    name: 'BtnCrearLista',
    props: {
      creadorId: {
        type: String,
        required: true
      },
      access_token: {
        type: String,
        required: false,
      }
    },
    data() {
        return {
            apiUrlv4: 'https://api.themoviedb.org/4',
            language: 'es',
            
            isModalCrearLista: false,
            crearListaTitulo: '',
            crearListaDescripcion: '',
            crearListaPrivacidad: "0",
        }
    },
    methods: {
        async crearLista(){
            let id_tmdb = null;

            if (this.access_token) {
                try {
                    id_tmdb = await this.crearListaTMDB();

                    
                } catch (error) {
                    console.log(error);
                    this.$swal(error.response.data.errors[0], '', 'error');
                }
            }

            this.crearListaPHP(id_tmdb);
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

                if(!response.data.includes('Error')) {

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