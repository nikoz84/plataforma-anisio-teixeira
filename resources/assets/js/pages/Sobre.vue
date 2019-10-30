<template>
    <div class="q-ma-md">
      <div class="row text-h5">
          Sobre a {{layout.title_footer}}
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row">
        {{layout.description_footer}}
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row">
        {{layout.contact.city}} <br/>
        {{layout.contact.email}} <br/>
        {{layout.contact.phone}} <br/>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row text-h5">
        Secretaria da Educação do Estado da Bahia
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row items-center q-gutter-x-sm q-gutter-y-xs">
        <a target="_blank"
              v-for="(link, i) in layout.secretaria"
              :key="`links-${i}`" 
              :href="link.url" 
              v-text="link.title"
              :style="`color:${link.color}`">
        </a>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row">
        <q-img style="height: 70px;" class="bg-primary" v-if="layout.marcas.is_active" :src="layout.marcas.url"></q-img>
      </div>
      
    </div>
</template>
<script>
import { mapActions, mapState } from "vuex";
import { QImg } from "quasar";

export default {
  name: "sobre",
  components: {
    QImg
  },
  data() {
    return {
      title: "Sobre"
    };
  },
  computed: {
    ...mapState(["layout"])
  },
  methods: {}
};
</script>
<style lang="stylus" scoped>
a {
  font-size: 18px;
}
</style>