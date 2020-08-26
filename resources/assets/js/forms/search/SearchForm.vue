<template>
    <div class="row q-pa-md">
      <q-select
        filled 
        v-model="termo"
        hide-dropdown-icon
        dense
        use-input
        stack-input
        clearable
        fill-input
        :options="options" 
        label="Pesquisar" 
        input-debounce="200"
        style="width:250px;"
        @filter="filterFn"
        bottom-slots
        >
    </q-select>
    
  </div>
</template>
<script>
import { QSelect, QItem, QItemSection, QSpace } from "quasar";
import { mapMutations, mapState } from "vuex";

export default {
  name: "SearchForm",
  components: { QSelect, QItem, QItemSection, QSpace },
  data() {
    return {
      termo: "",
      options: []
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", 'SET_DATA']),
    async onSearch() {
      if (!this.termo) return;
      this.$q.loading.show();
      let url = `${this.$route.params.slug}/search/${this.termo}`;
      
      let { data }  = await axios.get(url);
      this.$q.loading.hide();
      this.SET_PAGINATOR(resp.data.paginator);
      
    },
    filterFn(val, update, abort) {
      update(() => {
        if (val === "") {
          return;
        } else {
          let url = `${this.$route.params.slug}/search/${val}`;
          axios.get(url).then(resp => {
            this.SET_PAGINATOR(resp.data.paginator);
          });
        }
      });
    }
  }
};
</script>

