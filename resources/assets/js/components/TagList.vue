<template>
    <div>
        <div class="text-h6" v-html="title"></div>
        <q-chip flat 
                color="primary" 
                text-color="white"
                icon="local_offer"
                v-for="(item, i) in items"
                :key="i"
                :label="item.name"
                clickable
                @click="searchBy(item)"
                >
        </q-chip>
    </div>    
</template>
<script>
export default {
  name: "TagList",
  props: ["items", "title", "slug"],
  methods: {
    searchBy(item) {
      let term = this.slug == "busca" ? item.name : item.id;
      let url = `/recursos-educacionais/listar?${this.slug}=${term}`;

      this.$router.push(url);
    }
  }
};
</script>

