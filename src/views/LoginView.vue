<template>
    <div class="loginView">


        <div class="row m-0">
            <div class="col-md-7 p-0">
                <div class="welcome text-white p-5">
                    <div class="welcome-body">
                        <h1 class="mb-5 title is-primary text-center">Bienvenido a MiCineoteca :)</h1>
                        <p class="mx-5 my-1">¡Bienvenido/a a MiCineoteca! Nos encanta que hayas decidido unirte a nuestra comunidad de amantes del cine y las series.</p>
                        <p class="mx-5 my-1">Para poder acceder a todas las funcionalidades que ofrecemos en nuestra página, como guardar tus películas y series favoritas, crear listas personalizadas y más, te recomendamos registrarte en MiCineoteca.</p>
                        <p class="mx-5 my-1">Si deseas vincular tu cuenta de TMDB para guardar tu información puedes seguir estos pasos:</p>
                        <ol class="mx-5 mt-1 mb-3">
                          <li class="mx-5">Haz click en el enlace del login, dar permisos para usar cuenta de TMDB</li>
                          <li class="mx-5">Aparecerá una notificación que te preguntará para darnos permiso para acceder a tus datos de TMDB.</li>
                          <li class="mx-5">Por último inicia sesión con tu usuario y listo.</li>
                          <li class="mx-5">Si aún no tienes una cuenta en TMDB, puedes hacer click <a href="https://www.themoviedb.org/signup?language=es" target="_blank" class="is-primary fw-bold">AQUÍ</a>.</li>
                        </ol>
                        <p class="mx-5 my-1">Recuerda que la vinculación con TMDB es opcional, puedes disfrutar de MiCineoteca sin necesidad de iniciar sesión en TMDB.</p>
                        <p class="mx-5 my-1">¡Gracias por unirte a nuestra comunidad!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 p-0">
                <!-- Cuerpo form -->
                <div class="loginsignup p-5">

                  <!-- Nav tabs -->
                   <ul class="nav nav-tabs" id="tabLoginSignup" role="tablist">
                     <li class="nav-item col-md-6" role="presentation">
                       <p class="nav-link text-center active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Login</p>
                     </li>
                     <li class="nav-item col-md-6" role="presentation">
                       <p class="nav-link text-center" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Registro</p>
                     </li>
                   </ul>
   
                   <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="login px-3 py-2">
        
                            <div class="login-img">
                                <img src="../assets/img/logo_banner.png" alt="banner logo">
                            </div>
        
                            <h4 class="title is-4 is-primary">Inicia sesion con tu cuenta</h4>
        
                            <!-- form login -->
                            <form @submit.prevent="iniciarSesion">
                                <div class="row">
                                    <div class="col-12 seccion">
                                        <b-field label="Usuario" :type="type_username">
                                          <b-input 
                                            v-model="username"
                                            maxlength="30"
                                            :message="error_username"
                                            required
                                            icon-pack="fas"
                                            icon="user"
                                          >
                                          </b-input>
                                        </b-field>
                                    </div>
                                    <div class="col-12 seccion">
                                        <b-field label="Contraseña" :type="type_password">
                                          <b-input 
                                            v-model="password"
                                            type="password"
                                            password-reveal
                                            maxlength="20"
                                            :message="error_password"
                                            required
                                            icon-pack="fas"
                                            icon="key"
                                          >
                                          </b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="col-12 seccion">
                                  <a :href="`https://www.themoviedb.org/auth/access?request_token=${tokenV4}`" target="_blank">Dar permisos para usar cuenta de TMDB</a>
                                </div>
        
                                <!-- Boton login -->
                                <div class="btnLogin my-5">
                                    <b-button native-type="submit" type="is-primary is-light" class="fw-bold mx-auto px-5 py-2">Iniciar Sesión</b-button>
                                </div>
                            </form>
        
                        </div>

                      </div>

                      <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        
                        
                        <div class="signup px-3 my-5">
                          <h4 class="title is-4 text-center is-primary">Registrate</h4>
            
                          <form @submit.prevent="registrarse" method="POST" enctype="multipart/form-data">
                            <div class="row">
                              <div class="col-md-12 seccion">
                                <b-field label="Usuario" :type="type_username_reg">
                                    <b-input 
                                      v-model="username_reg"
                                      maxlength="20"
                                      minlenght="5"
                                      :message="error_username_reg"
                                      validation-message="El usuario debe tener entre 5 y 20 letras y numeros"
                                      pattern="[A-Za-zÑñ0-9_]{5,20}"
                                      required
                                      icon-pack="fas"
                                      icon="user"
                                    >
                                    </b-input>
                                </b-field>
                              </div>
                                <div class="col-md-12 seccion">
                                  <b-field label="Nombre completo" :type="type_nombre_reg">
                                    <b-input 
                                      v-model="nombre_reg"
                                      maxlength="30"
                                      :message="error_nombre_reg"
                                      required
                                      icon-pack="fas"
                                      icon="user-pen"
                                      validation_message="Tu nombre no es válido, solo se permiten letras y espacios"
                                      pattern="[A-Za-zÑñ]{3}[A-Za-zÑñ ]{0,27}"
                                    >
                                    </b-input>
                                  </b-field>
                                </div>
                                <div class="col-md-6 seccion">
                                  <b-field label="Contraseña" :type="type_password_reg">
                                    <b-input 
                                      v-model="password_reg"
                                      type="password"
                                      password-reveal
                                      maxlength="30"
                                      minlength="5"
                                      :message="error_password_reg"
                                      icon-pack="fas"
                                      required
                                      icon="key"
                                      validation-message="La contraseña tiene un formato inválido, debe contener mínimo una letra y un número"
                                      patter="[A-Za-zÑñ0-9_#.]{5,30}"
                                    >
                                    </b-input>
                                  </b-field>
                                </div>
                                <div class="col-md-6 seccion">
                                  <b-field label="Repite la contraseña" :type="type_password2_reg">
                                    <b-input 
                                      v-model="password2_reg"
                                      type="password"
                                      password-reveal
                                      maxlength="30"
                                      minlength="5"
                                      :message="error_password2_reg"
                                      icon-pack="fas"
                                      required
                                      icon="key"
                                      validation-message="La contraseña tiene un formato inválido, debe contener mínimo una letra y un número"
                                      patter="[A-Za-zÑñ0-9_#.]{5,30}"
                                    >
                                    </b-input>
                                  </b-field>
                                </div>
                                <div class="col-12 seccion">
                                  <b-field label="Sexo" type="primary"></b-field>
                                  <div class="block">
                                    <b-radio v-model="sexo_reg" name="name" native-value="0">
                                      Hombre
                                    </b-radio>
                                    <b-radio v-model="sexo_reg" name="name" native-value="1">
                                      Mujer
                                    </b-radio>
                                    <b-radio v-model="sexo_reg" name="name" native-value="2">
                                      Otro
                                    </b-radio>
                                  </div>
                                  <div class="col-12 seccion">
                                    <b-field label="Fecha nacimiento">
                                        <b-datepicker
                                            v-model="fecha_reg"
                                            placeholder="Click para seleccionar..."
                                            icon-pack="fas"
                                            icon="calendar"
                                            icon-right="close-circle"
                                            @icon-right-clickable="clearDate"
                                            :min-date="minDate"
                                            :max-date="maxDate">
                                        </b-datepicker>
                                    </b-field>
                                  </div>
                                </div>
                                <div class="btnLogin my-5">
                                  <b-button native-type="submit" type="is-primary is-light" class="fw-bold mx-auto px-5 py-2">Registrarse</b-button>
                                </div>
                              </div>
                            </form>
                          </div>

                          
                      </div>

                    </div>
   

                </div>

            </div>
        </div>

    </div>
