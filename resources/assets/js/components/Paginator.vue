<template>
  <div v-if="paginator">
    <small class="text-center">
      {{paginator.total}} 
      <a class="pointer" v-on:click="goToPage(paginator.prev_page_url)">
        Anterior
      </a>
      <a class="pointer" v-on:click="goToPage(paginator.next_page_url)">
        Próximo 
      </a>
    </small>
    <section v-for="(item, i) in paginator.data" :key="i">
            <SimpleCard v-bind:item="item"></SimpleCard>
    </section>
    <div class="jumbotron text-center" v-if="paginator.total == 0">
        Sem informações
    </div>
    <nav aria-label="paginador de resultados">
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
      </nav>
  </div>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import SimpleCard from "./SimpleCard.vue";

export default {
  name: "Paginator",
  components: { SimpleCard },
  computed: {
    ...mapState(["paginator"]),
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async goToPage(page) {
      if(!page){
        return
      }
      let resp = await axios.get(page);
      console.log(resp.data)
      await this.SET_PAGINATOR(resp.data.paginator);
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

