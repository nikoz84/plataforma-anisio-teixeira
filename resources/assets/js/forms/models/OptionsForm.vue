<template>
  <article class="q-pa-md">
    <div :is="componentForm" :item="item"></div>
  </article>
</template>
<script>// @ts-nocheck


export default {
  name: "OptionsForm",
  components: {
    slider : () => import('./SliderForm.vue'),
    layout: () => import('./LayoutForm.vue'),
    estados: () => import('./EstadosForm.vue')
  },
  data() {
    return {
      componentForm: '',
      item: null
    };
  },
  mounted() {
    this.getOptions();
  },
  methods: {
    async getOptions() {
      let { data } = await axios.get(`/options/id/${this.$route.params.id}`);
      this.componentForm = data.metadata.name;
      this.item = data.metadata;
    }
  }
};
</script>