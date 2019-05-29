<template>
<div>
    <Categories></Categories>
    <Temas></Temas> 
    <Disciplinas></Disciplinas>
    
    
    <nav role="menu tipos de mídias" v-if="false">
        <h5 data-toggle="collapse"
                    class="pointer" 
                   data-target="#collapse-tipos"
                   aria-expanded="false" 
                   aria-controls="#collapse-tipos">
                   Tipos de Mídia
                   <i class="glyphicon glyphicon-chevron-down pull-right" ></i>
        </h5>
        <ul class="collapse list-unstyled" id="collapse-tipos">
            <li v-for="(tipo, ti) in sidebar.tipos" :key="ti" style="padding-left:5px;">
                <input
                        type="checkbox"
                        :id="'tipo-' + tipo.id"
                        :value="tipo.id"
                        v-model="checkedTipos"
                        v-on:change="addToQuery">
                <label :for="'tipo-' + tipo.id">
                    {{ tipo.name }}
                </label>
            </li>
        </ul>
        <h5 data-toggle="collapse"
                    class="pointer" 
                   data-target="#collapse-licenses"
                   aria-expanded="false" 
                   aria-controls="#collapse-licenses">
                   Licenças
                   <i class="glyphicon glyphicon-chevron-down pull-right" ></i>
        </h5>
        <ul class="collapse list-unstyled" id="collapse-licenses">
            <li v-for="(license, li) in sidebar.licenses" :key="li" style="padding-left:5px;">
                <input type="checkbox"
                        :id="'license-' + license.id"
                        :value="license.id"
                        v-model="checkedLicenses"
                        v-on:change="addToQuery">
                <label :for="'license-' + license.id">
                    {{ license.name }}
                </label>
            </li>
        </ul>
        <ul class="list-unstyled">
            <li v-for="(categoriaComponent, cat) in sidebar.components" :key="cat" :id="'categoria-' + categoriaComponent.id">
                <h5 data-toggle="collapse"
                    class="pointer" 
                   :data-target="'#collapse-categoria-' + categoriaComponent.id"
                   aria-expanded="false" 
                   :aria-controls="'#collapse-categoria-' + categoriaComponent.id">
                    {{categoriaComponent.name}} 
                    <i class="glyphicon glyphicon-chevron-down pull-right" ></i>
                </h5>
                <ul class="collapse list-unstyled" :id="'collapse-categoria-' + categoriaComponent.id">
                    <li v-for="(component, com) in categoriaComponent.components" 
                        :key="com"
                        style="padding-left:5px;">
                        <input type="checkbox"
                               :id="'component-' + component.id"
                               :value="component.id" 
                               v-model="checkedComponents"
                               v-on:change="addToQuery">
                        <label :for="'component-' + component.id" v-text="component.name"></label>
                    </li>
                </ul>
            </li>
        </ul>
        
        <button class="btn btn-default" 
                v-on:click="isVisible =! isVisible">
            <b v-if="!isVisible">+</b>
            <b v-else>-</b>
        </button>
        <h5 style="padding-top:30px;padding-bottom:30px;" v-if="isVisible">
            Outras Modalidades / Níveis de Ensino
        </h5>
        <ul class="list-unstyled" v-if="isVisible">
            <li v-for="(nivel, ni) in sidebar.niveis" :key="ni" :id="'nivel-' + nivel.id">
                <h5 data-toggle="collapse"
                    class="pointer"
                    v-if="nivel.id != 12 && nivel.id != 13"
                    :data-target="'#collapse-nivel-' + nivel.id"
                    aria-expanded="false" 
                    :aria-controls="'#collapse-nivel-' + nivel.id">
                    {{nivel.name}}
                    <i class="glyphicon glyphicon-chevron-down pull-right"></i>
                </h5>
                
                <ul class="collapse list-unstyled" :id="'collapse-nivel-' + nivel.id">
                    <li v-for="(component, com) in nivel.components" :key="com" style="padding-left:5px;">
                        <input type="checkbox"
                               :id="'component-' + component.id"
                               :value="component.id" 
                               v-model="checkedComponents"
                               v-on:change="addToQuery">
                        <label :for="'component-' + component.id" v-text="component.name"></label>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</template>
<script>
import { mapState } from "vuex";
import Categories from "./Categories.vue";
import Temas from "./Temas.vue";
import Disciplinas from "./Disciplinas.vue";

export default {
  name: "SidebarCanal",
  components:{Categories,Temas, Disciplinas},
  data() {
    return {
      checkedTipos: [],
      checkedLicenses: [],
      checkedComponents: [],
      isVisible: false
    };
  },
  created() {
    
  },
  computed: {
    ...mapState(["sidebar"]),
  },
  methods: {
    addToQuery() {
      this.$router.push({
        name: "Listar",
        params: { slug: this.$route.params.slug },
        query: {
          tipos: [this.checkedTipos],
          licencas: [this.checkedLicenses],
          componentes: [this.checkedComponents]
        }
      });
    }
  },
};
</script>
<style lang="scss" scoped>
</style>
