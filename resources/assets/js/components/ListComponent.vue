<template>
    <div>
        <div class="container-columns">
            <!-- LISTA -->
            <div class="column" v-if="pagMutate.data" v-for="(item, i) in pagMutate.data" :key="i">
                <SimpleCard v-bind:item="item"></SimpleCard>
            </div>
        </div>
        <!-- PAGINATOR -->
            <nav aria-label="paginador de resultados">
                <p class="text-center">{{ (pagMutate.total) ? `Total: ${pagMutate.total}` : `Sem Resultados` }}</p>
                <ul class="pager">
                    <li class="previous">
                        <a class="pointer" v-on:click="goTo(pagMutate.prev_page_url)">
                        <span aria-hidden="true">&larr;</span> Anterior
                        </a>
                    </li>
                    <li class="next">
                        <a class="pointer" v-on:click="goTo(pagMutate.next_page_url)">
                        Próximo <span aria-hidden="true">&rarr;</span>
                        </a>
                    </li>
                </ul>
            </nav>
    </div>
</template>
<script>
import SimpleCard from '../components/SimpleCardComponent.vue';
import Http from '../http.js';

const http = new Http;

export default {
    name : 'List',
    components:{
        SimpleCard
    },
    props:['paginator'],
    data(){
        return {
            
        }
    },
    computed:{
        pagMutate(){
            return this.paginator;
        }
    },
    methods:{
        async goTo(url) {
            if(url){
                let params ={ token: localStorage.token };
                this.$parent.show = false;
                let resp = await http.getDataFromUrl(url, params);
                if(resp.data.success){
                    this.$parent.paginator = resp.data.paginator;
                    this.$parent.show = true;
                }
            }
            
        }
    }
}
</script>
<style lang="scss" scoped>
.container-columns {
  display: flex;
  flex-wrap: wrap;
  min-height: 90vh;
  padding: 0 4px;
}

.column {
  flex: 33%;
  padding: 0 4px;
}
</style>

