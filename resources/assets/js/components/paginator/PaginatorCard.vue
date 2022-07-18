<template>

  <q-card @click="goTo(item)" class="card-hover q-pa-sm bg-grey-2  cursor-pointer" v-bind:id="item.id" v-if="item" flat>
    
      <q-img clickable class="cursor-pointer card-borda-imagem" v-ripple 
        :src="getImage" loading="lazy" width="100%" height="auto" placeholder-src="/img/fundo-padrao.svg">
      </q-img>
      <q-card-section class="q-pl-none">
        <q-chip class="q-ml-none" color="light" size="md" icon="" v-html="getTipo">
        </q-chip>
        <div class="yt-title q-pt-xs" v-html="title">
        </div>
      </q-card-section>
      <q-tooltip class="bg-light text-body2 shadow-4" :offset="[10, 10]">Título: {{title}} <br> Tipo: {{ getTipo }}
      </q-tooltip>
      <q-card-actions class="flex justify-end absolute-bottom">
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
  QIcon,
} from "quasar";

export default {
  name: "PaginatorCard",
  props: {
    item: Object,
  },
  components: {
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QImg,
    QSeparator,
    QIcon,
  },
  computed: {
    title() {
      let title = this.item.name ? this.item.name : this.item.title;

      return title.length > 100 ? title.substr(0, 100) + " ..." : title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : "primary";
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    },
  },
  methods: {
    goTo(item) {
      if (item && item.url_exibir) {
        this.$router.push(item.url_exibir);
      } else {
        this.$router.push({
          name: "ExibirConteudo",
          params: { slug: item.slug, id: item.id, action: "exibir" },
        });
      }
    },
  },
};
</script>
<style lang="stylus">
.q-img__image {
  & .absolute-full {
    background-color: black;
  }
}

.text-h6 {
  font-weight: bold;
}

// .card-hover:hover {
//   transform: translateY(5px);
// }

.card-hover {
  transition: transform 0.2s ease-out;
}

.text-h6 {
  font-size: 16px;
  font-weight: 600;
}

.card-borda-imagem {
  height: 230px;
  min-height: 230px;
  width: 100%;
}

.card-borda-imagem {
    border-bottom: solid 3px #5ca0d4;
}

.yt-title{
  font-family: "Roboto","Arial",sans-serif;
    font-size: 1.3rem;
    line-height: 2rem;
    font-weight: 500;
    max-height: 4rem;
    overflow: hidden;
    display: block;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    white-space: normal;
}

.card-tooltip{
  background-color: blue;
}

</style>
