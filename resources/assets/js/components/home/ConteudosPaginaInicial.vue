<template>
  <section class="q-my-xl ">

    <div class="separatriz-6"></div>
    <div v-html="dados_conteudo.conteudo"></div>
    <div class="row justify-center q-py-lg q-gutter-lg">

    </div>
  </section>
</template>
<script>
// @ts-nocheck

import { QImg, QSeparator, QBtn } from "quasar";
import { PaginatorCard } from "@components/paginator";

export default {
  name: "CardHome",
  components: {
    QImg,
    PaginatorCard,
    QSeparator,
    QBtn,
  },
  data() {
    return {
      dados_conteudo: {},
    };
  },
  created() {
    this.getConteudo();
  },
  methods: {
    async getConteudo() {
      const { data } = await axios.get("/content_pagina_inicial/conteudo");
      //console.log(data);
      if (data) {
        //console.log(data[0]);
        this.dados_conteudo = data[0];
      }
    },
  },
};
</script>

