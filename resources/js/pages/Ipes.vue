<template>
  <div class="q-pa-md q-pb-xl">
    <header class="head q-pa-md">
      <h1 class="text-h4 color-primary">
        Canal das Universidades
      </h1>
    </header>

    <q-list bordered class="q-mt-md q-mb-xl">
      <q-expansion-item
        expand-separator
        dense-toggle
        group="ipes"
        icon="bookmarks"
        v-for="(item, i) in items"
        :key="i"
        :id="item.document.slug"
        :v-text="item.document.faculdade"
        class="ipes-label text-primary"
        :label="item.document.faculdade"
      >
        <q-card
          bordered
          class="ipes-atividade q-py-md"
          v-for="(action, a) in item.document.actions"
          :key="a"
        >
          <q-card-section>
            <strong>Ação:</strong> {{ action.name }} <q-space></q-space>
            <strong>Descrição:</strong> {{ action.description }}
          </q-card-section>
          <q-card-actions>
            <q-btn
              color="primary"
              icon-right="open_in_new"
              label="Acessar conteúdo"
              @click="goTo($event, action.link)"
              size="13px"
              padding="13px"
            />
          </q-card-actions>
        </q-card>
      </q-expansion-item>
    </q-list>
  </div>
</template>

<script>
export default {
  name: "Ipes",
  data() {
    return {
      items: [],
    };
  },
  created() {
    this.getIpes();
  },
  methods: {
    async getIpes() {
      const { data } = await axios.get("/planilhas?slug=ipes");

      this.items = data.paginator.data;
    },
    goTo(ev, url) {
      window.open(url, "_blank");
    },
  },
};
</script>

<style lang="stylus" scoped>

.ipes-label{
    font-size: 16 px;
    text-transform uppercase;
}

.ipes-label:nth-child(odd){
    background-color #eceff1 /** blue-grey-1 */
}

.ipes-label:hover{
    background-color #cfd8dc /** blue-grey-2 */
}

.ipes-label{
    background-color transparent
}

.ipes-atividade{
    font-size 16 px
    text-transform none;
}
</style>
