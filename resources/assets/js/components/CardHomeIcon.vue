<template>
  <section>
    <div class="text-h5 title-page text-center q-py-lg" v-text="title"></div>
    <div class="row justify-center q-gutter-sm load" v-if="items">
      <q-card class="col-sm-2" v-for="(item, i) in items" :key="`item-${i}`">
        <q-card-section class="row justify-center">
          <q-avatar>
            <img
              rounded-borders
              :title="item.name"
              :src="
                `/storage/conteudos/conteudos-digitais/imagem-associada/${source}/${item.id}.svg`
              "
              :placeholder-src="`/img/fundo-padrao.svg`"
            />
          </q-avatar>
        </q-card-section>
        <q-card-actions vertical align="center">
          <q-btn
            style="word-break:break-word"
            :label="item.name"
            :to="goTo(item)"
          ></q-btn>
        </q-card-actions>
      </q-card>
    </div>
  </section>
</template>
<script>
export default {
  name: "CardHomeIcon",
  props: ["title", "items", "source"],
  methods: {
    goTo(item) {
      let to = `tipos=${item.id}`;
      if (this.source == "emitec") {
        to = `busca=${item.name}`;
      }

      return `recursos-educacionais/listar?${to}`;
    }
  }
};
</script>
