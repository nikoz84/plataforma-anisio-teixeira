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
    <q-infinite-scroll @load="goToPage" :offset="250" v-if="infiniteSrollData">
      <section v-for="(item, i) in infiniteSrollData" :key="i">
              <SimpleCard v-bind:item="item"></SimpleCard>
      </section>
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
import { QInfiniteScroll, QSpinnerDots } from "quasar";
import { mapState, mapMutations } from "vuex";
import SimpleCard from "./SimpleCard.vue";

export default {
  name: "Paginator",
  data() {
    return {
      infiniteSrollData: []
    };
  },
  components: { QInfiniteScroll, QSpinnerDots, SimpleCard },
  mounted() {
    this.goToPage();
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async goToPage() {
      if (this.paginator.total > 0 && this.paginator.current_page == 1) {
        this.infiniteSrollData = this.paginator.data;
      }
      console.log(this.paginator.next_page_url);
      //let resp = await axios.get(paginator.next_page_url);
      //await this.SET_PAGINATOR(resp.data.paginator);
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

