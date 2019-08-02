<template>
  <div>
    
    <Table :paginator="paginator"></Table>
  </div>
</template>
<script>
import Table from "./Table.vue";
import { mapMutations, mapState } from "vuex";

export default {
  name: "Listar",
  components: { Table },
  data() {
    return {
      id: null,
      slug: this.$route.params.slug,
      action: this.$route.params.action
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
      console.log(this.$route.params);
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

      if (resp.data.success) {
        this.$q.loading.hide();
        this.SET_PAGINATOR(resp.data.paginator);
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
