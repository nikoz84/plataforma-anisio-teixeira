<template>
  <div v-if="paginator">
    
    
    <q-infinite-scroll @load="onLoad" :offset="250">
      <q-card class="q-mt-sm text-center">
        {{ paginator.total }} - itens encontrados
      </q-card>
      <div v-for="(item, i) in infiniteSrollData" :key="i">
        <SimpleCard v-bind:item="item"></SimpleCard>
      </div>
      <template v-slot:loading>
        <div class="row justify-center q-my-md">
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
        console.log(params)
        let resp = await axios.get(this.paginator.next_page_url);

        this.SET_PAGINATOR(resp.data.paginator);
        this.infiniteSrollData = this.infiniteSrollData.concat(
          this.paginator.data
        );
        done();
        //console.log(this.infiniteSrollData)
      }else {
        done(true)
      }
    },
    queryStringToObject(str){
      let url = new URL(window.location.origin + str);
      let queryString = url.searchParams.toString();
      
      let params = queryString.replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
      
      return params;
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

