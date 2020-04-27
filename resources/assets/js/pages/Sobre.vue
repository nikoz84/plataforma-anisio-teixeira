<template>
    <div class="q-ma-md">
      <div class="row wrap justify-center">
        <div class="q-mt-lg text-h6 text-grey-6" v-if="layout && layout.title_footer">
          {{capitalize}}
        </div>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row ">
        {{layout.description_footer}}
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row wrap justify-center">
        <div class="text-h6 text-grey-6">CANAIS DA PLATAFORMA</div>
      </div>
      <div class="row wrap justify-center items-start content-start q-gutter-x-md q-gutter-y-md">
        <a v-for="(link, i) in links"
                :key="`links-${i}`" 
                :href="`/${link.slug}/listar`" 
                v-text="link.name"
                :title="`endereço para o canal:  ${link.name}`"
                style="color:#0071bc;">
          </a>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row wrap justify-center">
        <div class="text-h6 text-grey-6">INSTITUTO ANÍSIO TEIXEIRA</div>
      </div>
      <div class="row wrap justify-center" v-if="layout && layout.contact">
        <small>Estrada da muriçoca S/Nº, {{layout.contact.city}} | Tel. {{layout.contact.phone}}</small>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row wrap justify-center">
        <div class="text-h6 text-grey-6">SECRETARIA DA EDUCAÇÃO DO ESTADO DA BAHIA</div>
      </div>
      <div class="row wrap justify-center">
        <small>5ª Avenida Nº550, Centro Administrativo da Bahia - CAB, Salvador, Bahia, Brasil, CEP: 41.745-004 | Tel. (+55) 71 3115-8933, 3115-9033 e 3115-1401</small>
      </div>
      <div class="row wrap justify-center items-start content-start q-gutter-x-md q-gutter-y-md">
        <a target="_blank"
                v-for="(link, i) in layout.secretaria"
                :key="`links-${i}`" 
                :href="link.url" 
                v-text="link.title"
                :title="`endereço do portal da educação para:  ${link.title}`"
                style="color:#0071bc;">
          </a>
        
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row wrap justify-center" v-if="layout && layout.marcas">
        <q-img alt="imagem de marcas" aria-label="imagem" style="max-width: 741px; height: auto;" v-if="layout.marcas.is_active" :src="layout.marcas.url"></q-img>
      </div>
      <q-separator class="q-mt-md q-mb-lg" />
      <div class="row wrap justify-center">
        <b class="q-mt-lg">Todos os direitos e conteúdos desta Plataforma são de uso compartilhado, exceto onde indicado de outra forma.</b>
      </div>
      <div class="row wrap justify-center" v-if="layout && layout.marcas">
        <q-img alt="creative commond imagem" aria-label="imagem" style="max-width: 180px; height: auto;" src="/img/creative-commons.svg"></q-img>
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
    ...mapState(["layout", "links"]),
    capitalize() {
      let string = 'Sobre a ' + this.layout.title_footer;
      return string.toUpperCase()
    }
  },
  methods: {}
};
</script>
<style lang="stylus" scoped>
a {
  font-size: 18px;
}
</style>