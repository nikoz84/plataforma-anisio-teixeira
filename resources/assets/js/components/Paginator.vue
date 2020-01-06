<template>
  <div class="" v-if="paginator">
    <q-card class="q-my-sm q-pl-sm">
      {{ paginator.total }} - itens encontrados
    </q-card>

    <q-infinite-scroll @load="onLoad" :offset="250">
      <div class="row justify-center q-gutter-x-lg">
        <SimpleCard
          class="col-xs-10 col-sm-5 col-md-3 col-lg-3 col-xl-2"
          v-for="(item, i) in infiniteSrollData"
          :key="i"
          v-bind:item="item"
        ></SimpleCard>
      </div>
      <template v-slot:loading>
        <div class="q-my-md">
          <q-spinner-dots color="primary" size="60px" />
        </div>
      </template>
    </q-infinite-scroll>

    <div class="jumbotron text-center" v-if="infiniteSrollData.length == 0">
      Sem registros encontrados
    </div>
  </div>
</template>
<script>
import { QInfiniteScroll, QSpinnerDots, QCard } from "quasar";
import { mapState, mapMutations } from "vuex";
import SimpleCard from "./SimpleCard.vue";

export default {
  name: "Paginator",
  data() {
    return {
      infiniteSrollData: []
    };
  },
  components: { QInfiniteScroll, QSpinnerDots, SimpleCard, QCard },
  mounted() {
    this.infiniteSrollData = this.infiniteSrollData.concat(this.paginator.data);
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async onLoad(index, done) {
      if (this.paginator.next_page_url && this.paginator.data.length > 0) {
        let params = this.queryStringToObject(this.paginator.next_page_url);
        console.log(params);
        let resp = await axios.get(this.paginator.next_page_url);

        this.SET_PAGINATOR(resp.data.paginator);
        this.infiniteSrollData = this.infiniteSrollData.concat(
          this.paginator.data
        );
        done();
        //console.log(this.infiniteSrollData)
      } else {
        done(true);
      }
    },
    queryStringToObject(str) {
      let url = new URL(window.location.origin + str);
      let queryString = url.searchParams.toString();

      let params = queryString
        .replace(/(^\?)/, "")
        .split("&")
        .map(
          function(n) {
            return (n = n.split("=")), (this[n[0]] = n[1]), this;
          }.bind({})
        )[0];

      return params;
    }
  }
};
</script>
<style lang="sass" scoped></style>
