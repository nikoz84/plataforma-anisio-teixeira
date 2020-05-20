<template>
  <section class="q-pa-lg">
    <CarouselHome></CarouselHome>
    <!-- BOTÕES DAS MODALIDADES DE ENSINO #INÍCIO -->
    <div class="q-py-xl row justify-center q-gutter-xs">
    
      <q-btn stack size="sm" class="col-xs-5 col-sm-2" color="petecavermelho" text-color="white" label="Ensino Fundamental I" icon="img:img\biblioteca_icon_pb-49.svg" />
      <q-btn stack size="sm" class="col-xs-5 col-sm-2" color="petecaamarelo" text-color="white" label="Ensino Fundamental II" icon="img:img\biblioteca_icon_pb-49.svg" />
      <q-btn stack size="sm" class="col-xs-5 col-sm-2"  color="petecaazul" text-color="white" label="Ensino Médio" icon="img:img\biblioteca_icon_pb-49.svg" />
    
    </div>

    <!-- SESSÃO ADICINADOS RECENTEMENTE -->
    
    <a class="skip-link" href="#tipo-conteudos">Ir a adicionados recentemente</a>
    <!--CardHomeIcon
      id="adicionados-recentemente"
      title="Adicionados Recentemente"
      :items="null"
      v-if="null"
    ></CardHomeIcon-->
    
    <!-- TIPOS DE CONTEUDO -->
    <a class="skip-link" href="#tipo-conteudos">Ir a tipos de conteúdos</a>
    <CardHomeIcon
      id="tipo-conteudos"
      title="Tipos de Conteúdos"
      :items="tipos"
      v-if="tipos"
    ></CardHomeIcon>
    
    <!-- ENSINO MEDIO -->
    <a class="skip-link" href="#ensino-medio">Ir a disciplinas do ensino medio</a>
    <CardHomeIcon
      id="ensino-medio"
       v-if="disciplinas"
      :title="disciplinas.name"
      :items="disciplinas.componentes"
    ></CardHomeIcon>
    
    <!-- TEMAS TRANSVERSAIS -->
    <a class="skip-link" href="#temas">Ir a temas transversais</a>
    <CardHomeIcon
      id="temas"
      v-if="temas"
      :title="temas.name"
      :items="temas.componentes"
    ></CardHomeIcon>
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import { ClosePopup } from "quasar";
import { CarouselHome, CardHome, CardHomeIcon } from "@/components/home";
import {
  QParallax,
  ScrollFire,
  QBanner,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QAvatar,
  QBtnGroup
} from "quasar";

export default {
  name: "Home",
  directives: {
    ScrollFire
  },
  components: {
    QParallax,
    CardHome,
    QBanner,
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QAvatar,
    CardHomeIcon,
    QBtnGroup,
    CarouselHome
  },

  data() {
    return {
      ids: [
        {
          name: "conteudos-recentes",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "conteudos-destacados",
          animation: "slideInRight",
          show: false,
          data: []
        },
        {
          name: "conteudos-mais-baixados",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "conteudos-mais-acessados",
          animation: "bounceInRight",
          show: false,
          data: []
        },
        {
          name: "aplicativos-recentes",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "aplicativos-destacados",
          animation: "bounceInRight",
          show: false,
          data: []
        }
      ]
    };
  },
  computed: {
    ...mapState(["tipos", "componentes", "niveis"]),
    disciplinas() {
      if (this.niveis.length) {
        let niveis = this.niveis.filter(nivel => {
          if (nivel.id === 5) return nivel;
        });
        return niveis[0];
      }
    },
    temas() {
      if (this.componentes.length) {
        let componentes = this.componentes.filter(componente => {
          if (componente.id === 3) return componente;
        });
        return componentes[0];
      }
    }
  },
  methods: {
    async getDestaques(el) {
      let slug = "/destaques/" + el.id;

      if (el.classList.contains("load")) {
        this.$q.loading.show();
        let resp = await axios.get(slug);
        if (resp.status == 200 && resp.data.success) {
          this.pushData(el.id, resp.data.metadata, el);
          this.$q.loading.hide();
        }
        el.classList.remove("load");
      }
    },
    pushData(find, data, el) {
      const element = this.ids.find(item => item.name === find);
      element.show = true;
      el.classList.add(element.animation);
      element.data = data;
    }
  }
};
</script>
<style lang="stylus" scoped>
.q-carousel__slide{
  width: 100% !important;
  height : 25vh !important;
}
</style>
