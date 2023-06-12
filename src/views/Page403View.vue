<template>

    <div class="cuerpo-403 d-flex flex-column justify-content-center align-items-center">
        <h1 class="fs-1 fw-bold">Error 403</h1>
        <h2 class="fs-2 my-5">No tienes acceso a esta página <i class="fa-solid fa-ban fa-3"></i></h2>
        <p class="mb-5">Puedes que estes tratando de acceder a un contenido privado</p>
        <router-link to="/">
            <b-button class="fw-bold">Volver a inicio</b-button>
        </router-link>
    </div>
    
    </template>
    
    <style>
    
    .cuerpo-403{
        height: 100vh;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), 
        url("https://media2.giphy.com/media/jsoMtBuP1Ahpu/giphy.gif?cid=ecf05e47rer2po8unw7cqs0sqcaa70g8wy46ienkwudb5np7&ep=v1_gifs_search&rid=giphy.gif&ct=g");
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        color: whitesmoke;
    }
    
    </style>