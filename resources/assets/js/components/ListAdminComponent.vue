<template>
    <div>
        <div>
            <h2>{{title}}</h2>
        </div>
        <div class="loading" v-if="loading">
            <loader></loader>
        </div>

        <div v-if="error" class="error">
            impossível recuperar dados
        </div>

        <div v-if="data" class="content">
            <ul>
                <li v-for="(item, i) in data" :key="i">
                    {{ (item.name) ? item.name : item.title }}  
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import client from "../client.js";
import loader from "./LoaderComponent.vue";

export default {
  name: "Listar",
  components: {
    loader
  },
  data() {
    return {
      paginator: {},
      title: null,
      id: null,
      slug: "inicio",
      action: "",
      loading: false,
      error: false,
      data: []
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
  methods: {
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
      this.loading = true;
      this.error = false;
      this.data = [];
      let resp = await client.get(`/${this.slug}`);
      this.response(resp);
    },
    async getOne() {
      console.log("get one");
      let resp = await client.get(`/${this.slug}/${this.id}`);
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
    },
    response(resp) {
      this.loading = false;
      console.log(resp.data);
      if (resp.data.success) {
        this.data = resp.data.paginator.data;
      } else {
        this.error = true;
      }
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
