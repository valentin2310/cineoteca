<template>
    <div class="perfil-view">

        <div v-if="usuarioObj">
            
            <b-row align-v="end" id="banner" class="mx-0" v-bind:style="{
                'background-image': usuarioObj.img_fondo?`linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,8) 100%), url(https://image.tmdb.org/t/p/original/${usuarioObj.img_fondo})`:'',
                'background-color': '#17202A',
                'background-size': 'cover',
                'background-repeat': 'no-repeat',
                'background-position': 'center center'
            }">

                <b-col class="banner-usuario text-start">
                    
                    <div class="text-white">

                        <b-avatar v-if="usuarioObj.img_avatar" :src="urlImg+usuarioObj.img_avatar" size="9em" class="usuario-img"></b-avatar>
                        <b-avatar v-else size="9em" class="usuario-img"></b-avatar>

                        <div class="info-usuario">
                            <p>
                              <span class="usuario-nombre fw-bold">{{ capitalizarPrimeraLetra(usuarioObj.nombre) }}</span>
                              <span class="usuario-username fw-bold text-white-50"> @{{ usuarioObj.usuario }}</span>
                            </p>
                            <p><span class="span-miembro">Miembro desde: </span>{{ obtenerFecha(usuarioObj.fecha_alta) }}</p>
                            
                        </div>
                        
                    </div>
                    
                </b-col>
                
            </b-row>
            
            <b-tabs type="" expanded class="menu-tabs">
                
                <!--
                -->
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

                </b-tab-item>

                <b-tab-item  label="Valoraciones" icon-pack="fas" icon="star">

                    <h2 class="title is-2 border-custom border-custom-color-5">Valoraciones</h2>

                </b-tab-item>

            </b-tabs>


        </div>

    </div>
</template>

<script>

import axios from 'axios';
import ListaUsuario from '@/components/ListaUsuario.vue';
import BtnCrearLista from '@/components/BtnCrearLista.vue';
//import PantallaItems from '@/components/PantallaItems.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
//const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

export default {
    data() {
        return  {
            id_usuario: null,
            usuarioObj: null,
            usuarioTMDB: null,

            estadisticas: {},
            listasCreadas: {},
            
            sessionId: null,
            access_token: null,
            apiUrl: 'https://api.themoviedb.org/3',        
            urlImg: 'https://image.tmdb.org/t/p/w500',

            mostrar: "0",
            elegirOpcionBuscar: false,
            elegirOpcionEliminar: false,
        }
    },
    components: {
    ListaUsuario,
    BtnCrearLista,
    //PantallaItems
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
              console.log(response.data);

              if(typeof response.data === "object" && response.data !== null) {
                  console.log("Exito");
                  this.estadisticas = response.data;
                  this.itemsFiltrados = this.estadisticas.favoritos;
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
    justify-content: center;
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

@media (max-width: 650px) {
    .usuario-img{
      transform: translate(0px, 0px);
    }
    .menu-tabs{
      margin-top: 2px;
    }
    .span-miembro{
        display: none;
    }
}

</style>