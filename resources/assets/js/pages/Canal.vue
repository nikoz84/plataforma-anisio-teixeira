<template>
    <section class="container-fluid heigth">
        <div class="row">
            <aside class="col-sm-3">
                <div class="text-center"> 
                    <h3>Filtro</h3>
                </div>
                <SidebarCanal v-if="hasCategories" v-bind:categories="categories"></SidebarCanal>
            </aside>
            <article class="col-sm-9">
                <header class="page-header">
                    <h1 class="page-title" v-bind:style="`--color:${color}`">
                        {{ title }}
                    </h1>
                    <NavCanal></NavCanal>
                </header>
                <div>
                    <transition name="custom-classes-transition" 
                                enter-active-class="animated fadeIn" 
                                leave-active-class="animated fadeOut"
                                mode="out-in">
                        <router-view v-bind:style="`--color:${color}`"></router-view>
                    </transition>
                </div>
                    
            </article>
        </div>
    </section>
</template>
<script>
import NavCanal from '../components/NavCanalComponent.vue';
import SidebarCanal from '../components/SidebarCanalComponent.vue';
import Http from '../http.js';

const http = new Http();

export default {
    name : 'canal',
    components:{ NavCanal,  SidebarCanal},
    data() {
        return {
            title: '',
            descricao: null,
            canal_id: null,
            options: null,
            color: '#1e78c2',
            hasCategories: false,
            categories: null,
            hasAbout: false
        }
    },
    created() {
        
    },
    mounted() {
        this.getCanal();
    },
    watch: {
        '$route' (to, from) {
            this.getCanal();
        }
    },
    methods:{
        async getCanal(){
            let url = `/canais/slug/${this.$route.params.slug}`; 
            let resp = await http.getDataFromUrl( url );
            
            if(resp.data.success){
                this.canal_id = resp.data.canal.id;
                this.title = resp.data.canal.name;
                this.options = resp.data.canal.options
                this.color = this.options.color;
                this.hasAbout = this.options.has_about;
                this.hasCategories = this.options.has_categories;
                localStorage.setItem('canal_id', this.canal_id);
                console.log(this.hasCategories)
                if(this.hasCategories){
                    this.getCategories();
                }
            } 
        },
        async getCategories(){
            let params = {
                canal: this.canal_id
            }
            let resp = await http.getDataFromUrl('/categories', params);
            if(resp.data.success){
                this.categories = resp.data.categories;
            }
        }
    }
}
</script>
<style lang="scss" scoped>
.page-header { margin : 0; }

.page-header .page-title {
    margin-top: 0;
    position: relative;
    margin-bottom: 30px;
}
.page-header .page-title:after {
    width: 15%;
    height: 2px;
    content: '';
    background: var(--color);
    display: block;
    position: absolute;
    bottom: -10px;
}
:root {
    --background: var(--color);
} 
aside > header > h3 {
    margin-top: 5px;
    font-size: 18px;
}

</style>