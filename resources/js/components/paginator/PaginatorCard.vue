<template>
  <q-card v-bind:id="item.id" v-if="item" class="bg-grey-2">
    <q-img
      clickable
      @click="goTo(item)"
      class="cursor-pointer card-borda-imagem"
      v-ripple
      :src="getImage"
      loading="lazy"
      :title="item.title"
      width="100%"
      height="auto"
      style="max-height:200px"
      :placeholder-src="`/img/fundo-padrao.svg`"
    />
    <q-card-section>
      <div class="row items-center no-wrap">
        <div class="col">
          <div
            class="cursor-pointer text-h6"
            v-html="item.short_title"
            :title="item.title"
            @click="goTo(item)"
          ></div>
          <div class="text-subtitle2" v-html="getTipo"></div>
        </div>

        <div class="col-auto">
          <q-btn color="grey-7" round flat icon="more_vert">
            <q-menu cover auto-close>
              <q-list>
                <q-item clickable @click="openPrevisualizar">
                  <q-item-section>Mais informações</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>
<script>
export default {
  name: "PaginatorCard",
  props: {
    item: Object,
  },
  computed: {
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
    openPrevisualizar() {
      console.log("oi");
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
