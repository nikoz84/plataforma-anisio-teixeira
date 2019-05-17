<template>
    <div>
      <div class="container-columns" v-if="paginator">
          <!-- LISTA -->
          <div class="column" v-for="(item, i) in paginator.data" :key="i">
                  <SimpleCard v-bind:item="item"></SimpleCard>
          </div>
      </div>
      <!-- PAGINATOR LINKS -->
      <nav aria-label="paginador de resultados" >
          <p class="text-center">{{ (paginator.total) ? `Total: ${paginator.total}` : `Sem Resultados` }}</p>
          <ul class="pager">
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
import SimpleCard from "../components/SimpleCardComponent.vue";
import { mapState, mapActions } from "vuex";

export default {
  name: "List",
  components: {
    SimpleCard
  },
  created() {},
  methods: {
    ...mapActions(["goToPage"])
  },
  computed: {
    ...mapState(["paginator"])
  }
};
</script>
<style lang="scss" scoped>
.container-columns {
  display: flex;
  flex-wrap: wrap;
  min-height: 90vh;
  padding: 0 4px;
}

.column {
  flex: 33%;
  padding: 0 4px;
}
</style>

