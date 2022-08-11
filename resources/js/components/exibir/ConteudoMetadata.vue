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
        <div class="q-mt-md" v-html="conteudo.description"></div>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.tipo">
        <strong>Tipo de Conteúdo:</strong>
        <q-badge outline align="middle" color="dark" class="text-subtitle2">
          {{ conteudo.tipo.name }}
        </q-badge>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div v-if="conteudo.qt_access">
        <strong>Quantidade de acessos:</strong>
        <q-badge outline align="middle" color="dark" class="text-subtitle2">{{
          conteudo.qt_access
        }}</q-badge>
        <q-separator class="q-my-md"></q-separator>
      </div>
      <div
        class="text-subtitle2"
        v-if="
          conteudo.tipo && conteudo.tipo.id != 8 && conteudo.qt_downloads > 0
        "
      >
        <strong>
          Downloads:
        </strong>
        <q-badge outline align="middle" color="dark">
          {{ conteudo.qt_downloads }}
        </q-badge>
        <q-separator class="q-my-md"> </q-separator>
      </div>
      <strong>Publicado em: </strong>
      <q-badge outline align="middle" color="dark" class="text-subtitle2">
        {{ conteudo.formated_date }}
      </q-badge>

      <q-separator class="q-my-md"></q-separator>

      <strong>Fonte:</strong>

      <q-badge outline align="middle" color="dark" class="text-subtitle2">
        {{ conteudo.source ? conteudo.source : null }}
      </q-badge>

      <q-separator class="q-my-md"></q-separator>

      <strong>Autores:</strong>
      <q-badge outline align="middle" color="dark" class="text-subtitle2">
        {{ conteudo.authors ? conteudo.authors : null }}
      </q-badge>

      <q-separator class="q-my-md"></q-separator>

      <strong>
        Publicador(a):
      </strong>
      <i class="break-word" v-if="conteudo && conteudo.user">
        <q-chip square size="lg" class="text-weight-medium">
          <q-avatar>
            <img src="https://cdn.quasar.dev@/assets/img/boy-avatar.png" />
          </q-avatar>
          <a
            class="text-decoration-none text-dark"
            v-html="conteudo.user ? conteudo.user.name : null"
            title="Ver outros conteúdos deste publicador"
            :href="
              `/recursos-educacionais/listar?publicador=${conteudo.user.id}`
            "
          >
          </a>
        </q-chip>
      </i>

      <q-separator class="q-my-md"></q-separator>

      <strong>Componentes:</strong>
      <div class="flex wordbreak">
        <a
          v-for="componente in conteudo.componentes"
          :key="`c-${componente.id}`"
          v-html="componente.name"
          class="text-subtitle2 q-badge q-badge-single--line bg-dark q-ml-md q-mt-md text-decoration-none"
          :href="`/recursos-educacionais/listar?componentes=${componente.id}`"
          :title="`Mais conteúdos do tipo: ${componente.name}`"
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
        <p class="q-mt-lg">{{ conteudo.license.description }}</p>
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
import { TagList, Title } from "@/components/shared";
export default {
  name: "ConteudoMetadata",
  components: { TagList, Title },
  computed: {
    ...mapState(["conteudo"]),
  },
  methods: {
    onClick(url) {
      this.$router.push(url);
    },
  },
};
</script>

<style lang="stylus" scoped></style>
