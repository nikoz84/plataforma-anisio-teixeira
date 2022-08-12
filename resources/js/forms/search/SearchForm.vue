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
    >
    </q-select>
  </div>
</template>
<script>
import { mapMutations, mapState } from "vuex";

export default {
  name: "SearchForm",
  props: ["slug"],
  data() {
    return {
      termo: "",
      options: [],
      loadingState: false,
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged", "isLoading"]),
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", "SET_DATA"]),
    filterFn(val, update, abort) {
      this.SET_IS_LOADING(true);
      console.log(val);
      update(async () => {
        if (val === "" || val.length <= 2) {
          this.loadingState = false;
          return;
        } else {
          let url = `/${this.slug}/search/${val}`;
          const { data } = await axios.get(url);
          this.loadingState = false;
          this.SET_PAGINATOR(data.paginator);
        }
      });
    },
  },
};
</script>
