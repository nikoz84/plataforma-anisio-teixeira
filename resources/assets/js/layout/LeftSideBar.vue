<template>
  <nav>
    <q-list
      dense
      bordered
      padding
      separator
    >
      <q-item-label v-if="!$q.screen.gt.xs || !$q.screen.gt.sm">
        <q-btn flat dense @click="leftDrawerOpenModel = false" aria-label="Menu" icon="swap_horiz" />
        <BtnMarca></BtnMarca>
      </q-item-label>
      <!-- ADMINISTRAÇÃO -->
      <q-item v-if="isLogged" clickable to="/admin/conteudos/listar" aria-label="Painel de controle">
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
      <q-item clickable to="/" aria-label="Inicio" exact active-class="active-link-pat">
        <q-item-section avatar>
          <q-icon name="home" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Início</q-item-label>
        </q-item-section>
      </q-item>


    </q-list>

    <!-- CANAIS-->
    <q-list dense bordered padding separator v-if="links.length > 0">

      <q-item v-for="(link, i) in links" :key="`x-${i}`" :to="`/${link.slug}/listar`" :aria-label="`IR: ${link.name}`"
        :title="`IR: ${link.name}`" clickable v-close-popup :tabindex="i" active-class="active-link-pat">
        <q-item-section avatar>
          <q-icon size="50px" :name="`img:/img/icon-menu/${link.slug}.svg`" />
        </q-item-section>
        <q-item-section>
          <q-item-label>{{ link.name }}</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />

      <q-item :to="{path: '/rotinas-de-estudo/ensino-medio/semana-1' }" aria-label="IR: Rotinas de estudo"
        title="IR: Rotinas de estudo" clickable v-close-popup active-class="active-link-pat" tabindex="16">
        <q-item-section avatar>
          <q-icon size="50px" :name="`img:/img/icon-menu/rotinas-de-estudo.svg`" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Rotinas de Estudo</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
      <q-item :to="{ path: '/ipes' }" aria-label="IR: Ações de Faculdades da Bahia"
        title="IR: Ações de Faculdades da Bahia" clickable v-close-popup active-class="active-link-pat" tabindex="20">
        <q-item-section avatar>
          <q-icon size="50px" :name="`img:/img/icon-menu/canal-das-universidades.svg`" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Canal das Universidades</q-item-label>
        </q-item-section>
      </q-item>
      <q-item :to="{name: 'canalAT'}" aria-label="IR: Canal Anísio Teixeira" title="IR: Canal Anísio Teixeira" clickable
        v-close-popup active-class="active-link-pat" tabindex="21">
        <q-item-section avatar>
          <q-icon size="50px" :name="`img:/img/icon-menu/canal-anisio-teixeira.svg`" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Canal Anísio Teixeira</q-item-label>
        </q-item-section>
      </q-item>
      <q-item @click="goToColaborativus" aria-label="`endereço para: Ambiente virtual de aprendizagem`"
        :title="`endereço para: ambiente virtual de aprendizagem Moodle`" clickable v-close-popup tabindex="25">
        <q-item-section avatar>
          <q-icon size="50px" :name="`img:/img/icon-menu/colaborativus.svg`" />
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
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section>
          <q-item-label>
            <q-skeleton type="text" width="60%" />
          </q-item-label>
        </q-item-section>
      </q-item>
    </q-list>

    <q-list dense bordered>
      <q-expansion-item dense dense-toggle expand-separator label="Sobre a PAT">
        <q-separator />
        <!-- SOBRE -->
        <q-item clickable to="/sobre" aria-label="sobre a plataforma" exact active-class="active-link-pat">
          <q-item-section>
            <q-item-label>Sobre</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
        <!-- GALERIA -->
        <q-item clickable to="/galeria" aria-label="visite a galería de imagens" active-class="active-link-pat" exact>
          <q-item-section>
            <q-item-label>Galeria</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
      </q-expansion-item>
    </q-list>
  </nav>
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