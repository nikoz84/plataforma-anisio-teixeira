<template>
  <q-card v-bind:id="item.id">
    <q-img
      alt="imagem destacada"
      :src="getImage"
      loading="lazy"
      width="100%"
      height="auto"
      :style="`max-height: 200px; width: 100%;backgroud-color:${color};`"
      placeholder-src="/img/fundo-padrao.svg"
    >
      <div class="absolute-bottom-right text-subtitle2">
        {{ getTipo }}
      </div>
    </q-img>

    <q-card-section>
      <div
        :style="`border-bottom: 2px solid ${color};`"
        class="text-h6 card-heading-inner q-pt-md cursor-pointer"
      >
        <router-link
          tag="div"
          :to="
            item.url_exibir
              ? item.url_exibir
              : {
                  name: 'ExibirConteudo',
                  params: { slug: slug, id: item.id, action: 'exibir' }
                }
          "
          v-html="title"
        />
      </div>
      <p
        class="q-pt-lg"
        style="word-break: break-word;"
        v-html="item.excerpt"
      ></p>
    </q-card-section>
    <q-card-actions vertical align="center">
      <QBtn
        class="absolute-bottom"
        :to="
          item.url_exibir
            ? item.url_exibir
            : {
                name: 'ExibirConteudo',
                params: { slug: slug, id: item.id, action: 'exibir' }
              }
        "
        color="primary"
        style="font-weight: 900;"
        flat
      >
        Saiba Mais
      </QBtn>
    </q-card-actions>
  </q-card>
</template>
<script>
import {
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QImg,
  QSeparator
} from "quasar";

export default {
  name: "PaginatorCard",
  props: {
    item: Object
  },
  components: { QCard, QCardSection, QCardActions, QBtn, QImg, QSeparator },
  computed: {
    title() {
      return this.item.name ? this.item.name : this.item.title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : "#08275e";
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    }
  },
  created() {}
};
</script>
<style lang="stylus" scoped>
.card-heading-bottom .card-heading-inner {
  padding-bottom: 6px;
  border-bottom: 2px solid #2c87f0;
  position: relative;
  bottom: -1px;
}

.card-heading-inner {
  display: inline-block;
}

.q-img__image {
  & .absolute-full {
    background-color: black;
  }
}
</style>
