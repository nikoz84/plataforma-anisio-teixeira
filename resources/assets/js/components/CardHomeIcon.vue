<template>
  <section>
    <div class="text-h5 title-page q-px-md q-py-lg text-primary" v-text="title"></div>
    <div class="row justify-center q-gutter-xs">
      <q-btn
        stack
        v-for="(item, i) in items" 
        :key="`item-${i}`" 
        :to="item.search_url"
        :aria-label="item.name" 
        style="width: 200px"
        >
          <q-avatar left size="60px">
            <img :src="item.icon">
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
