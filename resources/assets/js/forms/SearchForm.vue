<template>
    <div class="row">
        <q-select
        filled 
        v-model="termo" 
        use-input
        stack-label
        fill-input
        :options="options" 
        label="Pesquisar" 
        input-debounce="400"
        style="width:250px;"
        @filter="filterFn"
        >
      </q-select>
      
      <q-space></q-space>
      <q-btn size="md" 
            icon="add" 
            color="positive" 
            :to="`/admin/${$route.params.slug}/adicionar`" 
            title="Adicionar novo item"
            v-if="userCan()"/>
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
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING"]),
    async onSearch() {
      if (!this.termo) return;

      let url = `${this.$route.params.slug}/search/${this.termo}`;
      this.$q.loading.show();
      let resp = await axios.get(url);

      if (resp.status == 200 && resp.data.paginator) {
        this.$q.loading.hide();
        this.SET_PAGINATOR(resp.data.paginator);
      }
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
    },
    userCan(){
      let user = JSON.parse(localStorage.user);
      
      return this.isLogged && user.role === 1 || user.role === 2 || user.role === 3;
    }
  }
};
</script>

