<template>
  <div class="pelicula-view">
    <b-row align-v="end" id="banner" class="mx-0" v-bind:style="{
      'background-image': pelicula.backdrop_path ? 'linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,8) 100%), url(https://image.tmdb.org/t/p/original/' + pelicula.backdrop_path + ')' : '',
      'background-color': '#17202A',
      'background-size': 'cover',
      'background-repeat': 'no-repeat',
      'background-position': 'center center'
    }">

      <b-col class="info-pelicula text-start">
        <span id="titulo">{{ pelicula.title }}</span>

        <div v-if="usuarioObj" class="buttons botones">
          <b-button id="btn-favorito" :type="'is-danger '+ (enFavorito?'':'is-light')" icon-pack="fas" icon-left="heart" @click="favorito()">
              Favorito
          </b-button>
          <b-button id="btn-seguimiento" :type="'is-success '+ (enListaSeguimiento?'':'is-light')" icon-pack="fas" icon-left="calendar" @click="seguimiento()">
             Lista seguimiento
          </b-button>
          <b-button id="btn-valorar" :type="'is-primary '+ (valoracion>0?'':'is-light')" icon-pack="fas" icon-left="star" @click="valorar()"
            v-b-popover.hover.bottom="'Tu valoracion: '+ (valoracion>0?valoracion:'Aun no has hecho ninguna valoración')">
              Valorar
          </b-button>
          <b-button id="btn-visto" :type="(enVisto?'is-dark':'is-white')" icon-pack="fas" :icon-left="(enVisto?'eye':'eye-slash')" @click="visto()">
              {{ enVisto?'Visto':'No visto' }}
          </b-button>
        </div>
      </b-col>
      
    </b-row>

    <div class="container">
      <b-row>

        <b-col sm="3" class="columna-portada">
          <div class="menu-pelicula">

            <div class="portada my-3">

              <img v-if="pelicula.poster_path" :src="'https://image.tmdb.org/t/p/w500/' + pelicula.poster_path"
                alt="poster">
              <img v-else src="./../assets/img/poster_fail.png">

            </div>
            <div class="menu-secciones">
  
              <ul class="mx-3 p-0 text-center fw-bold">
                <li><a href="#detalles">Detalles</a></li>
                <li><a href="#sinopsis">Sinopsis</a></li>
                <li><a href="#multimedia">Multimedia</a></li>
                <li><a href="#reparto">Reparto</a></li>
                <li><a href="#comentarios">Comentarios</a></li>
              </ul>
  
            </div>

          </div>
        </b-col>
        <b-col sm="8">

          <div id="detalles" class="seccion my-3">
            <h4 class="title is-4 text-dark ms-2">
              <b-icon pack="fas" icon="hashtag"></b-icon> Detalles
            </h4>
            <div class="seccion-cuerpo">
              <b-row class="w-100 my-2">
                <b-col sm="6"><span class="fw-bold">Titulo original: </span>{{ pelicula.original_title }}</b-col>
                <b-col sm="6"><span class="fw-bold">Idioma original: </span>{{ pelicula.original_language }}</b-col>
              </b-row>
              
              <b-row class="w-100 my-2">
                <b-col sm="6"><span class="fw-bold">Fecha de estreno: </span>{{ pelicula.release_date }}</b-col>
                <b-col sm="6"><span class="fw-bold">Duracion: </span>{{ pelicula.runtime }} min</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col sm="6"><span class="fw-bold">Estado: </span>{{ pelicula.status }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col>
                  <span class="fw-bold">Generos: </span>
                  <b-taglist>
                    <b-tag v-for="genero in pelicula.genres" :key="genero.id" type="is-primary is-light" rounded>
                      {{ genero.name }}
                    </b-tag>
                  </b-taglist>
                </b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col sm="6">
                  <span class="fw-bold">Valoracion: </span>
                  <b-rate
                    class="ms-2"
                    v-model="pelicula.vote_average"
                    icon-pack="fas"
                    icon="star"
                    :max="10"
                    locale="es-ES"
                    :show-score="true"
                    :rtl="true"
                    :disabled="true">
                </b-rate>
                </b-col>
                <b-col sm="6"><span class="fw-bold">Votos realizados: </span>{{ pelicula.vote_count }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col><span class="fw-bold">Presupuesto: </span>{{ getFormatoDinero(pelicula.budget) }}</b-col>
                <b-col><span class="fw-bold">Ganancia: </span>{{ getFormatoDinero(pelicula.revenue) }}</b-col>
              </b-row>

              <b-row class="w-100 my-2">
                <b-col>
                  <span class="fw-bold">Productoras: </span>
                  <b-taglist>
                    <b-tag v-for="productora in pelicula.production_companies" :key="productora.id" type="is-info is-light" rounded>
                      {{ productora.name }}
                    </b-tag>
                  </b-taglist>
                </b-col>
              </b-row>

            </div>
          </div>

          <div id="sinopsis" class="seccion my-3">
            <h4 class="title is-4 text-dark ms-2">
              <b-icon pack="fas" icon="hashtag"></b-icon> Sinopsis
            </h4>
            <div class="seccion-cuerpo">
              <span>{{ pelicula.overview }}</span>
            </div>
          </div>

          <div id="multimedia" class="seccion my-3">
            <h4 class="title is-4 text-dark ms-2">
              <b-icon pack="fas" icon="hashtag"></b-icon> Multimedia
            </h4>

            <div class="seccion-cuerpo">

              <b-tabs type="is-boxed">
                  <b-tab-item  label="Portadas" icon-pack="fas" icon="image">
  
                    <!-- Carousel de portadas-->
                    <b-carousel class="carousel-portada" :autoplay="false" indicator-custom :indicator-inside="false" :overlay="galleryPortada" icon-pack="fas" @click="switchGalleryPortada(true)">
                          <b-carousel-item v-for="(img, i) in imagenes.posters" :key="i">
                              <a class="image ">
                                  <img :src="urlImg+img.file_path">
                              </a>
                          </b-carousel-item>
                          <span v-if="galleryPortada" @click="switchGalleryPortada(false)" class="modal-close is-large"/>
                          <template #indicators="props">
                              <figure class="al image" :draggable="false">
                                  <img :draggable="false" :src="urlImg+imagenes.posters[props.i].file_path" :title="props.i">
                              </figure>
                          </template>
                      </b-carousel>
  
                  </b-tab-item>
  
                  <b-tab-item label="Fondos" icon-pack="fas" icon="images">
  
                    <!-- Carousel de fondos -->
                      <b-carousel :autoplay="false" indicator-custom :indicator-inside="false" :overlay="galleryFondo" icon-pack="fas" @click="switchGalleryFondo(true)">
                          <b-carousel-item v-for="(img, i) in imagenes.backdrops" :key="i">
                              <a class="image ">
                                  <img :src="urlImg+img.file_path">
                              </a>
                          </b-carousel-item>
                          <span v-if="galleryFondo" @click="switchGalleryFondo(false)" class="modal-close is-large"/>
                          <template #indicators="props">
                              <figure class="al image" :draggable="false">
                                  <img :draggable="false" :src="urlImg+imagenes.backdrops[props.i].file_path" :title="props.i">
                              </figure>
                          </template>
                      </b-carousel>
  
  
                  </b-tab-item>
  
                  <b-tab-item label="Videos" icon-pack="fas" icon="video">
                    
                    <!-- ♂Carousel de videos -->
                    <b-carousel
                      class="carousel-videos"
                      :arrow="true"
                      :autoplay="false"
                      :repeat="true"
                      :arrow-hover="true"
                      icon-pack="fas">
                      <b-carousel-item v-for="(video, i) in videos" :key="i">
                          <div class="hero-body">
                            <b-embed
                              type="iframe"
                              aspect="16by9"
                              :src="'https://www.youtube.com/embed/'+video.key"
                              allowfullscreen
                              >
                            </b-embed>
                          </div>
                      </b-carousel-item>
                    </b-carousel>
  
  
                  </b-tab-item>
  
              </b-tabs>

            </div>

          </div>

          <div id="reparto" class="seccion my-3">
            <h4 class="title is-4 text-dark ms-2">
              <b-icon pack="fas" icon="hashtag"></b-icon> Reparto
            </h4>
            <div class="seccion-cuerpo">
              <div v-if="creditos.cast" class="reparto">
                <div v-for="persona in creditos.cast" :key="persona.id" class="persona">
                  <RepartoCard :persona="persona"></RepartoCard>
                </div>
                <div v-if="creditos.cast.length < 1" class="reparto">No hay ningún datos..</div>
              </div>
            </div>
          </div>

          <div id="comentarios" class="seccion my-3">
            <h4 class="title is-4 text-dark ms-2">
              <b-icon pack="fas" icon="hashtag"></b-icon> Comentarios
            </h4>
            <div class="seccion-cuerpo">

              <div v-if="usuarioObj != null" class="">
                <article class="media">
                  <figure class="media-left">
                    <p class="image is-64x64">
                        <b-avatar v-if="usuarioObj.img_avatar" :src="urlImg+usuarioObj.img_avatar"></b-avatar>
                        <b-avatar v-else class="text-white bg-dark"></b-avatar>
                    </p>
                  </figure>
                  <div class="media-content">
                    <div class="field">
                      <p class="control">
                        <textarea class="textarea" placeholder="Añade una reseña..."></textarea>
                      </p>
                    </div>
                    <nav class="level">
                      <div class="level-left">
                      </div>
                      <div class="level-right">
                        <div class="level-item">
                          <a class="button is-info">Enviar</a>
                        </div>
                    </div>
                  </nav>
                </div>
              </article>
            </div>
            <div v-else class="">
              Para poder hacer una review debes estar registrado
              <br>
              <b-button type="primary is-light" tag="router-link" to="/login">Ir al login</b-button>
            </div>
              
              <div class="title is-5 mt-5">Reviews de otros usuarios:</div>

              <div v-if="reviews" class="">

                <div  class="card box my-2" v-for="review in reviews" :key="review.id">
                  <div class="card-content">
                    <div class="media">
                      <div class="media-left">
                        <figure class="image is-48x48">
                          <b-avatar v-if="review.author_details.avatar_path" :src="obtenerImagenAvatar(review.author_details.avatar_path)" alt="Foto perfil"></b-avatar>
                          <b-avatar v-else class="text-white bg-dark"></b-avatar>
                        </figure>
                      </div>
                      <div class="media-content">
                        <p class="title is-5">{{ review.author }}</p>
                        <p class="subtitle is-6">@{{ review.author_details.username }}</p>
                      </div>
                    </div>
                    
                    <div class="content fs-6 mb-3">
                      {{ review.content }}
                    </div>
                    <time class="fw-bold float-end">{{ obtenerFecha(review.created_at) }}</time>
                  </div>
                </div>
                
                <div v-if="reviews.length == 0">No hay reviews de otros usuarios</div>
              </div>

              

            </div>
          </div>

        </b-col>

      </b-row>
    </div>

  </div>
</template>


<script>
import axios from 'axios';
import RepartoCard from '@/components/RepartoCard.vue';

const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';
const TOKEN_LECTURA_V4 = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkNTk3MDU0OGYxNzI4ZTk3NzQ1OWVmMGFjOGM4YjVkZiIsInN1YiI6IjYyYTc0NmI3ODc1ZDFhMDA2NmZmZDlhZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.4WOT6JsCCbc-ntV27ty9YseclVDBqcR3OESBENb55WE";

export default {
  data() {
    return {
      id_usuario: null,
      usuarioObj: null,
      usuarioTMDB: null,
      
      sessionId: null,
      access_token: null,
      apiUrl: 'https://api.themoviedb.org/3',
      urlImg: 'https://image.tmdb.org/t/p/original',
      language: 'es-ES',

      peliculaId: null,
      pelicula: {},
      imagenes: {},
      videos: {},
      reviews: null,
      similares: {},
      creditos: {},

      galleryFondo: false,
      galleryPortada: false,

      valoracion: 0,
      enFavorito: false,
      enListaSeguimiento: false,
      enVisto: false,
      fechaVisto: null,


    }
  },
  components: {
    RepartoCard
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

        //this.obtenerEstadisticasPelicula();

      })
      .catch(error => console.log(error));
    },
    getEstadisticasUsuario(){
        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/getEstadisticasPelicula.php`, data, {
            headers: {
            "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

        if(typeof response.data === "object" && response.data !== null) {
            console.log("Exito");
            const stats = response.data;
            console.log(stats);

            this.enFavorito = stats.favorito;
            this.enListaSeguimiento = stats.seguimiento;
            this.valoracion = stats.valoracion;
            this.enVisto = stats.visto;
            this.fechaVisto = stats.fecha_visto;
        }

        })
        .catch(error => console.log(error));
    },
    getDatosPelicula() {
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}`, {
        params: {
          api_key: API_KEY,
          language: this.language,
        },
      })
        .then(response => {
          this.pelicula = response.data;
          console.log(this.pelicula);
        })
        .catch(error => {
          console.log(error);
        });
    },
    getFormatoDinero(dinero){
        let num = ""

        if (dinero) {
          num = dinero.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        }
        return num;
    },
    obtenerImagenes() {
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}/images`, {
        params: {
          api_key: API_KEY,
        },
      })
        .then(response => {
          this.imagenes = response.data;
          console.log("imagenes:")
          console.log(this.imagenes);
        })
        .catch(error => {
          console.error(error);
        });
    },
    obtenerVideos() {
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}/videos`, {
        params: {
          api_key: API_KEY,
        },
      })
        .then(response => {
          this.videos = response.data.results;
          console.log("videos:")
          console.log(this.videos);
        })
        .catch(error => {
          console.error(error);
        });
    },
    obtenerReviews(){
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}/reviews`, {
        params: {
          api_key: API_KEY,
        },
      })
        .then(response => {
          this.reviews = response.data.results;
          console.log("reviews:")
          console.log(this.reviews);
        })
        .catch(error => {
          console.error(error);
        });
    },
    getPeliculasSimilares(){
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}/similar`, {
        params: {
          api_key: API_KEY,
        },
      })
        .then(response => {
          this.similares = response.data.results;
          console.log("similares:")
          console.log(this.similares);
        })
        .catch(error => {
          console.error(error);
        });
    },
    getCreditos(){
      axios.get(`${this.apiUrl}/movie/${this.peliculaId}/credits`, {
        params: {
          api_key: API_KEY,
        },
      })
        .then(response => {
          this.creditos = response.data;
          console.log("creditos:")
          console.log(this.creditos);
        })
        .catch(error => {
          console.error(error);
        });
    },
    obtenerImagenAvatar(path) {

      if(path.includes('gravatar')){
        return path.substring(1);
      }else{
        return this.urlImg+path;
      }
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
    switchGalleryFondo(value) {
        this.galleryFondo = value
        if (value) {
            return document.documentElement.classList.add('is-clipped')
        } else {
            return document.documentElement.classList.remove('is-clipped')
        }
    },
    switchGalleryPortada(value) {
        this.galleryPortada = value
        if (value) {
            return document.documentElement.classList.add('is-clipped')
        } else {
            return document.documentElement.classList.remove('is-clipped')
        }
    },
    favorito(){
        if(!this.enFavorito) this.setFavorito();
        else this.deleteFavorito();
    },
    seguimiento(){
        if(!this.enListaSeguimiento) this.setSeguimiento();
        else this.deleteSeguimiento();
    },
    valorar() {
        this.$swal({
            title: `Pon una valoracion a ${this.pelicula.title}`,
            input: 'range',
            inputLabel: 'Tu valoracion',
            inputAttributes: {
                min: 0,
                max: 10,
                step: 1
            },
            inputValue: this.valoracion,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Guardar',
            denyButtonText: 'Eliminar valoracion',
            cancelButtonText: 'Cancelar'
        })
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
            this.setValoracion(result.value);
            } else if(result.isDenied){
            this.deleteValoracion();
            }
        })
    },
    visto(){
        if(!this.enVisto) this.setVisto();
        else this.deleteVisto();
    },
    setFavorito(){

        //Si el item esta en favoritos que no siga ejecutando el metodo.
        if(this.enFavorito) return;

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie'
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/setItemFavorito.php`, data, {
            headers: {
            "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

        if(!response.data.includes('Error')) {
            console.log("Exito");
            this.enFavorito = true;
            console.log("En favorito: "+this.enFavorito);
            this.$swal({
                title: 'Añadido exitosamente en favoritos!',
                icon: 'success',
                position: 'top-end',
                showConfirmaButton: false,
                timer: 1200
            })

            //Si esta vinculada la cuenta de TMDB
            this.setFavoritoTMDB();
        }

        })
        .catch(error => console.log(error));
    },
    setSeguimiento(){

        //Si el item esta en seguimiento que no siga ejecutando el metodo.
        if(this.enListaSeguimiento) return;

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie'
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/setItemSeguimiento.php`, data, {
            headers: {
                "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

            if(!response.data.includes('Error')) {
                console.log("Exito");
                this.enListaSeguimiento = true;
                console.log("En seguimiento: "+this.enListaSeguimiento);
                this.$swal({
                    title: 'Añadido a la lista de seguimiento exitosamente!',
                    icon: 'success',
                    position: 'top-end',
                    showConfirmaButton: false,
                    timer: 1200
                })

                //Si esta vinculada la cuenta de TMDB
                this.setSeguimientoTMDB();
            }

        })
        .catch(error => console.log(error));
    },
    setValoracion(value) {

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie',
            valor: value
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/setValoracion.php`, data, {
            headers: {
                "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

            if(!response.data.includes('Error')) {
                console.log("Exito");
                this.valoracion = value;
                console.log("Valoracion: "+this.valoracion);
                this.$swal({
                    title: 'Valoracion guardada exitosamente!',
                    icon: 'success',
                    position: 'top-end',
                    showConfirmaButton: false,
                    timer: 1200
                })

                //Si esta vinculada la cuenta de TMDB
                this.setValoracionTMDB(value);
            }

        })
        .catch(error => console.log(error));
    },
    setVisto(){

      //Si el item esta en visto que no siga ejecutando el metodo.
      if(this.enVisto) return;

      const data = {
          id: this.id_usuario,
          id_tmdb: this.peliculaId,
          duracion: this.pelicula.runtime?? 0,
          titulo: this.pelicula.title
      }
      axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/setPeliculaVisto.php`, data, {
          headers: {
          "Content-Type": "application/json",
          },
      }
      )
      .then(response => {
          console.log(response.data);

      if(!response.data.includes('Error')) {
          console.log("Exito");
          this.enVisto = true;
          console.log("En visto: "+this.enVisto);
          this.$swal({
              title: 'Añadido exitosamente en peliculas vistas!',
              icon: 'success',
              position: 'top-end',
              showConfirmaButton: false,
              timer: 1200
          })
      }

      })
      .catch(error => console.log(error));
    },
    deleteFavorito(){

        //Si el item no esta en favoritos que no siga ejecutando el metodo.
        if(!this.enFavorito) return;

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie'
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarItemFavorito.php`, data, {
            headers: {
                "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

        if(!response.data.includes('Error')) {
            console.log("Exito");
            this.enFavorito = false;
            console.log("En favorito: "+this.enFavorito);
            this.$swal({
                title: 'Eliminado de favoritos exitosamente!',
                icon: 'success',
                position: 'top-end',
                showConfirmaButton: false,
                timer: 1200
            })

            //Si esta vinculada la cuenta de TMDB
            this.setFavoritoTMDB();
        }

        })
        .catch(error => console.log(error));
    },
    deleteSeguimiento(){

        //Si el item no esta en favoritos que no siga ejecutando el metodo.
        if(!this.enListaSeguimiento) return;

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie'
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarItemSeguimiento.php`, data, {
            headers: {
                "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

        if(!response.data.includes('Error')) {
            console.log("Exito");
            this.enListaSeguimiento = false;
            console.log("En Seguimiento: "+this.enListaSeguimiento);
            this.$swal({
                title: 'Eliminado de la lista de seguimiento exitosamente!',
                icon: 'success',
                position: 'top-end',
                showConfirmaButton: false,
                timer: 1200
            })

            //Si esta vinculada la cuenta de TMDB
            this.setSeguimientoTMDB();
        }

        })
        .catch(error => console.log(error));
    },
    deleteValoracion(){

        const data = {
            id: this.id_usuario,
            id_item: this.peliculaId,
            media_type: 'movie'
        }
        axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarValoracion.php`, data, {
            headers: {
                "Content-Type": "application/json",
            },
        }
        )
        .then(response => {
            console.log(response.data);

        if(!response.data.includes('Error')) {
            console.log("Exito");
            this.valoracion = 0;
            console.log("Valoracion: "+this.valoracion);
            this.$swal({
                title: 'Valoracion eliminada exitosamente!',
                icon: 'success',
                position: 'top-end',
                showConfirmaButton: false,
                timer: 1200
            })

            //Si esta vinculada la cuenta de TMDB
            this.deleteValoracionTMDB();
        }

        })
        .catch(error => console.log(error));
    },
    deleteVisto(){

      //Si el item esta en visto que no siga ejecutando el metodo.
      if(!this.enVisto) return;

      const data = {
          id: this.id_usuario,
          id_tmdb: this.peliculaId
      }
      axios.post(`https://www.ieslamarisma.net/proyectos/2023/valentinandrei/php/eliminarPeliculaVisto.php`, data, {
          headers: {
          "Content-Type": "application/json",
          },
      }
      )
      .then(response => {
          console.log(response.data);

      if(!response.data.includes('Error')) {
          console.log("Exito");
          this.enVisto = false;
          console.log("En visto: "+this.enVisto);
          this.$swal({
              title: 'Eliminado exitosamente de peliculas vistas!',
              icon: 'success',
              position: 'top-end',
              showConfirmaButton: false,
              timer: 1200
          })
      }

      })
      .catch(error => console.log(error));
    },
    setFavoritoTMDB() {
        const options = {
            method: 'POST',
            url: `${this.apiUrl}/account/${this.usuarioTMDB.id}/favorite`,
            params: {session_id: this.sessionId},
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json;charset=utf-8',
                Authorization: `Bearer ${TOKEN_LECTURA_V4}`
            },
            data: {
                media_type: 'movie',
                media_id: this.peliculaId,
                favorite: !this.enFavorito
            }
        };

        axios
            .request(options)
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.error(error);
                this.$swal(error.response.data.status_message, '', 'error')
            });
    },
    setSeguimientoTMDB() {
        const options = {
            method: 'POST',
            url: `${this.apiUrl}/account/${this.usuarioTMDB.id}/watchlist`,
            params: {session_id: this.sessionId},
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json;charset=utf-8',
                Authorization: `Bearer ${TOKEN_LECTURA_V4}`
            },
            data: {
                media_type: 'movie',
                media_id: this.peliculaId,
                watchlist: !this.enListaSeguimiento
            }
        };

        axios
            .request(options)
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.error(error);
                this.$swal(error.response.data.status_message, '', 'error')
            });
    },
    setValoracionTMDB(value) {
        const options = {
            method: 'POST',
            url: `${this.apiUrl}/movie/${this.peliculaId}/rating`,
            params: {session_id: this.sessionId},
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json;charset=utf-8',
                Authorization: `Bearer ${TOKEN_LECTURA_V4}`
            },
            data: {value: value}
        };

        axios
            .request(options)
            .then(response => {
                console.log(response);
                //this.$swal('Guardado!', '', 'success')
                //this.valoracion = value;
            })
            .catch(error => {
                console.error(error);
                this.$swal(error.response.data.status_message, '', 'error')
            });
    },
    deleteValoracionTMDB() {
        axios.delete(`${this.apiUrl}/movie/${this.peliculaId}/rating`, {
            params: {
            api_key: API_KEY,
            session_id: this.sessionId,
            }
        })
        .then(response => {
                console.log(response);
                //this.$swal('Borrado exitosamente!', '', 'success')
            })
        .catch(error => {
            console.error(error);
            this.$swal(error.response.data.status_message, '', 'error')
        });
    },
  },
  mounted() {
    const id_usuario = this.$cookies.get('id_usuario');
    const sessionId = this.$cookies.get('sessionId') // 
    const access_token = this.$cookies.get('access_token') // 

    this.peliculaId = this.$route.params.id;
    this.getDatosPelicula();

    if(id_usuario){
        this.id_usuario = id_usuario;
        this.getDatosUsuario();
        this.getEstadisticasUsuario();

        // comprobar si tengo acceso a la cuenta de TMDB
        if (sessionId && access_token) {
    
            this.sessionId = sessionId;
            this.access_token = access_token;
    
            //mostrar info del usuario
            this.getDatosUsuarioTMDB();

        }

    }

    //Obtener resto de datos
    this.obtenerImagenes();
    this.obtenerVideos();
    this.obtenerReviews();
    this.getPeliculasSimilares();
    this.getCreditos();

  }
}
</script>

