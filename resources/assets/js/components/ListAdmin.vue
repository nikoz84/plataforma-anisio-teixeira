<template>
  <article>
    <div :is="componentName"></div>
  </article>
</template>
<script>
import Table from "./Table.vue";
import { mapMutations, mapState } from "vuex";
import ConteudoForm from "../forms/ConteudoForm.vue";
import AplicativoForm from "../forms/AplicativoForm.vue";
import CanalForm from "../forms/CanalForm.vue";
import UserForm from "../forms/UserForm.vue";
import LicenseForm from "../forms/LicenseForm.vue";
import TagForm from "../forms/TagForm.vue";
import RoleForm from "../forms/RoleForm.vue";
import Resumo from "../pages/Resumo.vue";

export default {
  name: "Listar",
  components: {
    Table,
    aplicativos: AplicativoForm,
    conteudos: ConteudoForm,
    canais: CanalForm,
    usuarios: UserForm,
    licencas: LicenseForm,
    tags: TagForm,
    roles: RoleForm,
    resumo: Resumo
  },
  data() {
    return {
      id: null,
      slug: this.$route.params.slug,
      action: this.$route.params.action,

      metadata: {},
      chartOptions: {
        chart: {
          id: "vuechart-example"
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998,1999]
        }
      },
      series: [
        {
          data: [
            {
              x: "Apple",
              y: 54
            },
            {
              x: "Orange",
              y: 66
            }
          ]
        }
      ],

      metadata: null,
      componentName: "",
      load: false,
      loadTable: true

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
      this.componentName = "Table";
      this.$q.loading.show();
      let resp = await axios.get(`/${this.slug}`);

      if (resp.data.success && resp.data.paginator) {
        this.$q.loading.hide();
        this.SET_PAGINATOR(resp.data.paginator);
      } else if (resp.data.success && resp.data.metadata) {
        this.$q.loading.hide();
        this.metadata = resp.data.metadata.tables;
        console.log(this.metadata);
      } else {
        this.$q.loading.hide();
        this.$router.push(`/admin/${this.slug}/listar`);
      }
    },
    async getOne() {
      this.$q.loading.show();
      let resp = await axios.get(`/${this.slug}/${this.id}`);
      this.response(resp);
    },
    async create() {
      console.log(`create ${this.slug}`);
      this.componentName = this.slug;
    },
    async update() {
      console.log("update");
      this.componentName = this.slug;
    },
    async delete() {
      console.log("delete");
      //this.componentName = "Confirm";
    }
  },
  watch: {
    $route(to, from, next) {
      this.getAction();
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
