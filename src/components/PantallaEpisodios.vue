<template>
    <div class="pantallaEpisodios box">

        <div class="episodios">
            <div v-for="(ep, i) in episodios" :key="i" class="episodio">
                <EpisodioCard :episodio="ep"></EpisodioCard>
            </div>
            <div v-if="episodios.length < 1" class="">
                No has visto ningún episoido aún..
            </div>
        </div>

    </div>
</template>

<script>
import EpisodioCard from '@/components/EpisodioCard.vue';

export default {
  name: 'PantallaEpisodios',
  components: {
    EpisodioCard,
  },
  props: {
    episodios: {
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
    .episodios{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;

    }
    .episodio{
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