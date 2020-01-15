<template>
    <article class="row q-mt-sm">
        <q-card class="" v-if="post">
            <q-card-section>
                <div class="text-h5" :style="`color:${canal.options.color};`" v-html="post.title"></div>
                <p>{{post.author}} - {{post.created_at}}</p>
                <q-separator class="q-mb-lg" />
            </q-card-section>
            <q-card-section v-html="post.content"></q-card-section>
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

