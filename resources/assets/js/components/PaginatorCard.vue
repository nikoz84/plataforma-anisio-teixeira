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
      
      <div class="text-lowercase absolute-bottom-right bg-transparent">
        <q-btn round 
          no-wrap 
          style="cursor:default !important;" 
          class="bg-cinza" 
          text-color="black" 
          >
           <q-avatar v-if="item.tipo && item.tipo.icon">
             <img :src="item.tipo.icon">
           </q-avatar>
        </q-btn>
        <div v-if="item.category" >{{item.category}}</div>
        
      </div>
      </q-img>
      <q-card-section>
      <!-- removida a borda usando um none no estilo -->
      <div
        :style="`border-bottom: none ${color}; min-height: 80px; line-height: 1.3;`" 
        class="text-h6 card-heading-inner q-pt-md cursor-pointer"
      >
        <router-link
          tag="div"
          :to="item.url_exibir
              ? item.url_exibir
              : { name: 'ExibirConteudo',
                  params: { slug: slug, id: item.id, action: 'exibir' }
              }"
          v-html="title"
        />
      </div>
      <p
        class="q-pt-lg"
        style="word-break: break-word;"
        v-html="item.excerpt"
      ></p>
    </q-card-section>
    
  </q-card>
</template>
<script>
import {
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QImg,
  QSeparator,
  QIcon
} from "quasar";

export default {
  name: "PaginatorCard",
  props: {
    item: Object
  },
  components: { QCard, QCardSection, QCardActions, QBtn, QImg, QSeparator, QIcon },
  computed: {
    title() {
      let title = this.item.name ? this.item.name : this.item.title;

      return title.length > 70 ? title.substr(0, 70) + " ..." : title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : primary;
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    },
    getIcon() {
      console.log(this.item);
      return this.item.tipo.icon ? this.item.tipo.icon : this.item.category.name;
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
