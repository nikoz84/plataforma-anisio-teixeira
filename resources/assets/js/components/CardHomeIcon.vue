<template>
  <section>
    <div class="text-h5 title-page q-px-md q-py-lg text-primary" v-text="title"></div>
    <div class="row q-gutter-md">
      <q-btn  
        v-for="(item, i) in items" 
        :key="`item-${i}`" 
        :to="item.search_url"
        :aria-label="item.name" 
        :label="item.name"
        >
          <q-avatar size="60px">
            <img class="q-pl-sm" :src="item.icon">
          </q-avatar>
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
