<template>
  
</template>
<script>
import client from '../client.js';

export default {
    name: 'Paginator',
    props:['pag'],
    data() {
      return {

      }
    },
    computed:{
      next(){
        return this.pag.next_page_url;
      },
      prev(){
        return this.pag.prev_page_url;
      },
      total(){
        return this.pag.total;
      }
    },
    methods: {
      
    }

  }
</script>
<style lang="sass" scoped>

</style>

