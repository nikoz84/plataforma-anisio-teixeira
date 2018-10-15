<template>
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <li>
        <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li>
        <a href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script>
  export default {
    name: 'Search',
    data() {
      return {
  
        placeholder: 'Busque em nosso repositorio de conteúdos'
  
      }
  
    },
  
    methods: {
      onSearch: function() {
        console.log('sad');
  
      }
    }
  
  }
</script>
<style lang="sass" scoped>

</style>

