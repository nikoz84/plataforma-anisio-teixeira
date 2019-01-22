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
        <h4 class="text-center">Disciplinas</h4>
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
        <h4 class="text-center"
            :style="'margin-bottom: 20px;'">Temas Transversáis</h4>
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
    <nav role="menu tipo de conteúdos" v-if="tiposExists">
        <h4>Tipo de Conteúdo</h4>
        <ul>
            <li v-for="(tipo, ti) in sidebar.tipos" :key="ti">{{ tipo.name }}</li>
        </ul>
        <h4>Licenças</h4>
        <ul>
            <li v-for="(license, li) in sidebar.licenses" :key="li">{{license.name}}</li>
        </ul>
        <h4>Componentes Curriculares</h4>
        <ul>
            <li v-for="(catComponent, com) in sidebar.components" :key="com">{{catComponent.name}}</li>
        </ul>
        <h4>Niveis de Ensino</h4>
        <ul>
            <li v-for="(nivel, ni) in sidebar.niveis" :key="ni">{{nivel.name}}</li>
        </ul>
    </nav>
</div>
</template>
<script>
import Http from '../http.js';

const http = new Http;

export default {
    name : 'SidebarCanal',
    props:['sidebar'],
    data(){
        return {
            
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
    }

}
</script>
<style lang="scss" scoped>

</style>
