<template>
    <div class="">


        <div class="row m-0">
            <div class="col-md-7 p-0">
                <div class="welcome text-white p-5">
                    <div class="welcome-body">
                        <h1 class="mb-5 text-info text-center">Bienvenido a MiCineoteca :)</h1>
                        <p class="mx-5">¡Bienvenido/a a MiCineoteca! Nos encanta que hayas decidido unirte a nuestra
                            comunidad de amantes del cine y las series.</p>
                        <p class="mx-5">Para poder acceder a todas las funcionalidades que ofrecemos en nuestra página, como
                            guardar tus películas y series favoritas, crear listas personalizadas, entre otras, necesitas
                            tener una cuenta en TMDB, ya que accedemos a su API para mostrar el contenido.</p>
                        <p class="mx-5">El proceso de registro en TMDB es muy fácil y rápido, y lo mejor de todo es que es
                            gratuito. Te animamos a crear tu cuenta en TMDB haciendo click <a
                                href="https://www.themoviedb.org/signup?language=es" target="_blank" class="text-info">AQUÍ</a>.</p>
                        <p class="mx-5">Una vez que tengas tu cuenta en TMDB, podrás hacer login en MiCineoteca y empezar a
                            disfrutar de todas nuestras funcionalidades.</p>
                        <p class="mx-5">¡Gracias por unirte a nuestra comunidad!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 p-0">
                <!-- Cuerpo form -->
                <div class="login px-5 py-2">

                    <div class="login-img">
                        <img src="../assets/img/logo_banner.png" alt="banner logo">
                    </div>

                    <h4 class="text-info">Inicia sesion con tu cuenta</h4>

                    <!-- form login -->
                    <form @submit.prevent="getToken">
                        <div class="row">
                            <div class="col-12 seccion">
                                <label>Usuario</label>
                                <input class="form-control" type="text" v-model="username" name="usuario" value="" required>
                            </div>
                            <div class="col-12 seccion">
                                <label>Contraseña</label>
                                <input class="form-control" type="password" v-model="password" name="contrasenia" required>
                            </div>
                        </div>
                        
                        <!-- Mensaje de error -->
                        <b-alert v-model="showAlertaAcceso" variant="danger" dismissible>
                          Los datos de acceso no son correctos, por favor prueba a poner los datos correctamente!!
                        </b-alert>

                        <!-- Boton login -->
                        <div class="btnLogin my-5">
                            <button type="submit" class="btn btn-dark text-info fw-bold mx-auto px-5 py-2">Iniciar
                                Sesion</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>

    </div>
</template>

<script>

import axios from "axios";

const API_KEY = "d5970548f1728e977459ef0ac8c8b5df";

export default {
  data() {
    return {
      token: null,
      sessionId: null,
      username: '',
      password: '',
      showAlertaAcceso: false
    };
  },
  methods: {
    async getToken () {
      try {
        const response = await axios.get(`https://api.themoviedb.org/3/authentication/token/new?api_key=${API_KEY}`)
        this.token = response.data.request_token
        console.log(response);
        await this.validarToken()
      } catch (error) {
        console.error(error)
      }
    },
    async validarToken () {
      try {
        const response = await axios.post(`https://api.themoviedb.org/3/authentication/token/validate_with_login?api_key=${API_KEY}`, {
          username: this.username,
          password: this.password,
          request_token: this.token
        })
        if (response.data.success) {
          console.log(response);
          await this.crearSesion()
        }
      } catch (error) {
        console.error(error)

        //mandar un mensaje de error al usuario
        this.showAlertaAcceso = true;
      }
    },
    async crearSesion () {
      try {
        const response = await axios.post(`https://api.themoviedb.org/3/authentication/session/new?api_key=${API_KEY}`, {
          request_token: this.token
        })
        console.log(response)
        const sessionId = response.data.session_id
        this.$cookies.set('sessionId', sessionId, 60 * 60 * 24 * 7) // la sessionId caduca despues de 7 dias
        this.sessionId = sessionId;


        //devolver a la pagina de inicio
        this.$router.push('/');

      } catch (error) {
        console.error(error);
      }
    }
  },
  created () {
    const sessionId = this.$cookies.get('sessionId') // "ada564802fc409daf6add800ae7ec3d826c06c2c"
    if (sessionId) {
      this.sessionId = sessionId
      console.log('Ya esta iniciada la sesion, sessionId: '+this.sessionId);
    }
  }
};

</script>

<style>

label {
    color:white;
    margin-left: 5px;
  }
  .seccion{
    margin: 10px 0px;
  }

  .welcome {
    background: linear-gradient(30deg, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.7)),
    url('../assets/img/fondo_welcome.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    height: 100vh;
  }

  .welcome-body{
    height: 100%;
    overflow-y: auto;
  }
  .welcome-body a{
    text-decoration: none;
    font-size: larger;
  }

  .login{
    height: 100vh;
    background: linear-gradient(30deg, rgba(19,19,19,1) 0%, rgba(34,44,64,1) 100%);
    box-shadow: black 0px 0px 5px;
    overflow-y: scroll;
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
  .btn{
    box-shadow: black 0px 0px 5px;
  }
  .form-check-input:checked {
    background-color: #ff0000;
    border-color: rgba(249,54,54,1);
  }

  @media (max-width: 450px) {
    .welcome-body .mx-5{
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
  }

</style>