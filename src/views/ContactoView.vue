<template>
    <div class="contacto">

        <div class="p-5">
            <h1 class="fs-1 mb-5 fw-bold">
                Contacto
                <b-icon class="ms-3" pack="fas" icon="phone" type="is-primary"></b-icon>
            </h1>
    
            <p>
                ¡Contáctanos!
            </p>
            <p>
                ¿Tienes alguna pregunta, sugerencia o simplemente quieres decirnos hola? Estamos aquí para ayudarte. Envíanos un mensaje y te responderemos lo antes 
                posible. Tu opinión es importante para nosotros. ¡Esperamos saber de ti pronto!
            </p>
        </div>

        <b-row class="bg-gris p-3 m-0" style="height: 100%;">
            <b-col sm="5" class="mb-3 px-3 has-text-centered d-flex flex-column align-items-center justify-content-center">
                <b-icon pack="fas" icon="comment-dots" size="is-large" type="is-dark"></b-icon>
                <br>
                <span class="fs-2 fw-bold is-dark">
                    Escribenos un comentario
                </span>
            </b-col>
            <b-col sm="7" class="p-3 px-5">
                <div class="formulario">
                    <b-field 
                        class="text-white"
                        label="Tu nombre">
                        <b-input icon-pack="fas" icon="user" placeholder="Puedes poner tu nombre.."></b-input>
                    </b-field>
                    <b-field 
                        class="text-white"
                        label="Comentario"
                        type="is-primary" >
                        <b-input maxlength="200" type="textarea" placeholder="Escribemos un comentario :)"></b-input>
                    </b-field>
                    <b-button class="float-end fw-bold" type="is-primary">Enviar</b-button>
                </div>
            </b-col>
        </b-row>


        <section class="hero">
            <div class="hero-body text-primary">
                <b-row>
                <b-col sm="5" class="mb-3 px-3 has-text-centered d-flex flex-column align-items-center justify-content-center">
                    <b-icon pack="fas" icon="map-location-dot" size="is-large" type="is-info"></b-icon>
                    <br>
                    <span class="fs-2 fw-bold is-dark">
                        Encuentranos
                    </span>
                </b-col>
                <b-col sm="7" class="col-mapa bg-dark p-0 rounded custom-shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4084411.7090852982!2d29.65470655361334!3d1.3666941709137232!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1771a69f6499f945%3A0x874155ce43014549!2sUganda!5e0!3m2!1ses!2ses!4v1686567644377!5m2!1ses!2ses" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </b-col>
                </b-row>
            </div>
        </section>

    </div>
</template>

<style scoped>

h1{
  color: blueviolet;
}

p{
  margin: 10px;
}

iframe{
    height: 100%;
    width: 100%;
}

.col-mapa{
    height: 400px;
}

</style>
