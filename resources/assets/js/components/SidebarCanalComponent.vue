<template>
<div>
    <nav role="menu categorias" v-if="categoriesExists">
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', params: { slug : $route.params.slug }}">
                <a>Todos</a>
            </router-link>
            <!-- CATEGORIAS -->
            <li v-for="(category, c) in sidebar.categories" v-bind:key="c">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: category.id }}" exact>
                <a>{{ category.name }}</a>
                </router-link>
                <!-- SUBCATEGORIAS -->
                <ul v-if="category.sub_categories && category.sub_categories.length > 0">
                    <li v-for="(subcategory, s) in category.sub_categories" v-bind:key="s" >
                        <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: subcategory.id }}" exact>
                        <a>{{ subcategory.name }}</a>
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul> 
    </nav>
    <nav role="menu disciplinas ensino medio" 
         v-if="disciplinasExists" 
         :style="'margin-top:30px;'">
        <h5 class="text-center">Disciplinas</h5>
        <ul class="nav nav-pills nav-stacked">
            <li  v-for="(disciplina, d) in sidebar.disciplinas[0].components" :key="d">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: $route.query.categoria, disciplina: disciplina.id }}" exact>
                <a>{{ disciplina.name }}</a>
                </router-link>
            </li>
        </ul>
    </nav>
    <nav role="menu temas transversáis" 
         v-if="temasExists"
         :style="'margin-top: 30px;'">
        <h5 class="text-center"
            :style="'margin-bottom: 20px;'">Temas Transversáis</h5>
        <ul class="nav nav-pills nav-stacked">
            <li  v-for="(tema, t) in sidebar.temas[0].components" :key="t">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: $route.query.categoria, tema: tema.id }}" exact>
                <a>{{ tema.name }}</a>
                </router-link>
            </li>
        </ul>
    </nav>
    <nav role="menu tipos de mídias" v-if="tiposExists">
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
import client from '../client.js';

export default {
    name : 'SidebarCanal',
    props:['sidebar'],
    data(){
        return {
            checkedTipos: [],
            checkedLicenses: [],
            checkedComponents: [],
            isVisible: false
        }
    },
    computed:{
        categoriesExists(){
            return (this.sidebar && this.sidebar.categories) ? true : false;
        },
        disciplinasExists(){
            return (this.sidebar && this.sidebar.disciplinas[0]) ? true : false;
        },
        temasExists(){
            return (this.sidebar && this.sidebar.temas[0]) ? true : false;
        },
        tiposExists(){
            return (this.sidebar && this.sidebar.tipos) ? true : false;
        },
        licensesExists(){
            return (this.sidebar && this.sidebar.licenses) ? true : false;
        },
        componentsExists(){
            return (this.sidebar && this.sidebar.components) ? true : false;
        },
        NiveisExists(){
            return (this.sidebar && this.sidebar.niveis) ? true : false;
        }
    },
    methods:{
        addToQuery(){
            this.$router.push({ name: 'Listar', 
                            params: { slug : this.$route.params.slug }, 
                            query: {
                                tipos : [this.checkedTipos],
                                licencas: [this.checkedLicenses],
                                componentes: [this.checkedComponents] }
                            });
        }
    }

}
</script>
<style lang="scss" scoped>

</style>
