<template>
  <div v-if="paginator">
    <div class="container-columns" >
        <!-- LISTA -->
        <div class="column" v-for="(item, i) in paginator.data" :key="i">
                <SimpleCard v-bind:item="item"></SimpleCard>
        </div>
    </div>
    <nav aria-label="paginador de resultados">
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
import { mapState, mapMutations } from 'vuex';
import SimpleCard from './SimpleCard.vue';

export default {
    name: 'Paginator',
    components:{SimpleCard},
    computed:{
      ...mapState(["paginator"]),
      async goToPage(page){
        let resp = await axios.get(page);
        this.SET_PAGINATOR(resp.data.paginator);
      },
      total(){
        return this.paginator.total;
      }
    },
    methods: {
      ...mapMutations([
        "SET_PAGINATOR"
      ])
    }

  }
</script>
<style lang="sass" scoped>

</style>

