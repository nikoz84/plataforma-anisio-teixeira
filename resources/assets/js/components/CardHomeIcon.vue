<template>
  <section>
    <div class="text-h5 title-page text-center q-px-md q-py-lg text-primary" v-text="title"></div>
    <div class="row justify-center q-gutter-sm" v-if="items">
      <q-card class="col-sm-2" v-for="(item, i) in items" :key="`item-${i}`">
        <q-card-section style="word-break:break-word;">
        </q-card-section>
          <q-card-section class="row justify-center">
            <q-avatar>
              <q-img
                :rounded-borders="rounded"
                :alt="`icone: ${item.name}`"
                :aria-label="item.name"
                :src="item.icon"
                loading="lazy"
                placeholder-src="/img/fundo-padrao.svg"
              />
            </q-avatar>
          </q-card-section>
          <q-card-actions vertical align="center">
            <q-btn
              :aria-label="`Buscar por ${item.name}`"
              style="word-break:break-word"
              :label="item.name"
              flat
              size="13px"
              color="accent"
              :to="item.search_url"
            ></q-btn>
          </q-card-actions>
        </q-card>
    </div>
  </section>
</template>
<script>
export default {
  name: "CardHomeIcon",
  props: ["title", "items"],
  data() {
    return {
      rounded: false
    };
  }
};
</script>
