<template>
  <nav aria-label="..." v-if="paginator.total">
    <p class="text-center">{{ (paginator.total) ? `Total: ${paginator.total}` : `Sem Resultados` }}</p>
    <ul class="pager">
      <li class="previous"><a v-on:click="goTo(paginator.prev_page_url)"><span aria-hidden="true">&larr;</span> Anterior</a></li>
      <li class="next"><a v-on:click="goTo(paginator.next_page_url)">Próximo <span aria-hidden="true">&rarr;</span></a></li>
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
        
        if(url)
        console.log(url)
        let idCanal = localStorage.getItem('idCanal');
        let data = new Http(idCanal);
        let resp = await data.getData(); 
        console.log(resp.data.per_page, resp.data.current_page);
        this.$parent.paginator = resp.data.paginator;
        
        

      }
    }
  
  }
</script>
<style lang="sass" scoped>

</style>

