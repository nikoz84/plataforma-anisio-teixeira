<template>
  <div v-if="conteudo">
    <q-card-section>
      <div v-if="conteudo.title">
        <strong>Título:</strong>
        <Title :title="conteudo.title"></Title>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.description">
        <strong>Descrição:</strong>
        <div
          class="q-mt-md"
          v-html="conteudo.description"
        ></div>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.tipo">
        <strong>Tipo de Conteúdo:</strong>
        <q-badge
          outline
          align="middle"
          color="teal-10"
        >
          {{conteudo.tipo.name}}
        </q-badge>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.qt_access">
        <strong>Quantidade de acessos:</strong>
        <q-badge
          outline
          align="middle"
          color="teal-10"
        >{{conteudo.qt_access}}</q-badge>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.tipo && conteudo.tipo.id != 8 && conteudo.qt_downloads > 0">
        <strong>
          Downloads:
        </strong>
        <q-badge
          outline
          align="middle"
          color="teal-10"
        >
          {{conteudo.qt_downloads}}
        </q-badge>
        <q-separator class="q-my-md">
        </q-separator>
      </div>
      <strong>Publicado em: </strong>
      {{conteudo.formated_date}}

      <q-separator class="q-my-md"></q-separator>

      <strong>Fonte:</strong>
      {{ conteudo.source ? conteudo.source : null }}

      <q-separator class="q-my-md"></q-separator>

      <strong>Autores:</strong>
      <i class="break-word">
        {{conteudo.authors ? conteudo.authors : null}}
      </i>

      <q-separator class="q-my-md"></q-separator>

      <strong>
        Publicador(a):
      </strong>
      <div
        class="flex justify-center q-mt-md wordbreak"
        v-if="conteudo && conteudo.user"
      >
        <a
          class="tag text-primary"
          v-html="conteudo.user ? conteudo.user.name: null"
          title="Outros conteúdos deste publicador"
          :href="`/recursos-educacionais/listar?publicador=${conteudo.user.id}`"
        >

        </a>
      </div>
      <q-separator class="q-my-md"></q-separator>

      <strong>Componentes:</strong>
      <div class="flex justify-center q-mt-md wordbreak">
        <a
          v-for="(componente) in conteudo.componentes"
          :key="`c-${componente.id}`"
          v-html="componente.name"
          class="tag text-primary q-ml-lg q-mt-md"
          :href="`/recursos-educacionais/listar?componentes=${componente.id}`"
          :title="`Procurar por: ${componente.name}`"
        >
        </a>
      </div>
      <q-separator class="q-my-md"></q-separator>

      <TagList
        :items="conteudo.tags"
        title="Palavras Chave"
        slug="tag"
      ></TagList>

      <q-separator class="q-my-md"></q-separator>
      <div v-if="conteudo.license">
        <strong>Licença: {{ conteudo.license.name }}</strong>
        <q-btn
          color="primary"
          size="xs"
          push
          v-on:click="esconder = !esconder"
        >
          <div class="row items-center no-wrap control">
            <q-icon
              left
              name="copyright"
            />
            <div class="text-center">
              Mostrar Licença
            </div>
          </div>
        </q-btn>
        <p
          class="q-mt-lg"
          v-if="esconder"
          id="hide"
        >{{conteudo.license.description}}</p>
        <q-separator class="q-my-md"></q-separator>
        <!--p class="q-mt-lg text-primary" >
                    Todos os conteúdos postados em esse site são responsabilidade 
                de cada <strong>publicador</strong> ou <strong>projeto</strong>
                </p>
                <q-separator-- class="q-my-md"></q-separator-->
      </div>
    </q-card-section>
  </div>
</template>

<script>
// @ts-nocheck

import { mapState } from "vuex";
import { TagList, Title } from "@components/shared";
export default {
  name: "ConteudoMetadata",
  components: { TagList, Title },
  data() {
    return {
      esconder: false,
    };
  },
  computed: {
    ...mapState(["conteudo"]),
  },
  methods: {
    onClick(url) {
      this.$router.push(url);
    },

    /* mostrarLicenca() {
      this.esconder = true;
    },*/
  },
};
</script>

<style lang="stylus" scoped></style>