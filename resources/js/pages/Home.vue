<template>
  <section class="">
    <!-- BOTÕES CAROUSEL -->
    <CarouselHome></CarouselHome>

    <!-- PRÁTICAS INSPIRADORAS 

    <a class="skip-link" href="#praticas-inspiradoras">Ir a práticas inspiradoras</a>
    <PlayListHome id="praticas-inspiradoras"></PlayListHome>
    -->

    <q-card>
      <q-tabs
        v-model="tab"
        dense
        class="text-grey"
        active-color="primary"
        indicator-color="primary"
        align="justify"
        narrow-indicator
      >
        <q-tab name="tipo-conteudos" label="Tipos de Conteúdo" />
        <q-tab name="ensino-medio" label="Ensino Medio" />
        <q-tab name="temas-transversais" label="Temas Transversais" />
      </q-tabs>
      <q-separator />
      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="tipo-conteudos">
          <CardHomeIcon
            id="tipo-conteudos"
            title="Tipos de Conteúdo"
            :items="tipos"
            v-if="tipos"
            bg-sessao=""
          />
        </q-tab-panel>

        <q-tab-panel name="ensino-medio">
          <CardHomeIcon
            v-if="disciplinas"
            :title="disciplinas.name"
            :items="disciplinas.componentes"
            bg-sessao=""
          />
        </q-tab-panel>

        <q-tab-panel name="temas-transversais">
          <CardHomeIcon
            id="temas-transversais"
            v-if="temas"
            :title="temas.name"
            :items="temas.componentes"
            bg-sessao=""
          />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
    <!-- BOTÕES ROTINAS DE ESTUDO -->
    <a class="skip-link" href="#rotinas-de-estudo">Ir a rotinas de estudo</a>
    <HomeLinksRotinas id="rotinas-de-estudo"></HomeLinksRotinas>

    <!-- SESSÃO ADICINADOS RECENTEMENTE -->
    <a class="skip-link" href="#conteudos-recentes"
      >Ir a adicionados recentemente</a
    >
    <CardHome id="conteudos-recentes"></CardHome>
  </section>
</template>
<script>
import { mapState } from "vuex";
import {
  CarouselHome,
  CardHome,
  CardHomeIcon,
  HomeLinksRotinas,
} from "@/components/home";
import { ScrollFire } from "quasar";

export default {
  name: "Home",
  data() {
    return {
      tab: "tipo-conteudos",
    };
  },
  directives: {
    ScrollFire,
  },
  components: {
    CardHomeIcon,
    CarouselHome,
    HomeLinksRotinas,
    CardHome,
  },
  computed: {
    ...mapState(["tipos", "componentes", "niveis"]),
    disciplinas() {
      if (this.niveis.length) {
        let niveis = this.niveis.filter((nivel) => {
          if (nivel.id === 5) return nivel;
        });
        return niveis[0];
      }
    },
    temas() {
      if (this.componentes.length) {
        let componentes = this.componentes.filter((componente) => {
          if (componente.id === 3) return componente;
        });
        return componentes[0];
      }
    },
  },
};
</script>
