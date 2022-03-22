<template>
  <q-scroll-area
    class="fit"
    :style="`background-color: rgb(237, 230, 230);`"
  >
    <nav>
      <q-list
        dense
        padding
        separator
      >
        <q-item-label v-if="!$q.screen.gt.xs || !$q.screen.gt.sm">
          <q-btn
            flat
            dense
            @click="leftDrawerOpenModel = false"
            aria-label="Menu"
            icon="swap_horiz"
          />
          <BtnMarca></BtnMarca>
        </q-item-label>

        <!-- ADMINISTRAÇÃO -->
        <q-item
          class="borda"
          v-if="isLogged"
          clickable
          to="/admin/conteudos/listar"
          aria-label="Painel de controle"
        >
          <q-item-section avatar>
            <q-icon name="settings_applications_outlined" />
          </q-item-section>
          <q-item-section>
            <q-item-label>
              Painel de Controle
            </q-item-label>
          </q-item-section>
        </q-item>
        <!-- HOME -->
        <q-item
          class="borda  bg-petecavermelho texto-branco"
          clickable
          to="/"
          aria-label="Inicio"
          exact
          active-class="active-link-pat"
        >
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Início</q-item-label>
          </q-item-section>
        </q-item>

        <q-expansion-item
          class="borda  bg-petecaazul texto-branco"
          dense
          dense-toggle
          expand-separator
          label="Sobre a PAT"
          icon="info"
        >

          <!-- SOBRE -->
          <q-item
            class="borda  bg-petecaazul  texto-branco "
            clickable
            to="/sobre"
            aria-label="sobre a plataforma"
            exact
            active-class="active-link-pat"
          >
            <q-item-section>
              <q-item-label>Sobre</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator />
          <!-- GALERIA -->
          <q-item
            class="borda  bg-petecaazul  texto-branco"
            clickable
            to="/galeria"
            aria-label="visite a galería de imagens"
            active-class="active-link-pat"
            exact
          >
            <q-item-section>
              <q-item-label>Galeria</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator />
        </q-expansion-item>

      </q-list>
      <q-separator />
      <!-- CANAIS-->
      <q-list
        padding
        striped
        v-if="links.length > 0"
      >

        <q-item
          class="borda"
          v-for="(link, i) in links"
          :key="`x-${i}`"
          :to="`/${link.slug}/listar`"
          :aria-label="`IR: ${link.name}`"
          :title="`IR: ${link.name}`"
          clickable
          v-close-popup
          :tabindex="i"
          :id="`menu-${i}`"
          :exact-active-class="`active-link-${link.slug}`"
        >
          <q-item-section avatar>
            <q-icon :name="`${link.icon}`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ link.name }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          class="borda"
          :to="{path: '/rotinas-de-estudo/ensino-medio/semana-1' }"
          aria-label="IR: Rotinas de estudo"
          title="IR: Rotinas de estudo"
          clickable
          v-close-popup
          active-class="active-link-pat"
          tabindex="16"
        >
          <q-item-section avatar>
            <q-icon name="ballot" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Rotinas de Estudo</q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          class="borda"
          :to="{ path: '/ipes' }"
          aria-label="IR: Ações de Faculdades da Bahia"
          title="IR: Ações de Faculdades da Bahia"
          clickable
          v-close-popup
          active-class="active-link-pat"
          tabindex="20"
        >

          <q-item-section avatar>
            <q-icon name="school" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Canal das Universidades</q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          class="borda"
          :to="{name: 'canalAT'}"
          aria-label="IR: Canal Anísio Teixeira"
          title="IR: Canal Anísio Teixeira"
          clickable
          v-close-popup
          active-class="active-link-pat"
          tabindex="21"
        >
          <q-item-section avatar>
            <q-icon name="emoji_objects" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Canal Anísio Teixeira</q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          class="borda"
          @click="goToColaborativus"
          aria-label="`endereço para: Ambiente virtual de aprendizagem`"
          :title="`endereço para: ambiente virtual de aprendizagem Moodle`"
          clickable
          v-close-popup
          tabindex="25"
        >
          <q-item-section avatar>
            <q-icon name="extension" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Colaborativus</q-item-label>
          </q-item-section>
        </q-item>
        <!--q-item
        :to="`/praticas-pedagogicas`"
        aria-label="`endereço para: Práticas Pedagogicas`"
        :title="`endereço para: práticas pedagogicas`"
        clickable
        v-close-popup
        tabindex="0"
      >
        <q-item-section>
          <q-item-label>Práticas Pedagógicas</q-item-label>
        </q-item-section>
      </q-item -->
      </q-list>

      <q-list
        dense
        bordered
        padding
        v-else
      >
        <q-item class="borda">
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label>
              <q-skeleton
                type="text"
                width="60%"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>

    </nav>
  </q-scroll-area>
</template>
<script>
import { mapState } from "vuex";
import { QList, QItem, QItemSection, QIcon } from "quasar";
import BtnMarca from "./BtnMarca.vue";
import AdminLeftSideBar from "./AdminLeftSideBar.vue";

export default {
  name: "LeftSideBar",
  components: { BtnMarca, AdminLeftSideBar },
  props: ["leftDrawerOpen"],
  data() {
    return {
      isPanel: false,
    };
  },
  computed: {
    ...mapState(["isLogged", "links", "canal"]),
    leftDrawerOpenModel: {
      get() {
        return this.leftDrawerOpen;
      },
      set(val) {
        this.$emit("update:leftDrawerOpen", val);
      },
    },
  },
  methods: {
    goToColaborativus() {
      window.open("http://colaborativus.pat.educacao.ba.gov.br", "_blank");
    },
  },
};
</script>