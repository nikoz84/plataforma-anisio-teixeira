<template>
  <div>
    <div>
        <h2>{{title}}</h2>
    </div>
      <div v-if="!isLoading" class="content">
        <table-app :paginator="paginator"></table-app>   
      </div>
      <loader v-else></loader>
  </div>
</template>
<script>
import Loader from "./Loader.vue";
import Table from "./Table.vue";
import { mapMutations, mapState } from "vuex";

export default {
  name: "Listar",
  components: {
    loader: Loader,
    "table-app": Table
  },
  data() {
    return {
      title: null,
      id: null,
      slug: "inicio",
      action: ""
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
    ...mapState(["paginator", "isLoading"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING"]),
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
      this.SET_IS_LOADING(true);

      let resp = await axios.get(`/${this.slug}`);

      if (resp.data.success) {
        this.SET_IS_LOADING(false);
        this.SET_PAGINATOR(resp.data.paginator);
      }
    },
    async getOne() {
      console.log("get one");
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
