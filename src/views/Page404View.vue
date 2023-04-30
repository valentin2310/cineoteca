<template>

<div class="cuerpo-404 d-flex flex-column justify-content-center align-items-center">
    <h1>Error 404</h1>
    <h2 class="my-5">Página no encontrada <i class="fa-solid fa-ghost fa-3"></i></h2>
    <router-link to="/">
        <b-button class="fw-bold">Volver a inicio</b-button>
    </router-link>
</div>

</template>

<style>

.cuerpo-404{
    height: 100vh;
    background: linear-gradient(90deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), 
    url("https://media.giphy.com/media/d62ID9ANzAZKvBLh4A/giphy.gif");
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    color: whitesmoke;
}

</style>