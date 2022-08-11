<template>
  <div v-if="conteudo">
    <div class="flex justify-center q-gutter-sm">
      <q-btn
        v-if="conteudo.arquivos && conteudo.arquivos['download']"
        target="__blank"
        size="md"
        outline
        round
        color="primary"
        type="a"
        title="Baixar Conteúdo"
        icon="download"
        :href="conteudo.arquivos['download'].url"
        :download="conteudo.arquivos['download'].url"
      >
      </q-btn>
      <q-btn
        v-if="conteudo.arquivos && conteudo.arquivos['guias-pedagogicos']"
        target="__blank"
        size="md"
        outline
        round
        color="primary"
        type="a"
        title="Baixar guia pedagógico"
        icon="description"
        :href="conteudo.arquivos['guias-pedagogicos'].url"
        :download="conteudo.arquivos['guias-pedagogicos'].url"
      >
      </q-btn>
      <q-btn
        size="md"
        href="#"
        icon="share"
        title="Compartilhar"
        outline
        round
        color="primary"
        @click.prevent="show = !show"
      >
      </q-btn>

      <ThumbsMenu></ThumbsMenu>
      <q-btn
        v-if="conteudo.arquivos && conteudo.arquivos['visualizacao']"
        target="__blank"
        size="md"
        outline
        round
        color="primary"
        type="a"
        title="Baixar Conteúdo"
        icon="download"
        :href="conteudo.arquivos['visualizacao'].url"
        :download="conteudo.arquivos['visualizacao'].url"
      >
      </q-btn>
    </div>
    <div class="q-mt-md" v-if="show">
      <q-btn @click="incorporar" color="primary" label="Incorporar"></q-btn>
      <q-separator></q-separator>
      <q-input
        v-if="stringShare"
        v-model="stringShare"
        hint="Copie e cole esse código para adicionar na sua página web"
        autogrow
        readonly
      />
    </div>
  </div>
</template>

<script>
// @ts-nocheck

import { mapState } from "vuex";
import { ThumbsMenu } from "@components/shared";

export default {
  name: "PlayerActions",
  components: { ThumbsMenu },
  data() {
    return {
      guia: {},
      download: {},
      visualizacao: {},
      urlShare: null,
      stringShare: "",
      show: false,
      loading: false,
    };
  },
  computed: {
    ...mapState(["conteudo"]),
  },
  methods: {
    async downloadFile(directory, id) {
      this.loading = true;
      const file = this.conteudo.arquivos[directory];
      axios({
        url: `/files/${directory}/${id}`,
        method: "GET",
        responseType: "blob",
      }).then((response) => {
        this.loading = false;
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", file.name);
        document.body.appendChild(link);
        link.click();
      });
    },
    incorporar() {
      const id = this.conteudo.id;
      const port = location.port ? `:${location.port}` : "";
      const url =
        "http://" +
        location.hostname +
        `${port}` +
        `/incorporar-conteudo/${id}`;
      this.stringShare = `
                <iframe width="560" height="315" src="${url}"
                        frameborder="0" 
                        allowfullscreen>
                </iframe>
            `;
    },
  },
};
</script>

<style scoped>
a {
  text-decoration: none;
}
</style>
