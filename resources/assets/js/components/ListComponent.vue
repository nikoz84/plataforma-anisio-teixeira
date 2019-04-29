<template>
    <div>
        <div class="container-columns" v-if="paginator.data">
            <!-- LISTA -->
            <div class="column" v-for="(item, i) in paginator.data" :key="i">
                    <SimpleCard v-bind:item="item"></SimpleCard>
            </div>
        </div>
        <!-- PAGINATOR -->
            <nav aria-label="paginador de resultados">
                <p class="text-center">{{ (paginator.total) ? `Total: ${paginator.total}` : `Sem Resultados` }}</p>
                <ul class="pager">
                    <li class="previous">
                        <a class="pointer" v-on:click="goTo(paginator.prev_page_url)">
                        <span aria-hidden="true">&larr;</span> Anterior
                        </a>
                    </li>
                    <li class="next">
                        <a class="pointer" v-on:click="goTo(paginator.next_page_url)">
                        Próximo <span aria-hidden="true">&rarr;</span>
                        </a>
                    </li>
                </ul>
            </nav>
    </div>
</template>
<script>
import SimpleCard from "../components/SimpleCardComponent.vue";
import client from "../client.js";
import { mapGetters } from "vuex";

export default {
  name: "List",
  components: {
    SimpleCard
  },
  methods: {
    goTo(url) {
      if (url) {
        this.$store.dispatch("getConteudos", { url });
      }
    }
  },
  computed: {
    paginator() {
      return this.$store.getters.paginator;
    }
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

