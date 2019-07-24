<template>
    <section class="q-pa-md">
        <q-card>
          <q-card-section>
            <q-avatar class="absolute-top-rigth">
              <img src="/storage/conteudos/geral/icone-sobre-canal.png" alt="" style="background-color: #051825;">
            </q-avatar>
            <div v-html="canal.description"></div>
          </q-card-section>
          <q-separator inset />
          <q-card-section v-if="canal.options && canal.options.complement_description.que">
            <q-list>
              <q-item>
                <q-item-section avatar>
                  <q-avatar>
                    <img src="/storage/conteudos/geral/icone-o-que.png" alt="" style="background-color: #051825;"/>
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">
                    O quê?
                  </q-item-label>
                  <q-item-label lines="2">
                    {{canal.options.complement_description.que}}
                  </q-item-label>
                </q-item-section>
              </q-item>
              <q-separator inset="item" />
              <q-item>
                <q-item-section avatar>
                  <q-avatar>
                    <img src="/storage/conteudos/geral/icone-por-que.png" alt="" style="background-color: #051825;"/>
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">
                    Por Quê?
                  </q-item-label>
                  <q-item-label lines="2">
                    {{canal.options.complement_description.porque}}
                  </q-item-label>
                </q-item-section>
              </q-item>
              <q-separator inset="item" />
              <q-item>
                <q-item-section avatar>
                  <q-avatar>
                    <img src="/storage/conteudos/geral/icone-como.png" alt="" style="background-color: #051825;">
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">
                    Como?
                  </q-item-label>
                  <q-item-label lines="2">
                    {{canal.options.complement_description.como}}
                  </q-item-label>
                </q-item-section>
              </q-item>
              <img >
            </q-list>
          </q-card-section>
        </q-card>
    </section>
</template>
<script>
import { mapState } from "vuex";
import {
  QCard,
  QCardSection,
  QBtn,
  QList,
  QAvatar,
  QItem,
  QItemSection,
  QItemLabel,
  QSeparator
} from "quasar";

export default {
  name: "HomeCanal",
  components: {
    QCard,
    QCardSection,
    QBtn,
    QList,
    QAvatar,
    QItem,
    QItemSection,
    QItemLabel,
    QSeparator
  },
  computed: {
    ...mapState(["canal"])
  }
};
</script>
<style lang="stylus" scoped>
</style>