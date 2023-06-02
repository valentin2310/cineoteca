<template>
    <div class="perfil-view">

        <div v-if="usuarioObj">
            
            <b-row align-v="end" id="banner" class="mx-0" v-bind:style="{
                'background-image': 'linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,8) 100%), url(https://image.tmdb.org/t/p/original//a6ptrTUH1c5OdWanjyYtAkOuYD0.jpg)',
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
                            <p>Miembro desde: {{ obtenerFecha(usuarioObj.fecha_alta) }}</p>
                            
                        </div>
                        
                    </div>

                </b-col>
                
             </b-row>


        </div>

    </div>
</template>

<script>

import axios from 'axios';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
//const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

export default {
    data() {
        return  {
            id_usuario: null,
            usuarioObj: null,
            usuarioTMDB: null,
            
            sessionId: null,
            access_token: null,
            apiUrl: 'https://api.themoviedb.org/3',        
            urlImg: 'https://image.tmdb.org/t/p/w500',
        }
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

@media (max-width: 650px) {
    .usuario-img{
    transform: translate(0px, 0px);
}
}

</style>