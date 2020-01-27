<template>
    <article class="row q-mt-sm">
        <q-card class="" v-if="post">
            <q-card-section class="text-center">
                <div class="text-h5" :style="`color:${canal.options.color};`" v-html="post.title"></div>
            </q-card-section>
            <q-card-section class="q-my-lg text-center">
              <q-separator class="q-mb-lg" />
              <small>
                  Autor: 
                  <q-badge color="secondary">{{post.author}}</q-badge>
                </small>
                <small>
                  Publicado em: 
                  <q-badge color="secondary">{{post.created_at}}</q-badge>
                </small>
              <q-separator class="q-mt-lg" />
            </q-card-section>
            <q-card-section :class="`row justify-center q-mt-xl q-pa-xl`" 
                            v-html="post.content">
            </q-card-section>
            <q-card-section>
                <div class="text-h6">Categorias:</div>
                <q-chip color="ligth" 
                      icon="local_offer"
                      v-for="(category, i) in post.categories"
                      :key="i"
                      :label="category.name"
                      clickable
                      @click="onClick(category.name)"
                      >
                      
                </q-chip>
            </q-card-section>
        </q-card>
    </article>
</template>
<script>
import { mapState } from "vuex";
import { QCard, QCardSection, QCardActions, QChip } from "quasar";

export default {
  name: "Post",
  computed: {
    ...mapState(["post", "canal"])
  },
  methods: {
    onClick(name) {
      this.$router.push(`/recursos-educacionais/listar?busca=${name}`);
    }
  }
};
</script>
<style lang="stylus">
.wp-caption .aligncenter {
  align-items: center;
}
</style>

