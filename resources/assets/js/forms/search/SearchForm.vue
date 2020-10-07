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
        :loading="loadingState"
        fill-input
        :options="options" 
        label="Pesquisar" 
        input-debounce="400"
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
      options: [],
      loadingState: false
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", 'SET_DATA']),
    filterFn(val, update, abort) {
      const self = this;
      self.loadingState = true
      
      update(() => {
        if (val === "" || val.length <= 3) {
          self.loadingState = false;
          return;
        } else {
          let url = `${this.$route.params.slug}/search/${val}`;
          axios.get(url).then(resp => {
            self.loadingState = false;
            this.SET_PAGINATOR(resp.data.paginator);
          });
        }
      });
    }
  }
};
</script>