</template>

<script>

import axios from "axios";

//const API_KEY = "d5970548f1728e977459ef0ac8c8b5df";
const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";
const today = new Date();

export default {
  data() {
    return {
      token: null,
      sessionId: null,
      tokenV4: null,
      access_token: null,

      id_usuario: null,


      username: null,
      error_username: null,
      type_username: 'primary',

      password: null,
      error_password: null,
      type_password: 'primary',

      username_reg: null,
      error_username_reg: null,
      type_username_reg: 'primary',

      img_avatar: null,

      nombre_reg: null,
      error_nombre_reg: null,
      type_nombre_reg: 'primary',

      password_reg: null,
      error_password_reg: null,
      type_password_reg: 'primary',

      password2_reg: null,
      error_password2_reg: null,
      type_password2_reg: 'primary',

      sexo_reg: '2',

      fecha_reg: null,
      minDate: new Date(today.getFullYear() - 120, today.getMonth(), today.getDate()),
      maxDate: new Date(today.getFullYear() - 5, today.getMonth(), today.getDate()),

      img_preview: null,
      showAlertaAcceso: false


    };
  },
  methods: {
    async getTokenV4 () {
      const options = {
        method: 'POST',
        url: 'https://api.themoviedb.org/4/auth/request_token',
        headers: {
          accept: 'application/json',
          'content-type': 'application/json',
          Authorization: 'Bearer '+TOKEN_LECTURA_V4
        }
      };
      try {
        const response = await axios.request(options);
        this.tokenV4 = response.data.request_token
        console.log(response);

      } catch (error) {
        console.error(error)
      }
    },
    async crearTokenAcceso() {
      const options = {
        method: 'POST',
        url: 'https://api.themoviedb.org/4/auth/access_token',
        headers: {
          accept: 'application/json',
          'content-type': 'application/json',
          Authorization: 'Bearer '+TOKEN_LECTURA_V4
        },
        data: {
          request_token: this.tokenV4
        }
      };
      try {
        const response = await axios.request(options);
        const access_token = response.data.access_token;
        console.log(response);

        this.$cookies.set('access_token', access_token, 60 * 60 * 24 * 7) // la sessionId caduca despues de 7 dias
        this.access_token = access_token;

      } catch (error) {
        console.error(error)
      }
    },
    async crearSessionId() {
      const options = {
        method: 'POST',
        url: 'https://api.themoviedb.org/3/authentication/session/convert/4',
        headers: {
          accept: 'application/json',
          'content-type': 'application/json',
          Authorization: 'Bearer '+TOKEN_LECTURA_V4
        },
        data: {
          access_token: this.access_token
        }
      };
      try {
        const response = await axios.request(options);
        const sessionId = response.data.session_id;
        console.log(response);

        this.$cookies.set('sessionId', sessionId, 60 * 60 * 24 * 7) // la sessionId caduca despues de 7 dias
        this.access_token = sessionId;

      } catch (error) {
        console.error(error)
      }
    },
    iniciarSesion() {
        const data = {
            usuario: this.username,
            password: this.password,
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/iniciarSesion.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response);

          if(!response.data.includes('Error')) {
            //guardar id usuario en cookies
            const id_usuario = response.data;
            this.$cookies.set('id_usuario', id_usuario , 60 * 60 * 24 * 7) // la sessionId caduca despues de 7 dias

            this.crearTokenAcceso().then(() => {
              this.crearSessionId().then(() => {
                
                //devolver a la pagina de inicio
                this.$router.push('/');
                location.reload();
              });
            })

          }else{
            this.notifErrorLogin();
          }

        })
        .catch(error => console.log(error));
    },
    registrarse() {
        const data = {
            nombre: this.nombre_reg,
            usuario: this.username_reg,
            password: this.password_reg,
            password2: this.password2_reg,
            sexo: this.sexo_reg,
            fecha_nac: this.fecha_reg
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/insertarUsuario.php`, data, {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(response => {
          
          console.log(response.data);

          if(!response.data.includes('Error')) {
            console.log("Exito");
            location.reload();
          }else{
            this.notifErrorRegistro(response.data);
          }

        })
        .catch(error => console.log(error));
    },
    clearDate() {
      this.fecha_reg = null;
    },
    notifErrorLogin(){
      this.$buefy.notification.open({
        message: 'Los datos de acceso no son correctos..\nComprueba tu usuario y contraseña',
        type: 'is-danger',
        'icon-pack': 'fas',
        position: 'is-top-right',
        indefinite: true
      })
    },
    notifErrorRegistro(error){
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
        'icon-pack': 'fas',
        position: 'is-top-right',
        indefinite: true
      })
    }
  },
  created () {
    const sessionId = this.$cookies.get('sessionId') // 
    const access_token = this.$cookies.get('access_token') // 

    if (sessionId) {
      this.sessionId = sessionId
      console.log('Ya esta iniciada la sesion, sessionId: '+this.sessionId);
    }
    if (access_token) {
      this.access_token = access_token
      console.log('Ya esta iniciada la sesion, access_token: '+this.access_token);
      
    }
    //pedir request_token V4
    this.getTokenV4();

  }
};

</script>

<style>

.loginView label{
    color:white;
    margin-left: 5px;
  }

</style>

<style scoped>
  .title{
    color: blueviolet;
  }
.seccion{
    margin: 10px 0px;
  }

  .welcome {
    background: linear-gradient(30deg, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.7)),
    url('../assets/img/fondo_welcome.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    height: 90vh;
  }

  .welcome-body{
    height: 100%;
    overflow-y: auto;
  }
  .welcome-body a{
    text-decoration: none;
    font-size: larger;
  }

  .loginsignup{
    height: 90vh;
    background: linear-gradient(30deg, rgba(0,0,0,1) 0%, rgba(25,25,25,1) 49%, rgba(62,62,62,1) 100%);
    box-shadow: black 0px 0px 5px;
    overflow-y: scroll;
  }
  .nav-link{
    color: #ffffff;
  }
  .nav-link:hover{
    color: blueviolet;
    transition: 0.5s;
  }
  .login-img{
    margin: 30px 0px
  }
  .login-img img{
    width: 100%;
  }
  .btnLogin{
    display: flex;
    flex-flow: column wrap;
  }
  .link-area
  {
    position: absolute;
    bottom:20px;
    left:40px;
    padding:10px 20px;
    border-radius: 10px;
    background: linear-gradient(30deg, rgba(140,2,2,1) 0%, rgba(207,8,8,1) 49%, rgba(249,54,54,1) 100%);
    box-shadow: black 0px 0px 5px;
  }
  .link-area a
  {
    text-decoration:none;
    color:#fff;
    font-size:20px;
  }
  #preview{
    background: url("../assets/img/poster_fail.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 200px;
    border-radius: 10px;
    max-width: 200px;
  }
  input[type="file"] {
    opacity: 0;
    width: 1px;
  }
  .form-check-input:checked {
    background-color: blueviolet;
    border-color: blueviolet;
  }

  @media (max-width: 450px) {
    .welcome-body .mx-5{
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
  }

</style>