<template>
    <div>
        <q-select
        filled 
        v-model="termo" 
        use-input
        hide-selected
        fill-input
        :options="options" 
        label="Pesquisar" 
        input-debounce="300"
        style="width: 250px;padding-bottom: 32px;"
        @filter="filterFn"
        >
        <template v-slot:no-option>
          <q-item>
            <q-item-section class="text-grey">
              não encontrado
            </q-item-section>
          </q-item>
        </template>
      </q-select>
       
    </div>
</template>
<script>
import { QSelect, QItem, QItemSection } from "quasar";
import { mapMutations, mapState } from "vuex";

export default {
  name: "SearchForm",
  components: { QSelect, QItem, QItemSection },
  data() {
    return {
      termo: "",
      options: []
    };
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING"]),
    async onSearch() {
      if (!this.termo) return;

      let url = `/${this.$route.params.slug}/search/${this.termo}`;
      this.SET_IS_LOADING(true);
      let resp = await axios.get(url);

      if (resp.status == 200 && resp.data.paginator) {
        this.SET_IS_LOADING(false);
        this.SET_PAGINATOR(resp.data.paginator);
      }
    },
    filterFn(val, update, abort) {
      update(() => {
        if (val === "") {
          return;
        } else {
          let url = `/${this.$route.params.slug}/search/${val}`;
          axios.get(url).then(resp => {
            console.log(resp.data);
          });
        }
      });
      /*
      setTimeout(() => {
        update(() => {
          if (val === "") {
            this.options = stringOptions;
          } else {
            const needle = val.toLowerCase();
            this.options = stringOptions.filter(
              v => v.toLowerCase().indexOf(needle) > -1
            );
          }
        });
      }, 1500);

      */
    },

    abortFilterFn() {
      console.log("delayed filter aborted");
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

