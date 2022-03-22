<template>
  <div class="mostrar_alunos">
    <div class="text-h5 title-page text-primary separatriz q-pb-md">
      Rotinas de Estudo
    </div>
    <div class="separatriz-6"></div>

    <q-banner
      inline-actions
      class="text-white bg-positive"
    >
      <template v-slot:avatar>
        <q-icon
          name="tips_and_updates"
          color="warning"
        />
      </template>
      Nas rotinas de aprendizagem você terá acesso aos mais diversos conteúdos...

    </q-banner>

    <div class="row justify-center q-py-lg q-gutter-lg">

      <div
        id="buttons_home"
        v-for="(button, s) in buttons"
        :key="`${s}`"
        :to="`/rotinas-de-estudo/${button.slug}`"
      >
        <router-link :to="`/rotinas-de-estudo/${button.slug}`">
          <div :class="`imagem_botoes-${s}`"></div>
          <h4
            class="menu-title"
            v-html="button.label"
            :class="`item-${s}`"
          ></h4>
        </router-link>
      </div>

    </div>

  </div>
</template>

<script>
import { QBtn, QAvatar } from "quasar";
import "animate.css";
export default {
  name: "HomeLinksRotinas",
  components: { QBtn, QAvatar },

  data() {
    return {
      buttons: [
        {
          color: "petecavermelho",
          label: "Ensino Fundamental I",
          slug: "ensino-fundamental-1",
        },
        {
          color: "petecaamarelo",
          label: "Ensino Fundamental II",
          slug: "ensino-fundamental-2",
        },
        { color: "petecaazul", label: "Ensino Médio", slug: "ensino-medio" },
      ],
    };
  },
};
</script>

<style>
</style>