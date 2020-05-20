<template>
  <nav>
    <q-list>
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
      <q-separator />
      <!-- ADMINISTRAÇÃO -->
      <q-item
        v-if="isLogged"
        clickable :to="{ name: 'IndexConteudos' }"
        aria-label="Painel de controle"
        @click="isPanel = !isPanel"
        >
        <q-item-section avatar >
          <q-icon name="settings_applications_outlined" />
        </q-item-section>
        <q-item-section>
          <q-item-label>
            {{ isPanel ? 'Links Canais': 'Painel de Controle' }}
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-separator/>
      <!-- HOME -->
      <q-item clickable 
        to="/" 
        aria-label="Inicio"
        exact 
        active-class="active-link-pat">
        <q-item-section avatar>
          <q-icon name="home" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Início</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
      
    </q-list>
    <!-- ADMINISTRAÇÃO-->
    <AdminLeftSideBar v-if="isPanel"></AdminLeftSideBar>
    <!-- CANAIS-->
    <q-list v-else>
      <q-item-label class="bg-grey-4" header>
        <strong class="grey-10">
          Canais
        </strong>
      </q-item-label>
      <div v-for="(link, i) in links" :key="`x-${i}`">
        <q-item
          tag="div"
          :to="`/${link.slug}/listar`"
          :aria-label="`IR: ${link.name}`"
          :title="`IR: ${link.name}`"
          clickable
          v-close-popup
          tabindex="0"
          active-class="active-link-pat"
        >
          <q-item-section>
            <q-item-label>{{ link.name }}</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
      </div>
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
    <q-list padding bordered>
      <q-expansion-item
        dense
        dense-toggle
        expand-separator
        label="Sobre a PAT"
      >
      <q-separator />
      <!-- SOBRE -->
      <q-item clickable 
        to="/sobre" 
        aria-label="sobre a plataforma"
        exact 
        active-class="active-link-pat">
        <q-item-section>
          <q-item-label>Sobre</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator/>
      <!-- GALERIA -->
      <q-item clickable 
        to="/galeria" 
        aria-label="visite a galería de imagens" 
        active-class="active-link-pat" 
        exact>
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
      }
    }
  },
  mounted() {
    this.isAdminPanel();
  },
  methods: {
    isAdminPanel(){
      let path = this.$route.path.split("/")[0];
      if(path === 'painel'){
        this.isPanel = true;
      }
    }
  },
};
</script>