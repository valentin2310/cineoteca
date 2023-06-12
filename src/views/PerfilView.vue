<template>
    <div class="perfil-view">

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

                <b-col class="banner-usuario text-start">
                    
                    <div class="text-white">

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

                        <div class="info-usuario">
                            <p>
                                <span v-if="usuarioObj.sexo == 0" class="usuario-sexo"><b-icon pack="fas" icon="mars"></b-icon></span>
                                <span v-if="usuarioObj.sexo == 1" class="usuario-sexo"><b-icon pack="fas" icon="venus"></b-icon></span>
                                <span v-if="usuarioObj.sexo == 2" class="usuario-sexo"><b-icon pack="fas" icon="genderless"></b-icon></span>
                              <span class="usuario-nombre fw-bold">{{ capitalizarPrimeraLetra(usuarioObj.nombre) }}</span>
                              <span class="usuario-username fw-bold text-white-50"> @{{ usuarioObj.usuario }}</span>
                              <b-button type="is-primary is-light" size="is-small" class="rounded-circle ms-2 shadow" title="Editar usuario" icon-pack="fas" icon-left="pen-to-square" @click="isModalEditarUsuario = true"></b-button>
                            </p>
                            <p><span class="span-miembro">Miembro desde: </span>{{ obtenerFecha(usuarioObj.fecha_alta) }}</p>
                            
                           
                        </div>
                        
                    </div>
                    
                </b-col>
                
            </b-row>
            
            <b-tabs type="" expanded class="menu-tabs">

                <b-tab-item label="Estadisticas" icon-pack="fas" icon="chart-line">
                        
                        
                    <h2 class="title is-2 border-custom border-custom-color-1">Estadisticas</h2>
                    
                    <div class="estadisticas text-white-50">
                        
                        <div class="tiempo-eps apartado text-center">
                            Tiempo de episodios
                            <div class="valor-tiempo">
                                <div class="dias">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_episodios).dias }}
                                    </span>
                                    Días
                                </div>
                                <div class="horas">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_episodios).horas }}
                                    </span>
                                    Horas
                                </div>
                                <div class="minutos">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_episodios).minutos }}
                                    </span>
                                    Minutos
                                </div>
                            </div>
                        </div>
    
                        <div class="num-eps apartado text-center">
                            Número de episodios
                            <span>
                                {{ estadisticas.cantidad_episodios_vistos }}
                            </span>
                        </div>
                        
                        <div class="tiempo-pel apartado text-center">
                            Tiempo de peliculas
                            <div class="valor-tiempo">
                                <div class="dias">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_peliculas).dias }}
                                    </span>
                                    Días
                                </div>
                                <div class="horas">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_peliculas).horas }}
                                    </span>
                                    Horas
                                </div>
                                <div class="minutos">
                                    <span>
                                        {{ convertirMinutosDHM(estadisticas.tiempo_visto_peliculas).minutos }}
                                    </span>
                                    Minutos
                                </div>
                            </div>
                        </div>
    
                        <div class="num-pel apartado text-center">
                            Número de peliculas
                            <span>
                                {{ estadisticas.cantidad_peliculas_vistas }}
                            </span>
                        </div>
                                            
                    </div>
                    
                </b-tab-item>
                
                <b-tab-item  label="Historial" icon-pack="fas" icon="hourglass-half">
                    
                    <h2 class="title is-2 border-custom border-custom-color-2">Historial</h2>

                    <div class="historial">

                        <!--

                        -->
                        <PantallaEpisodios :episodios="listaEpisodiosVistos"></PantallaEpisodios>
                        <b-pagination
                            @change="getEpisodiosUsuario()"
                            :total="estadisticas.cantidad_episodios_vistos"
                            v-model="pagina_episodios"
                            range-before="2"
                            range-after="1"
                            order="is-centered"
                            size="default"
                            :simple="false"
                            :rounded="true"
                            :per-page="50"
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
                    
                </b-tab-item>
                
                <b-tab-item id="listas"  label="Listas" icon-pack="fas" icon="list">
                    
                    <h2 class="title is-2 border-custom border-custom-color-3">Listas</h2>
                    
                    <!--
                        btncrearlista.vue
                    -->
                    <BtnCrearLista v-if="usuarioTMDB" @listaCreada="crearLista" :creadorId="id_usuario" :access_token="access_token"></BtnCrearLista>
                    <BtnCrearLista v-else @listaCreada="crearLista" :creadorId="id_usuario"></BtnCrearLista>

                    <div v-if="listasCreadas" class="listas">
                        <div  v-for="lista in listasCreadas" :key="lista.id">
                            <ListaUsuario v-if="usuarioTMDB" :idLista="lista.id" :idUsuario="id_usuario" :access_token="access_token"/>
                            <ListaUsuario v-else :idLista="lista.id" :idUsuario="id_usuario"/>
                        </div>
                    </div>
                    <div v-else class="listas">No has creado ninguna lista aún...</div>
                    
                </b-tab-item>
                
                <b-tab-item  label="Favoritos" icon-pack="fas" icon="heart">
                    
                    <h2 class="title is-2 border-custom border-custom-color-4">Favoritos</h2>

                    <FiltroPantallaLista :listaItems="listaFavoritos"></FiltroPantallaLista>

                </b-tab-item>

                <b-tab-item  label="Valoraciones" icon-pack="fas" icon="star">

                    <h2 class="title is-2 border-custom border-custom-color-5">Valoraciones</h2>

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
import ListaUsuario from '@/components/ListaUsuario.vue';
import BtnCrearLista from '@/components/BtnCrearLista.vue';
//import PantallaItems from '@/components/PantallaItems.vue';
import FiltroPantallaLista from '@/components/FiltroPantallaLista.vue';
import ModalBuscadorImg from '@/components/ModalBuscadorImg.vue';
import PantallaEpisodios from '@/components/PantallaEpisodios.vue';

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
            listaEpisodiosVistos: [],
            listaValoraciones: [],
            
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

            pagina_episodios: 1,
            pagina_valoraciones: 1,
            
            minDate: new Date(today.getFullYear() - 120, today.getMonth(), today.getDate()),
            maxDate: new Date(today.getFullYear() - 5, today.getMonth(), today.getDate()),
        }
    },
    components: {
    ListaUsuario,
    BtnCrearLista,
    FiltroPantallaLista,
    ModalBuscadorImg,
    PantallaEpisodios
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
      getEstadisticasUsuario() {
          const data = {
              id: this.id_usuario,
          }
          axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getEstadisticas.php`, data, {
              headers: {
              "Content-Type": "application/json",
              },
          }
          )
          .then(response => {
                console.log("estadisticas");
              console.log(response.data);

              if(typeof response.data === "object" && response.data !== null) {
                  console.log("Exito");
                  this.estadisticas = response.data;
                  this.listaFavoritos = this.estadisticas.favoritos;
              }

          })
          .catch(error => console.log(error));
      },
      getListasUsuario() {
        const data = {
              id_creador: this.id_usuario,
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
                  this.listasCreadas = response.data;
              }

          })
          .catch(error => console.log(error));
      },
      getEpisodiosUsuario() {
        const data = {
              id: this.id_usuario,
              page: this.pagina_episodios
          }
          axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getEpisodiosVistos.php`, data, {
              headers: {
              "Content-Type": "application/json",
              },
          }
          )
          .then(response => {
            console.log("episodios:")
              console.log(response.data);

              if(typeof response.data === "object" && response.data !== null) {
                  console.log("Exito");
                  this.listaEpisodiosVistos = response.data;
              }

          })
          .catch(error => console.log(error));
      },
      getValoracionesUsuario() {
        const data = {
              id: this.id_usuario,
              page: this.pagina_valoraciones
          }
          axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getValoraciones.php`, data, {
              headers: {
              "Content-Type": "application/json",
              },
          }
          )
          .then(response => {
            console.log("valoraciones:")
              console.log(response.data);

              if(typeof response.data === "object" && response.data !== null) {
                  console.log("Exito");
                  this.listaValoraciones = response.data;
              }

          })
          .catch(error => console.log(error));
      },
      crearLista(valor){
        //volvemos a obtener la lista de usuarios
        if(valor) this.getListasUsuario();
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
      capitalizarPrimeraLetra(value) {
        if (!value) return '';
        return value.charAt(0).toUpperCase() + value.slice(1);
      },
      convertirMinutosDHM(min) {
        const segundos = min * 60;
        const dias = Math.floor(segundos / (24 * 60 * 60));
        const horas = Math.floor((segundos % (24 * 60 * 60)) / (60 * 60));
        const minutos = Math.floor((segundos % (60 * 60)) / 60);
        
        return {
            dias,
            horas,
            minutos
        };
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
          this.getEstadisticasUsuario();
          this.getListasUsuario();
          this.getEpisodiosUsuario();
          this.getValoracionesUsuario();

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

.usuario-img{
    box-shadow: black 0px 0px 5px;
    position: relative;
    transform: translate(0px, 40px);
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
.info-usuario{
    display: flex !important;
    flex-flow: column wrap !important;
    align-items: flex-start !important;
}
.usuario-nombre{
    font-size: xx-large;
}

.usuario-username{
  font-size: x-large;
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

.estadisticas{
    display: flex;
    flex-flow: row nowrap;
    align-content: center;
    overflow-x: auto;
}
.apartado{
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    margin: 5px;
    background: linear-gradient(45deg, rgba(27,27,27,1) 0%, rgba(61,61,61,1) 100%);
    padding: 12px;
    border-radius: 10px;
    box-shadow: black 0px 0px 5px;
    width: 100%;
    min-width: 170px;

}
.apartado span{
    color: white;
    font-size: x-large;
}
.valor-tiempo{
    font-size: 0.7rem;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    width: 100%;
    justify-content: space-evenly;
}
.valor-tiempo div{
    display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: center;
}

@media (max-width: 745px) {
    .usuario-img{
      transform: translate(0px, 0px);
    }
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
    .info-usuario{
        display: flex;
        flex-flow: column wrap;
        align-items: flex-start;

    }
    .menu-tabs{
        padding: 30px 5px 0px 5px !important;
    }
    #banner{
        height: auto;
    }
}

</style>