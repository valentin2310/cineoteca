<template>
    <div class="buscadorPeliculas">


        <b-button type="is-primary" expanded class="my-2 text-start" @click="getListaPeliculas">
                <i class="fa-solid fa-magnifying-glass me-2"></i> BUSCAR
            </b-button>

            <!-- Opciones para buscar -->
            <div class="accordion" role="tablist">
                <!-- Ordenar -->
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-button block v-b-toggle.accordion-ordenar type="is-primary is-light" expanded class="text-start">
                            <i class="fa-solid fa-arrow-up-wide-short me-2"></i> Ordenar
                        </b-button>
                    </b-card-header>
                    <b-collapse id="accordion-ordenar" visible accordion="my-accordion" role="tabpanel">
                        <b-card-body class="center con-selects">

                            <b-field label="Ordenar por:">
                                <b-select placeholder="Select a character"
                                    v-model="b_ordenar">
                                    <optgroup 
                                        v-for="[keyGrupo, valorGrupo] in Object.entries(criterios_ordenar)" 
                                        :key="keyGrupo" 
                                        :label="keyGrupo"
                                        >
                                        <option v-for="valor in valorGrupo" :key="valor" :value="`${keyGrupo}.${valor}`">{{ `${keyGrupo}.${valor}` }}</option>
                                    </optgroup>
                                </b-select>
                            </b-field>

                        </b-card-body>
                    </b-collapse>
                </b-card>
                <!-- Donde ver -->
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-button block v-b-toggle.accordion-dondeVer type="is-primary is-light" expanded class="text-start">
                            <i class="fa-solid fa-earth-americas me-2"></i> Donde ver
                        </b-button>
                    </b-card-header>
                    <b-collapse id="accordion-dondeVer" accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <!-- paises -->

                            <!-- Esta oculto pero el de abajo no funciona sin este :) -->
                            <vs-select
                                class="d-none"
                                placeholder="Paises"
                                v-model="b_pais"
                                @change="getProveedores()"
                            >
                                <vs-option v-for="pais in paises" :key="pais.iso_3166_1" :label="'hola'" :value="`${pais.iso_3166_1}`">
                                    {{ pais.native_name }}
                                </vs-option>
                            </vs-select>

                            <b-field label="Paises">
                                <b-select 
                                    placeholder="Seleciona un pais"
                                    v-model="b_pais"
                                    expanded
                                    @change="getProveedores()"
                                    >
                                    <option
                                        v-for="pais in paises"
                                        :value="pais.iso_3166_1"
                                        :key="pais.iso_3166_1">
                                        {{ pais.native_name }}
                                    </option>
                                </b-select>
                            </b-field>

                            <!-- Plataformas streaming -->
                            <b-field label="Plataforma">
                                <b-taginput
                                    v-model="b_streaming"
                                    :data="proveedores_filtro"
                                    autocomplete
                                    :allow-new="false"
                                    :open-on-focus="true"
                                    field="provider_name"
                                    placeholder="Elige una plataforma"
                                    @typing="getProveedoresFiltrados"
                                    expanded>
                                    <template #empty>
                                        No hay plataformas
                                    </template>
                                </b-taginput>
                            </b-field>

                        </b-card-body>
                    </b-collapse>
                </b-card>
                <!-- Filtros -->
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-button block v-b-toggle.accordion-filtro type="is-primary is-light" expanded class="text-start">
                            <i class="fa-solid fa-filter me-2"></i> Filtros
                        </b-button>
                    </b-card-header>
                    <b-collapse id="accordion-filtro" accordion="my-accordion" role="tabpanel">
                        <b-card-body>

                            <b-field label="Palabras clave">
                                <b-taginput
                                    v-model="b_palabras_clave"
                                    ellipsis
                                    expanded
                                    placeholder="palabras clave"
                                    aria-close-label="eliminar tag">
                                </b-taginput>
                            </b-field>

                            <b-field label="Fecha estreno">
                                <b-datepicker
                                    placeholder="Selecciona un rango de fechas..."
                                    v-model="b_estreno"
                                    range>
                                </b-datepicker>
                            </b-field>

                            <b-field label="Generos">
                                <b-taginput
                                    v-model="b_generos"
                                    :data="generos"
                                    autocomplete
                                    :allow-new="false"
                                    :open-on-focus="true"
                                    field="name"
                                    placeholder="Elige un genero"
                                    expanded>
                                    <template #empty>
                                        No hay generos
                                    </template>
                                </b-taginput>
                            </b-field>

                            <b-field label="Duración">
                                <b-slider v-model="b_duracion" :min="0" :max="400" :step="15" ticks>
                                </b-slider>
                            </b-field>
                            <p class="content">Entre: {{ b_duracion[0] }} y {{ b_duracion[1] }} min</p>

                            <b-field label="Certificados">
                                <b-taginput
                                    v-model="b_certificados"
                                    :data="certificaciones"
                                    autocomplete
                                    :allow-new="false"
                                    :open-on-focus="true"
                                    field="certification"
                                    placeholder="Elige una certificacion"
                                    expanded>
                                    <template #empty>
                                        No hay certificaciones
                                    </template>
                                </b-taginput>
                            </b-field>

                            <b-field label="Idioma">
                                <b-select 
                                    placeholder="Seleciona un idioma"
                                    v-model="b_idioma"
                                    expanded
                                    >
                                    <option
                                        v-for="idioma in idiomas"
                                        :value="idioma.iso_639_1"
                                        :key="idioma.iso_639_1">
                                        {{ idioma.english_name }}
                                    </option>
                                </b-select>
                            </b-field>

                            <b-field label="Valoración">
                                <b-slider v-model="b_valoracion" :min="0" :max="10" :step="0.5" ticks>
                                </b-slider>
                            </b-field>
                            <p class="content">Entre: {{ b_valoracion[0] }} y {{ b_valoracion[1] }} <i class="fa-solid fa-star"></i></p>

                            <b-field label="Votos minimos">
                                <b-slider v-model="b_votos" :min="0" :max="500"></b-slider>
                            </b-field>

                        </b-card-body>
                    </b-collapse>
                </b-card>
            </div>

    </div>
