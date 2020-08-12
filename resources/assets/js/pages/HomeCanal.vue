<template>
    <section class="q-pa-md">
        <q-card>
          <q-card-section>
            <div class="row">
              <div class="col-1 col-sm-2 q-pa-lg" thumbnail>
                <q-img src="/img/sobre/info.svg" alt=""/>
              </div>
              <div class="col-11 col-sm-10 q-pl-md">
                <div class="text-h5">SOBRE </div>
                <div class="q-pt-md text-small" v-html="canal.description"></div>
              </div>
              <q-separator inset="item-thumbnail" color="orange" class="q-my-lg"/>
            </div>
          </q-card-section>
          <q-card-section v-if="canal && canal.options &&canal.options.complement_description">
            <div class="row" >
              <div class="col-1 col-sm-2 q-pa-lg" thumbnail>
                <q-img src="/img/sobre/o-que.svg" alt=""/>
              </div>
              <div class="col-11 col-sm-10 q-pl-md">
                <div class="text-h5">O Quê? </div>
                <div
                  class="q-pt-md">
                  {{canal.options.complement_description.que}}
                </div>
              </div>
              <q-separator inset="item-thumbnail" color="orange" class="q-my-lg"/>
            </div>
            <div class="row" >
              <div class="col-1 col-sm-2 q-pa-lg" thumbnail>
                <q-img src="/img/sobre/porque.svg" alt=""/>
              </div>
              <div class="col-11 col-sm-10 q-pl-md">
                <div class="text-h5">Por Quê? </div>
                <div class="q-pt-md">
                  {{canal.options.complement_description.porque}}
                </div>
              </div>
              <q-separator inset="item-thumbnail" color="orange" class="q-my-lg"/>
            </div>
            <div class="row">
              <div class="col-1 col-sm-2 q-pa-lg" thumbnail>
                <q-img src="/img/sobre/como.svg" alt=""/>
              </div>
              <div class="col-11 col-sm-10 q-pl-md">
                <div class="text-h5">Como? </div>
                <div class="q-pt-md">{{canal.options.complement_description.como}}</div>
              </div>
              <q-separator inset="item-thumbnail" color="orange" class="q-my-lg"/>
            </div>
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
