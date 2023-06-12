<template>
<div class="perfil-configuracion mb-5 pb-5">

    <div v-if="usuarioObj">
            
            <b-row id="banner" class="mx-0" v-bind:style="{
                'background-image': usuarioObj.img_fondo?`linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,8) 100%), url(https://image.tmdb.org/t/p/original/${usuarioObj.img_fondo})`:'',
                'background-color': '#17202A',
                'background-size': 'cover',
                'background-repeat': 'no-repeat',
                'background-position': 'center center'
            }">

                <div class="editar-fondo">
                    <ModalBuscadorImg @img="cambiarFondo">
                        <b-button type="is-primary is-light" size="is-small" class="float-end m-2 rounded-circle shadow" title="Editar el fondo" icon-pack="fas" icon-left="camera-rotate"></b-button>
                    </ModalBuscadorImg>
                </div>

                <b-col class="banner-usuario text-white has-text-centered">
                    <div class="hero-body has-text-centered mx-5 py-3 d-flex flex-column align-items-center justify-content-center">
                      <b-icon pack="fas" icon="gear" size="is-large" type="is-primary"></b-icon>
                      <span class="fs-2 fw-bold is-primary-color">
                        CONFIGURACIÓN
                      </span>
                    </div>
                    
                </b-col>
                
            </b-row>
            
            <b-tabs type="" expanded class="menu-tabs">

                <b-tab-item label="Datos" icon-pack="fas" icon="chart-line">
                        
                        
                    <h2 class="title is-2 border-custom border-custom-color-1">Datos del Perfil</h2>
                    
                    <div class="datos-perfil">

                        <b-row class="w-100 my-2 has-text-centered fs-5">
                            <b-col sm="12" class="my-2">
                                <b-button @click="isModalEditarUsuario = true" type="is-primary is-light" class="fw-bold fs-5" rounded>Editar usuario</b-button>
                            </b-col>
                            <b-col sm="12"><span class="fw-bold">Nombre completo: </span>{{ usuarioObj.nombre }}</b-col>
                            <b-col sm="12"><span class="fw-bold">Nombre de usuario: </span>{{ usuarioObj.usuario }}</b-col>
                            <b-col sm="12"><span class="fw-bold">Fecha de nacimiento: </span>{{ obtenerFecha(usuarioObj.fecha_nac) }}</b-col>
                            <b-col sm="12">
                                <span class="fw-bold">Sexo: </span>
                                <span v-if="usuarioObj.sexo == 0" class="usuario-sexo">Masculino <b-icon pack="fas" icon="mars"></b-icon></span>
                                <span v-if="usuarioObj.sexo == 1" class="usuario-sexo">Femenino <b-icon pack="fas" icon="venus"></b-icon></span>
                                <span v-if="usuarioObj.sexo == 2" class="usuario-sexo">Otro <b-icon pack="fas" icon="genderless"></b-icon></span>
                            </b-col>
                            <b-col sm="12"><span class="fw-bold">Imagen de avatar: </span></b-col>
                            <b-col sm="12" class="my-2">
                                <ModalBuscadorImg @img="cambiarAvatar" :usuarioTMDB="usuarioTMDB?usuarioTMDB:null">
                                    <div class="m-0 p-0" @mouseover="isHoverAvatar = true" @mouseleave="isHoverAvatar = false">
                                        <b-avatar v-if="usuarioObj.img_avatar" :src="urlImg+usuarioObj.img_avatar" size="9em" class="usuario-img">
                                            <div v-if="isHoverAvatar" class="fs-4 fw-bold text-white-50 d-flex flex-column align-items-center">
                                                Editar avatar 
                                                <b-icon class="mt-2" pack="fas" icon="camera-rotate"></b-icon>
                                            </div>
                                        </b-avatar>
                                        <b-avatar v-else size="9em" class="usuario-img">
                                            <div v-if="isHoverAvatar" class="fs-4 fw-bold text-white-50 d-flex flex-column align-items-center">
                                                Editar avatar 
                                                <b-icon class="mt-2" pack="fas" icon="camera-rotate"></b-icon>
                                            </div>
                                        </b-avatar>
            
                                    </div>
                                </ModalBuscadorImg>
                            </b-col>
                            <b-col sm="12"><span class="fw-bold">Fecha de creación: </span>{{ obtenerFecha(usuarioObj.fecha_alta) }}</b-col>
                            <b-col sm="12"><span class="fw-bold">Sincronizado con TMDB?: </span>{{ usuarioTMDB?'Si':'No' }}</b-col>

                        </b-row>

                    </div>
                    
                    
                </b-tab-item>
                
                <b-tab-item  label="Contraseña" icon-pack="fas" icon="hourglass-half">
                    
                    <h2 class="title is-2 border-custom border-custom-color-4">Contraseña</h2>

                    <div class="contraseña">

                        <b-message type="is-info" has-icon icon-pack="fas">
                            <p>¡Bienvenido! Estás en la sección de cambio de contraseña. Sabemos lo importante que es mantener tus datos seguros, por eso hemos implementado 
                                este proceso de cambio de contraseña.</p>
                            <p>Para poder realizar el cambio, necesitarás conocer tu contraseña actual. Esto es importante para garantizar que solo tú, como titular de 
                                la cuenta, puedas modificarla.</p>
                            <p>Por seguridad, te pediremos que ingreses la nueva contraseña dos veces para confirmarla. Esto evita posibles errores al momento de 
                                escribirla y te brinda la certeza de que la nueva contraseña ha sido ingresada correctamente.</p>
                        </b-message>

                        <h4 class="fs-4 fw-bold is-primary-color has-text-centered">Cambio de contraseña</h4>

                        <form @submit.prevent="cambiarPassword" method="POST">
                            <div class="p-5 d-flex flex-column align-items-center justify-content-center">
                                <b-field label="Tu Contraseña" type="is-primary">
                                    <b-input 
                                      v-model="password"
                                      type="password"
                                      password-reveal
                                      maxlength="30"
                                      minlength="5"
                                      icon-pack="fas"
                                      required
                                      icon="key"
                                      validation-message="La contraseña tiene un formato inválido, debe contener mínimo una letra y un número"
                                      patter="[A-Za-zÑñ0-9_#.]{5,30}"
                                    >
                                    </b-input>
                                </b-field>
                                <b-field label="Introduce tu nueva Contraseña" type="is-primary">
                                    <b-input 
                                      v-model="password_edit"
                                      type="password"
                                      password-reveal
                                      maxlength="30"
                                      minlength="5"
                                      icon-pack="fas"
                                      required
                                      icon="key"
                                      validation-message="La contraseña tiene un formato inválido, debe contener mínimo una letra y un número"
                                      patter="[A-Za-zÑñ0-9_#.]{5,30}"
                                    >
                                    </b-input>
                                </b-field>
                                <b-field label="Repite tu nueva Contraseña" type="is-primary">
                                    <b-input 
                                      v-model="password2_edit"
                                      type="password"
                                      password-reveal
                                      maxlength="30"
                                      minlength="5"
                                      icon-pack="fas"
                                      required
                                      icon="key"
                                      validation-message="La contraseña tiene un formato inválido, debe contener mínimo una letra y un número"
                                      patter="[A-Za-zÑñ0-9_#.]{5,30}"
                                    >
                                    </b-input>
                                </b-field>
                                <b-button native-type="submit" icon-pack="fas" icon-left="thumbs-up" type="is-primary">Confirmar</b-button>
                            </div>
                        </form>

                    </div>
                    
                </b-tab-item>
                
                
            </b-tabs>


             <!-- modal editar usuario -->
            <b-modal
                v-model="isModalEditarUsuario"
                has-modal-card
                trap-focus
                :destroy-on-hide="false"
                aria-role="dialog"
                aria-label="Editar Usuario"
                close-button-aria-label="Close"
                aria-modal
            >
                <form @submit.prevent="editarUsuario">
                    <div class="modal-card" style="max-width: 400px;">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Editar Usuario</p>
                        </header>
                        <section class="modal-card-body">
                            <b-field label="Usuario" type="is-primary">
                                <b-input 
                                  v-model="username_edit"
                                  maxlength="20"
                                  minlenght="5"
                                  validation-message="El usuario debe tener entre 5 y 20 letras y numeros"
                                  pattern="[A-Za-zÑñ0-9_]{5,20}"
                                  required
                                  icon-pack="fas"
                                  icon="user"
                                >
                                </b-input>
                            </b-field>
                            <b-field label="Nombre completo" type="is-primary">
                                <b-input 
                                  v-model="nombre_edit"
                                  maxlength="30"
                                  required
                                  icon-pack="fas"
                                  icon="user-pen"
                                  validation_message="Tu nombre no es válido, solo se permiten letras y espacios"
                                  pattern="[A-Za-zÑñ]{3}[A-Za-zÑñ ]{0,27}"
                                >
                                </b-input>
                            </b-field>

                            <b-field label="Sexo" type="primary"></b-field>
                              <div class="block">
                                <b-radio v-model="sexo_edit" name="name" native-value="0">
                                  Hombre
                                </b-radio>
                                <b-radio v-model="sexo_edit" name="name" native-value="1">
                                  Mujer
                                </b-radio>
                                <b-radio v-model="sexo_edit" name="name" native-value="2">
                                  Otro
                                </b-radio>
                              </div>
                            <b-field label="Fecha nacimiento">
                                <b-datepicker
                                    v-model="fecha_edit"
                                    placeholder="Click para seleccionar..."
                                    icon-pack="fas"
                                    icon="calendar"
                                    icon-right="close-circle"
                                    @icon-right-clickable="clearDate"
                                    :min-date="minDate"
                                    :max-date="maxDate">
                                </b-datepicker>
                            </b-field>
                            <div class="btnLogin my-5">
                                <b-button native-type="submit" type="is-primary" class="fw-bold py-2 w-50">Guardar Cambios</b-button>
                                <b-button @click="isModalEditarUsuario = false" class="fw-bold bg-secondary text-white py-2 w-50">Cancelar</b-button>
                            </div>
                        </section>
                    </div>
                </form>
            </b-modal>

        </div>

