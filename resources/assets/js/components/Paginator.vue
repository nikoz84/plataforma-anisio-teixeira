<template>
  <div v-if="paginator">
    
    <!-- small class="text-center">
      {{paginator.total}} 
      <a class="pointer" v-on:click="goToPage(paginator.prev_page_url)">
        Anterior
      </a>
      <a class="pointer" v-on:click="goToPage(paginator.next_page_url)">
        Próximo 
      </a>
    </!-->
    
    <q-infinite-scroll @load="onLoad" :offset="250">
      <q-card class="text-center">
        {{ paginator.total }} conteúdos
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
    
    <div class="jumbotron text-center" v-if="paginator.total == 0">
        Sem informações
    </div>
    <!--nav aria-label="paginador de resultados">
          <section class="jumbotron" v-if="paginator.total == 0">
             <h2>Sem Resultados</h2>
          </section>
          <ul class="pager" v-if="paginator.total > 0">
              <li class="previous">
                  <a class="pointer" v-on:click="goToPage(paginator.prev_page_url)">
                  <span class="glyphicon glyphicon-backward"></span> Anterior
                  </a>
              </li>
              <li class="next">
                  <a class="pointer" v-on:click="goToPage(paginator.next_page_url)">
                  Próximo <span class="glyphicon glyphicon-forward"></span> 
                  </a>
              </li>
          </ul>
      </!--nav -->
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
      if (this.paginator.next_page_url) {
        let resp = await axios.get(this.paginator.next_page_url);

        this.SET_PAGINATOR(resp.data.paginator);
        this.infiniteSrollData = this.infiniteSrollData.concat(
          this.paginator.data
        );
        done();
        //console.log(this.infiniteSrollData)
      }
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

