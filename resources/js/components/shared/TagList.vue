<template>
  <div>
    <strong>{{ title }}:</strong>
    <div class="flex wordbreak">
      <a
        v-for="(item, i) in items"
        :key="`tag-${i}`"
        class="text-subtitle2 q-badge q-badge-single--line bg-dark q-ml-md q-mt-md text-decoration-none"
        v-html="item.name"
        :href="searchBy(item)"
        :title="`Procurar por palavra-chave: ${item.name}`"
      >
      </a>
    </div>
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

      return url;
    },
  },
};
</script>
