<template>
    <article class="row q-mt-sm">
        <q-card class="" v-if="post">
            <q-card-section>
                <Title :title="post.title"></Title>
            </q-card-section>
            <q-card-section class="text-center">
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
              <TagList :items="post.categories" title="Categorias" slug="busca"></TagList>
            </q-card-section>
        </q-card>
    </article>
</template>
<script>
import { mapState } from "vuex";
import { QCard, QCardSection, QCardActions, QChip } from "quasar";
import Title from "./Title.vue";
import TagList from "./TagList.vue";

export default {
  name: "Post",
  components: { Title, TagList },
  computed: {
    ...mapState(["post", "canal"])
  }
};
</script>
<style lang="stylus">
.wp-caption .aligncenter {
  align-items: center;
}
</style>

