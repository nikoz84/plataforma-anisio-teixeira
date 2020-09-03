<template>
  
    <q-card class="card-hover" v-bind:id="item.id" v-if="item">
      <q-img
        clickable
        class="cursor-pointer"
        v-ripple
        @click="goTo(item)"
        alt="imagem destacada"
        :src="getImage"
        loading="lazy"
        width="100%"
        height="auto"
        :style="`height:230px;min-height: 230px; width: 100%;border-bottom: solid 2px #264b8f;`"
        placeholder-src="/img/fundo-padrao.svg"
      >
      </q-img>
      <q-card-section class="q-mb-md">
        <h6 @click="goTo(item)" class="text-h6 q-mt-md cursor-pointer" :title="`Título: ${title}`" v-html="title"></h6>
      </q-card-section>
      <q-card-actions class="flex justify-end absolute-bottom">
        <!-- q-btn
            @click="$router.push(item.url_exibir)"
            icon="visibility"
            title="Visualizar recurso"
          />
        <q-btn
            v-ripple 
            @click="showDialog(item)"
            icon="toc"
            title="Mais informações"
          / -->
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

      return title.length > 100 ? title.substr(0, 100) + " ..." : title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : 'primary';
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    }
  },
  methods: {
    goTo(item) {
      if(item && item.url_exibir) {
         this.$router.push(item.url_exibir) 
      } else {
        this.$router.push( { 
          name: 'ExibirConteudo',
          params: { slug: item.slug, id: item.id, action: 'exibir' }
        })
      }
    },
    showDialog(item){
      console.log(item)
    }
  }
};
</script>
<style lang="stylus" scoped>
.q-img__image {
  & .absolute-full {
    background-color: black;
  }
}
.text-h6 {
  font-weight: bold;
}

.card-hover:hover {
    transform: translateY(5px);
}
.card-hover{
  transition: transform .2s ease-out;
}
.text-h6{
  font-size:16px;
  font-weight : 600;
}
</style>
