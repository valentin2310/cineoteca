<template>
    <div class="pantallaValoraciones box">

        <div class="valoraciones">
            <div v-for="(val, i) in valoraciones" :key="i" class="valoracion">
                <ValoracionCard :valoracion="val"></ValoracionCard>
            </div>
            <div v-if="valoraciones.length < 1" class="">
                No has hecho ninguna valoración aún..
            </div>
        </div>

    </div>
</template>

<script>
import ValoracionCard from '@/components/ValoracionCard.vue';

export default {
  name: 'PantallaValoraciones',
  components: {
    ValoracionCard,
  },
  props: {
    valoraciones: {
      type: Array,
      required: true,
    },
  },
};

</script>

<style scoped>

    .title{
        color: blueviolet;
    }
    .valoraciones{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;

    }
    .valoracion{
        margin: 5px;
    }

    @media screen and (max-width: 480px) {
      .box{
        padding: 0;
      }
      h1{
        padding: 10px;
      }
    }


</style>