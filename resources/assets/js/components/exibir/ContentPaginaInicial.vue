<template>

  <div class="q-pa-md">
    <h3>Conteúdo da Página Inicial da Plataforma</h3>
    <div class="col-lg-12">
      <!--
      <SearchForm slug="newsletter"></SearchForm>-->
    </div>
    <div class="col-lg-12 flex  q-gutter-sm">
      <!-- ADICIONAR -->
      <!--<q-btn
        icon="add"
        color="positive"
        size="xs"
        :to="`/admin/newsletter/adicionar`"
        title="Adicionar Email"
        label="adicionar Email"
      />
-->

      <vue-editor v-model="content.conteudo"></vue-editor>

    </div>
    <br><br><br><br>
    <q-btn
      size="sm"
      color="primary"
      title="Salvar"
      @click="salvarConteudo()"
      icon="save"
      label="Salvar"
    />
  </div>

</template>

<script>
// @ts-nocheck
//import { SearchForm } from "@forms/search";
import { mapMutations, mapState } from "vuex";
//import { SemResultados } from "@components/paginator";
// Basic Use - Covers most scenarios
import { VueEditor } from "vue2-editor";
import axios from "axios";

// Advanced Use - Hook into Quill's API for Custom Functionality
//import { VueEditor, Quill } from "vue2-editor";

export default {
  name: "ContentPaginaInicial",
  components: { VueEditor },
  data() {
    return {
      content: "",
      errors: {},
    };
  },
  computed: {},
  created() {
    this.getConteudo();
  },
  methods: {
    async salvarConteudo() {
      let conteudos = this.content;

      //console.log(this.content);
      this.$q.loading.show();
      try {
        let resp = await axios.post("/content_pagina_inicial/criar", conteudos);

        this.errors = {};

        //this.$router.push("/");
      } catch (response) {
        this.errors = response.errors;
      }

      // You have the content to save
      //console.log(data);
      //console.log(this.content);

      this.$q.loading.hide();
    },

    async getConteudo() {
      const { data } = await axios.get("/content_pagina_inicial/conteudo");
      //console.log(data);
      if (data) {
        // console.log(data[0]);
        this.content = data[0];
      }
    },
  },
};
</script>

<style>
</style>