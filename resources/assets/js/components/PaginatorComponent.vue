<template>
  <nav aria-label="..." v-if="paginator.total">
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
</template>
<script>
import Http from '../http.js';

export default {
    name: 'Paginator',
    props:['paginator'],
    data() {
      return {

      }

    },

    methods: {
      async goTo(url) {
        if(url){
          let http = new Http();
          let resp = await http.getDataFromUrl(url);
          console.log(resp.data)  
          this.$parent.paginator = resp.data.paginator;
        }

      }
    }

  }
</script>
<style lang="sass" scoped>

</style>