<style scoped>
.columna-portada{
  position: relative;
  transform: translate(0px, -220px);
}
.pelicula-view{
  background-color: white;
}
#banner {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 70vh;
  color: whitesmoke;
}
.info-pelicula{
  padding: 10px 20% 10px 32% !important;
}
#titulo{
  font-size: xx-large;
}
h4{
  color: blueviolet !important;
  margin-top: 40px !important;
  margin-bottom: 15px !important;
}
.botones{
  display: flex;
  flex-flow: row wrap;
  justify-content: flex-start;
  
}
.botones button{
  margin: 5px;
}
.botones .btn{
  margin: 10px 10px 0px 10px;
}
.menu-pelicula{
  position: sticky;
  top: 300px;
}
.portada{
  width: 100%;
  padding: 5px;
  background-color: whitesmoke;
  border-radius: 5px;
  box-shadow: black 0px 0px 5px;
}
.portada img{
  width: 100%;
}
.menu-secciones li{
  text-decoration: none;
  list-style: none;
  border-bottom: black solid 1px;
  margin: 0;
  padding: 5px;
}
.menu-secciones li:hover{
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.2);
  color: white;
}
.seccion{
  padding: 5px;
}
.seccion-cuerpo{
  margin-left: 2rem;
}
.carousel-item {
  /* Estilos personalizados para sobrescribir los estilos de BootstrapVue */
  position: static;
  display: block;
  float: none;
  width: 100%;
  margin-right: 0;
  backface-visibility: visible;
  transition: none;
}
.carousel-portada .carousel-item .image{
    display: flex;
    justify-content: center;
    max-height: 400px;
}
.carousel-portada .carousel-item .image img{
  width: 250px;
}
.is-active .al img {
    border: 1px solid #fff;
    filter: grayscale(0%);
}
.al img {
    border: 1px solid transparent;
    filter: grayscale(100%);
}
.embed-responsive{
  display: flex;
  justify-content: center;
}

.reparto{
  display: flex;
  flex-flow: row nowrap;
  overflow-x: auto;
  padding: 5px;
}
.reparto .repartoCard{
  height: 100%;
}

@media (max-width: 800px) {
  .columna-portada{
  position: static;
  transform: translate(0px, 0px);
}
  .menu-pelicula{
    position: sticky;
    top: 100px;
  }
  .info-pelicula{
    padding: 0px 10px 20px !important;
  }
}

</style>