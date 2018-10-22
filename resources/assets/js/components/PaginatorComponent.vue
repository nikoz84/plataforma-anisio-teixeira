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
  export default {
    name: 'Paginator',
    props:['paginator'],
    data() {
      return {
        
      }
  
    },
  
    methods: {
      goTo(url) {
        if(url)
        axios.get(url).then(resp => {
          this.$parent.paginator = resp.data.paginator;
        })
      }
    }
  
  }
</script>
<style lang="sass" scoped>

</style>

