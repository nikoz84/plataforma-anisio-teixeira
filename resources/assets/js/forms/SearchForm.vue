<template>
    <div class="row q-pa-md">
      <q-select
        filled 
        v-model="termo" 
        use-input
        stack-input
        clearable
        fill-input
        :options="options" 
        label="Pesquisar" 
        input-debounce="300"
        style="width:250px;"
        @filter="filterFn"
        bottom-slots
        >
    </q-select>
      
    <q-space></q-space>
    <q-btn size="15px"
        icon="add" 
        color="positive" 
        :to="`/admin/${$route.params.slug}/adicionar`" 
        title="Adicionar novo item"
        v-if="userCan()"/>
  </div>
</template>
<script>
import { QSelect, QItem, QItemSection, QSpace, LocalStorage } from "quasar";
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
      let can = null;
      if(LocalStorage.has('user')){
        const user = JSON.parse(LocalStorage.getItem('user'));
        let role = user.role;
        can = this.isLogged && role === 1 || role === 2 || role === 3;
      }
      
      return can;
    }
  }
};
</script>

