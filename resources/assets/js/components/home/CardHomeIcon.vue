<template>

  <section>

    <div id="buttons_home">

      <ul class="hList">
        <li>
          <a class="menu">

            <div :class="`imagem_botoes-${id}`"></div>
            <h4
              class="menu-title"
              v-html="title"
              :id="id"
              :class="`item-${id}`"
            ></h4>

            <ul class="menu-dropdown">

              <li
                v-for="(item, i) in items"
                :key="`item-${i}`"
                :id="`id-${i}`"
                @click="goTo(item.search_url)"
              >

                <a>
                  <q-avatar
                    left
                    square
                  >
                    <img
                      lazyload
                      :src="item.icon"
                      alt="icone"
                      :class="`classe-img-b${i}`"
                    >
                  </q-avatar>
                </a> <a style="margin-left: auto;margin-right: auto;"><span>{{ item.name }}</span></a>

              </li>

            </ul>
          </a>
        </li>

      </ul>

    </div>

  </section>
</template>
<script>
import { QBtn, QAvatar } from "quasar";
export default {
  name: "CardHomeIcon",
  components: { QBtn, QAvatar },
  props: ["title", "items", "id"],
  components: {},
  data() {
    return {
      rounded: false,
    };
  },
  methods: {
    goTo(url) {
      this.$router.push(url);
    },
  },
};
</script>

<!--  STYLE CRIADO PARA A SEPARATRIZ DOS TÍTULOS -->

<style lang="stylus">
.separatriz {
  border: 1px solid;
  border-color: transparent;
  border-bottom-color: #c9c9c9;
  font-family: 'Lato', sans-serif, cursive;
}

.separatriz-6 {
  content: ' ';
  border-top: 6px solid;
  border-top-color: #066ab1;
  width: 80px;
  height: 10px;
  margin-top: -6px;
}
</style>