</template>

<script>
import axios from 'axios';
import { BCollapse } from 'bootstrap-vue';


const API_KEY = 'd5970548f1728e977459ef0ac8c8b5df';

export default {
  data() {
    return {
        apiUrl: 'https://api.themoviedb.org/3',
        laguage: 'es-ES',

        paises: [],
        proveedores: [],
        generos: [],
        certificaciones: [],
        listaPeliculas: [],
        idiomas: [],

        proveedores_filtro: this.proveedores,

        criterios_ordenar : {
            'popularity': [
                'asc', 'desc'
            ],
            'release_date': [
                'asc', 'desc'
            ],
            'revenue': [
                'asc', 'desc'
            ],
            'primary_release_date': [
                'asc', 'desc'
            ],
            'original_title': [
                'asc', 'desc'
            ],
            'vote_average': [
                'asc', 'desc'
            ],
            'vote_count': [
                'asc', 'desc'
            ]
        },

        b_ordenar: '',
        b_pais: '',
        b_streaming: [],
        b_palabras_clave: [],
        b_estreno: [],
        b_generos: [],
        b_duracion: [],
        b_certificados: [],
        b_idioma: '',
        b_valoracion: [],
        b_votos: 0
        
    }
  },
  components: {
    BCollapse,
  },
  created () {
      this.getPaises();
      this.getProveedores();
      this.getGeneros();
      this.getCertificaciones();
      this.getIdiomas();
  },
  methods: {
    getPaises(){
        axios.get(`${this.apiUrl}/watch/providers/regions`, {
            params: {
                api_key: API_KEY,
                language: this.laguage
            }
            })
            .then(response => {
                //console.log(response.data.results);
                this.paises = response.data.results;

                this.paises.sort((a, b) => a.native_name.localeCompare(b.native_name));

                console.log("paises:");
                console.log(this.paises);
            })
            .catch(error => console.log(error));
    },
    getProveedores(){
        this.b_streaming = [];
        let watch_region = this.b_pais?? "ES";
        axios.get(`${this.apiUrl}/watch/providers/movie`, {
            params: {
                api_key: API_KEY,
                language: this.laguage,
                watch_region: watch_region
            }
            })
            .then(response => {
                //console.log(response.data.results);
                this.proveedores = response.data.results;
                this.proveedores_filtro = this.proveedores;
                console.log("Proveedores para la region: "+watch_region);
                console.log(this.proveedores)
            })
            .catch(error => console.log(error));
    },
    getGeneros(){
        axios.get(`${this.apiUrl}/genre/movie/list`, {
            params: {
                api_key: API_KEY,
                language: this.laguage
            }
            })
            .then(response => {
                console.log("generos")
                //console.log(response);
                this.generos = response.data.genres;
                console.log(this.generos)
            })
            .catch(error => console.log(error));
    },
    getCertificaciones(){
        axios.get(`${this.apiUrl}/certification/movie/list`, {
            params: {
                api_key: API_KEY
            }
            })
            .then(response => {
                console.log("certificaciones:")
                //console.log(response);
                this.certificaciones = response.data.certifications.ES;
                console.log(this.certificaciones)
            })
            .catch(error => console.log(error));
    },
    getIdiomas(){
        axios.get(`${this.apiUrl}/configuration/languages`, {
            params: {
                api_key: API_KEY,
            }
            })
            .then(response => {
                console.log("Idiomas")
                //console.log(response);
                this.idiomas = response.data;

                this.idiomas.sort((a, b) => a.english_name.localeCompare(b.english_name));

                console.log(this.idiomas)
            })
            .catch(error => console.log(error));
    },
    getProveedoresFiltrados(text) {
        this.proveedores_filtro = this.proveedores.filter((option) => {
            //console.log(option);
            return option.provider_name
                .toString()
                .toLowerCase()
                .indexOf(text.toLowerCase()) >= 0
        })
    },
    getListaPeliculas(){

        let orden = this.b_ordenar?? "popularity.asc";
        let generos = this.b_generos.map(genero => genero.id).join(',');
        let proveedores = this.b_streaming.map(proveedor => proveedor.provider_id).join('|');
        let keywords = this.b_palabras_clave.join(',');
        let certification_country = "ES";
        let certification = this.b_certificados.map(certificado => certificado.certification).join(',');

        console.log("Certificados: ");
        console.log(certification);

        axios.get(`${this.apiUrl}/discover/movie`, {
            params: {
                api_key: API_KEY,
                language: this.language,
                page: 1,
                include_adult: true,
                sort_by: orden,
                certification_country: certification_country,
                certifaction: certification,
                'release_date.gte': this.b_estreno[0],
                'release_date.lte': this.b_estreno[1],
                'vote_count.gte': this.b_votos,
                'vote_average.gte': this.b_valoracion[0],
                'vote_average.lte': this.b_valoracion[1],
                with_genres: generos,
                region: this.b_pais,
                with_watch_providers: proveedores,
                with_keywords: keywords,

            }
            })
            .then(response => {
                console.log("listaPeliculas")
               //console.log(response);
                this.listaPeliculas = response.data.results;
                console.log(this.listaPeliculas)
            })
            .catch(error => console.log(error));
    },
  }
}
</script>

<style>
    .buscar-view .vs-select-content, .buscar-view .vs-select {
        max-width: 100% !important;
    }
    .dropdown-menu{
        --bs-dropdown-link-active-bg: "" !important;
    }

</style>