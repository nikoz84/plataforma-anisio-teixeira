<template>
  <div class="row">
    <q-parallax :src="`/storage/conteudos/conteudos-digitais/galeria/${randomImg}.jpg`" style="max-height:80vh;">
        <template v-slot:content="scope">
        <div class="absolute-bottom column items-end">
            <div class="text-h6 text-white">
            <router-link tag="div" to="/galeria" style="background-color: hsla(218, 84%, 20%, 0.8); padding: 15px;cursor: pointer;">
                <q-icon name="photo" class="cursor-pointer"/>
                Visite nossa galeria de imagens
            </router-link>
            </div>
        </div>
        </template>
    </q-parallax>
  </div>
</template>
<script>
import { QParallax } from "quasar";

export default {
  name: "IntroParallax",
  components: { QParallax },
  computed: {
    randomImg() {
      return Math.floor(Math.random() * 8) + 1;
    }
  }
};
</script>
