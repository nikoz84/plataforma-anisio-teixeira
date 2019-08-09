<template>
  <article>
    <!-- TABELA COM PAGINAÇÃO -->
    <Table :paginator="paginator" v-if="this.$route.params.slug != 'analytics'"></Table>
    <q-card v-else class="q-mb-xl">
      <q-card-section>
        <h5 class="text-center" v-if="metadata.title">{{ metadata.title }}</h5> 
      </q-card-section>
      <q-card-section v-for="(table, i) in metadata.tables" :key="i">
        <q-table :title="table.title"
          :data="table.data"
          :columns="table.columns"
          :row-key="'id'"
          >
        </q-table>
      </q-card-section>
      <q-card-section v-if="metadata.blog">
        <q-table  :title="metadata.blog.title"
          :data="metadata.blog.data.posts"
          :columns="metadata.blog.columns"
          :row-key="'id'"
          >
         
        </q-table>
      </q-card-section>
    </q-card>

  </article>
</template>
<script>
import Table from "./Table.vue";
import { mapMutations, mapState } from "vuex";
import { QTable, QTh, QTr, QTd, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "Listar",
  components: { Table, QTable, QTh, QTr, QTd, QCard, QCardSection, QSeparator },
  data() {
    return {
      id: null,
      slug: this.$route.params.slug,
      action: this.$route.params.action,
      metadata: {}
    };
  },
  beforeRouteUpdate(to, from, next) {
    this.slug = to.params.slug;
    this.action = to.params.action;
    next();
  },
  created() {
    this.getAction();
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    getAction() {
      switch (true) {
        case this.action == "listar":
          this.getData();
          break;
        case this.action == "adicionar":
          this.create();
          break;
        case this.action == "editar":
          this.update();
          break;
        case this.action == "apagar":
          this.delete();
          break;
        case this.action == "exibir":
          this.getOne();
          break;
      }
    },
    async getData() {
      this.$q.loading.show();
      let resp = await axios.get(`/${this.slug}`);

      if (resp.data.success && resp.data.paginator) {
        this.$q.loading.hide();
        this.SET_PAGINATOR(resp.data.paginator);
      } else if (resp.data.success && resp.data.metadata) {
        this.$q.loading.hide();
        this.metadata = resp.data.metadata;
        console.log(this.metadata);
      } else {
        this.$q.loading.hide();
        this.$router.push();
      }
    },
    async getOne() {
      this.$q.loading.show();
      let resp = await axios.get(`/${this.slug}/${this.id}`);
      this.response(resp);
    },
    async create() {
      console.log("create");
    },
    async update() {
      console.log("update");
    },
    async delete() {
      console.log("delete");
    }
  },
  watch: {
    $route(to, from) {
      this.getAction();
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
