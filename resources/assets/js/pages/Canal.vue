<template>
    <section class="container-fluid heigth">
        <div class="row">
            <aside class="col-sm-3">
                <header class="text-center"> 
                    <h3>Filtro</h3>
                </header>
                <SidebarCanal></SidebarCanal>
            </aside>
            <article class="col-sm-9">
                <header class="page-header">
                    <h1 class="page-title" v-bind:style="`--color:${color}`" v-bind:stylepseudo="`after:`">{{ title }}</h1>
                    <NavCanal></NavCanal>
                </header>
                <section>
                    <transition name="fade" mode="out-in">
                        <router-view v-bind:color="color"></router-view>
                    </transition>
                </section>
                    
            </article>
        </div>
    </section>
</template>
<script>
import NavCanal from '../components/NavCanalComponent.vue';
import SidebarCanal from '../components/SidebarCanalComponent.vue';
import Http from '../http.js';

export default {
    name : 'canal',
    components:{ NavCanal,  SidebarCanal},
    data() {
        return {
            title: null,
            descricao: null,
            idCanal: null,
            options: null,
            color: '#1e78c2',
            hasCategories: false
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
            let canal = new Http();
            let resp = await canal.getDataFromUrl(url);
            
            this.idCanal = resp.data.canal.id;
            this.title = resp.data.canal.name;
            this.options = JSON.parse(resp.data.canal.options)
            this.color = this.options.color;
            this.hasCategories = this.options.has_categories;
            console.log(this.hasCategories);
            localStorage.setItem('idCanal', this.idCanal);
        }
    }
}
</script>
<style lang="scss" scoped>
.page-header { margin : 0; }
.page-header > h1 { font-size: 22px; }
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
.fade-enter {
  opacity: 0;
}
.fade-enter-active {
  transition: opacity 1s ease;
}
.fade-leave {}
.fade-leave-active {
  transition: opacity 1s ease;
  opacity: 0;
}
aside > header > h3 {
    margin-top: 5px;
    font-size: 18px;
}

</style>