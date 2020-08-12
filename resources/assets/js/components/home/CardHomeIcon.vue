<template>
  <section>
    <div class="text-h5 title-page text-primary separatriz q-pb-md" v-text="title"></div>
    <div class="separatriz-6"></div>
    <div class="row justify-center q-py-lg q-gutter-lg">
      
      <q-btn class="q-py-xl"
        stack
        v-for="(item, i) in items" 
        :key="`item-${i}`" 
        :to="item.search_url"
        :aria-label="item.name" 
        style="width: 200px"
        >
          <q-avatar left square>
            <img lazyload :src="item.icon" alt="icone">
          </q-avatar>
          <div>{{item.name}}</div>
      </q-btn>
    </div>
  </section>
</template>
<script>
export default {
  name: "CardHomeIcon",
  props: ["title", "items"],
  data() {
    return {
      rounded: false
    };
  }
};
</script>

<!--  STYLE CRIADO PARA A SEPARATRIZ DOS TÍTULOS -->

<style lang="stylus">

  .separatriz
    border 1px solid
    border-color transparent
    border-bottom-color #c9c9c9
    font-family: 'Lato', sans-serif, cursive
  
  .separatriz-6
    content " "
    border-top 6px solid
    border-top-color #066ab1
    width 80px
    height 10px
    margin-top -6px
  
</style>
