<template>
  <div class="row">
    <form v-on:submit.prevent="send($event)" >
      conteudos
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { mapFields } from "vuex-map-fields";
import ShowErrors from "../components/ShowErrors.vue";

export default {
  name: "ConteudoForm",
  delay: 2000,
  components: {
    ShowErrors
  },
  data() {
    return {
      autocompleteItems: [],
      categories: [],
      license_id: "",
      canal_id: "",
      category_id: "",
      tipo_id: "",
      site: "",
      title: "",
      description: "",
      authors: "",
      source: "",
      image: "",
      tags: [],
      niveis: [],
      components: [],
      terms: false,
      is_approved: false,
      is_featured: false,
      is_site: false
    };
  },
  mounted() {
    if (this.$route.params.id) {
      this.fetchConteudo(this.$route.params);
    }
    this.fetchTiposForm();
    //this.fetchLicenses();
    //this.fetchCanaisForSelect();
  },
  computed: {
    ...mapState([
      "errors",
      "tiposForm",
      "conteudo",
      "licenses",
      "childsLicenses",
      "canais"
    ]),
    ...mapFields([])
  },
  methods: {
    ...mapActions([
      "fetchConteudo",
      "fetchTiposForm",
      "fetchLicenses",
      "fetchCanaisForSelect",
      "createConteudo",
      "updateConteudo"
    ]),
    send() {
      if (this.$route.params.id) {
        this.updateConteudo(this.getConteudo());
      } else {
        this.createConteudo(this.getConteudo());
      }
    },
    getConteudo() {
      return {
        license_id: this.license_id,
        canal_id: this.canal_id,
        category_id: this.category_id,
        tipo_id: this.tipo_id,
        site: this.site,
        title: this.title,
        description: this.description,
        authors: this.authors,
        source: this.source,
        image: this.image,
        tags: this.tags,
        niveis: this.niveis,
        components: this.components,
        terms: this.terms,
        is_approved: this.is_approved,
        is_featured: this.is_featured,
        is_site: this.is_site
      };
    }
  }
};
</script>
<style lang="scss" scoped>
/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4caf50;
}
</style>