</div>
</template>

<script>
import axios from 'axios';
//import PantallaItems from '@/components/PantallaItems.vue';
import ModalBuscadorImg from '@/components/ModalBuscadorImg.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
//const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

const today = new Date();

export default {
    data() {
        return  {
            id_usuario: null,
            usuarioObj: null,
            usuarioTMDB: null,

            estadisticas: {},
            listasCreadas: {},
            listaFavoritos: [],
            
            sessionId: null,
            access_token: null,
            apiUrl: 'https://api.themoviedb.org/3',        
            urlImg: 'https://image.tmdb.org/t/p/w500',

            mostrar: "0",
            elegirOpcionBuscar: false,
            elegirOpcionEliminar: false,

            isHoverAvatar: false,
            isModalEditarUsuario: false,
            isModalBuscarImg: false,

            username_edit: null,
            nombre_edit: null,
            sexo_edit: "2",
            fecha_edit: null,

            
            minDate: new Date(today.getFullYear() - 120, today.getMonth(), today.getDate()),
            maxDate: new Date(today.getFullYear() - 5, today.getMonth(), today.getDate()),
        }
    },
    components: {
        ModalBuscadorImg
},
    methods: {
      getDatosUsuario() {
          const data = {
              id: this.id_usuario,
          }
          axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getUsuario.php`, data, {
              headers: {
              "Content-Type": "application/json",
              },
          }
          )
          .then(response => {
              console.log(response.data);

              if(typeof response.data === "object" && response.data !== null) {
                  console.log("Exito");
                  this.usuarioObj = response.data;

                  this.username_edit = this.usuarioObj.usuario;
                  this.nombre_edit = this.usuarioObj.nombre;
                  this.sexo_edit = this.usuarioObj.sexo;
                  this.fecha_edit = new Date(this.usuarioObj.fecha_nac);
              }

          })
          .catch(error => console.log(error));
      },
      getDatosUsuarioTMDB(){
          axios.get(`${this.apiUrl}/account`, {
              params: {
              api_key: API_KEY,
              session_id: this.sessionId
              }
          })
          .then(response => {
              
              this.usuarioTMDB = response.data;
              console.log("Usuario:");
              console.log(this.usuarioTMDB);

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
      editarUsuario() {
        const data = {
            id: this.id_usuario,
            nombre: this.nombre_edit,
            usuario: this.username_edit,
            sexo: this.sexo_edit,
            fecha_nac: this.fecha_edit
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/editUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response.data);

          if(!response.data.includes('Error')) {
            console.log("Exito");

            this.$buefy.notification.open({
                message: 'Los datos se han modificado exitosamente :)',
                type: 'is-success',
                'icon-pack': 'fas',
                position: 'is-top-right'
            })

            this.getDatosUsuario();
            this.isModalEditarUsuario = false;

          }else{
            this.notifError(response.data);
          }

        })
        .catch(error => console.log(error));
    },
    cambiarPassword() {
        const data = {
            id: this.id_usuario,
            password_old: this.password,
            password_new: this.password_edit,
            password2_new: this.password2_edit
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/cambiarPasswordUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response.data);

          if(!response.data.includes('Error')) {
            console.log("Exito");

            this.$buefy.notification.open({
                message: 'La contraseña se ha modificado exitosamente :)',
                type: 'is-success',
                'icon-pack': 'fas',
                position: 'is-top-right'
            })

            this.password = '';
            this.password_edit = '';
            this.password2_edit = '';
            location.reload();

          }else{
            this.notifError(response.data);
          }

        })
        .catch(error => console.log(error));
    },
    cambiarAvatar(img){
        const data = {
            id: this.id_usuario,
            img: img
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/cambiarAvatarUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response.data);

          if(!response.data.includes('Error')) {
            console.log("Exito");

            this.$buefy.notification.open({
                message: 'Los datos se han modificado exitosamente :)',
                type: 'is-success',
                'icon-pack': 'fas',
                position: 'is-top-right'
            })

            this.getDatosUsuario();
            this.isModalEditarUsuario = false;

          }else{
            this.notifError(response.data);
          }

        })
        .catch(error => console.log(error));
    },
    cambiarFondo(img){
        const data = {
            id: this.id_usuario,
            img: img
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/cambiarFondoUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response.data);

          if(!response.data.includes('Error')) {
            console.log("Exito");

            this.$buefy.notification.open({
                message: 'Los datos se han modificado exitosamente :)',
                type: 'is-success',
                'icon-pack': 'fas',
                position: 'is-top-right'
            })

            this.getDatosUsuario();
            this.isModalEditarUsuario = false;

          }else{
            this.notifError(response.data);
          }

        })
        .catch(error => console.log(error));
    },
    clearDate() {
      this.fecha_reg = null;
    },
    notifError(error){
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
        'icon-pack': 'fas',
        position: 'is-top-right',
        indefinite: true
      })
    }
      
    },
    mounted () {
      const id_usuario = this.$cookies.get('id_usuario');
      const sessionId = this.$cookies.get('sessionId') // 
      const access_token = this.$cookies.get('access_token') // 

      if(id_usuario){
          this.id_usuario = id_usuario;
          this.getDatosUsuario();

          // comprobar si tengo acceso a la cuenta de TMDB
          if (sessionId && access_token) {
      
              this.sessionId = sessionId;
              this.access_token = access_token;
      
              //mostrar info del usuario
              this.getDatosUsuarioTMDB();

          }

      }

    },
}

</script>

<style scoped>

#banner {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 40vh;
}
.is-primary-color{
    color: blueviolet;
}

.usuario-img{
    box-shadow: black 0px 0px 5px;
    background-color: black;
}
.usuario-img:hover{
    cursor: pointer;
}
.banner-usuario{
    display: flex;
    flex-flow: row wrap;
    padding: 0px 15%;
}
.banner-usuario div{
    display: flex;
    flex-flow: row wrap;
    align-items: flex-end;
    padding: 5px;
    margin: 0px 10px;
}
.menu-tabs{
  padding: 30px 12% 0px 12% !important;
  margin-top: 20px;
}
.border-custom{
    font-size: 1.6rem;
	display: grid;
	place-items: center;
	border: 8px solid;
	padding: 1rem;
}
.border-custom-color-1{
    border-image: linear-gradient(to left, aqua, blueviolet) 0 0 1 0;
}
.border-custom-color-2{
    border-image: linear-gradient(to left, whitesmoke, black) 0 0 1 0;
}
.border-custom-color-3{
    border-image: linear-gradient(to left, cyan, greenyellow) 0 0 1 0;
}
.border-custom-color-4{
    border-image: linear-gradient(to left, red, blueviolet) 0 0 1 0;
}
.border-custom-color-5{
    border-image: linear-gradient(to left, blue, blueviolet) 0 0 1 0;
}

@media (max-width: 745px) {
    .menu-tabs{
      margin-top: 2px;
    }
    .span-miembro{
        display: none;
    }
    .banner-usuario{
        padding: 0;
    }
    .menu-tabs{
        padding: 30px 20px 0px 20px !important;
    }

    #banner{
        height: 55vh;
    }
}

@media (max-width: 400px) {
    .menu-tabs{
        padding: 30px 5px 0px 5px !important;
    }
    #banner{
        height: auto;
    }
}

</style>