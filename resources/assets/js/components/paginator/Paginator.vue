<template>
  <div>
    <div class="row justify-center q-my-lg">

      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="current"
        :max="paginator.last_page"
        :max-pages="10"
        direction-links
        icon-prev="west"
        icon-next="east"
        boundary-numbers
        @input="getData"
      >
      </q-pagination>
    </div>
    <div class="row justify-center q-gutter-x-md q-gutter-y-md">
      <PaginatorCard
        class="col-xs-10 col-sm-4 col-md-3 col-lg-3 col-xl-2"
        v-for="(item, i) in paginator.data"
        :key="i"
        v-bind:item="item"
      ></PaginatorCard>
    </div>
    <div class="row justify-center q-my-lg ">
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="current"
        :max="paginator.last_page"
        :input="true"
        direction-links
        push
        @input="getData"
      >
      </q-pagination>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import PaginatorCard from "./PaginatorCard";

export default {
  name: "Paginator",
  components: {
    PaginatorCard,
  },
  data() {
    return {
      current: 0,
    };
  },

  mounted() {
    if (isNaN(this.current)) {
      this.current = 1;
    }

    this.getData(this.current);
  },
  updated() {
    // alert(this.current);

    sessionStorage.removeItem("pagina_canais");
    sessionStorage.setItem("pagina_canais", this.current);
  },
  destroyed() {
    // alert(this.current);

    sessionStorage.setItem("pagina_canais", 1);
  },
  computed: {
    ...mapState(["paginator"]),
  },
  created() {
    this.current = parseInt(sessionStorage.getItem("pagina_canais"));

    // this.page = parseInt(sessionStorage.getItem("pagina"));
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async getData(page) {
      // alert(page);
      this.$q.loading.show();
      console.log(page);
      const { data } = await axios.get(this.paginator.path + `&page=${page}`);
      if (data.success) {
        this.SET_PAGINATOR(data.paginator);
        let pagina = page;
      }
      this.current = page;
      this.$q.loading.hide();
    },
  },
};
</script>

<style>
</style>