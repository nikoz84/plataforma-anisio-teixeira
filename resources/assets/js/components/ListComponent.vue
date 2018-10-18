<template>
    <section>
        <ul class="list-unstyled" v-if="items" v-for="(item, i) in items" :key="i">
            <li class="panel panel-default" v-bind:id="item.id">
                <div class="panel-body">
                    <h4>{{ (item.name) ? item.name : item.title }}</h4>
                    <div class="pull-right">
                        <a >editar</a>
                        <a class="text-danger">deletar</a>
                    </div>
                </div>
            </li>
        </ul>
    </section>
</template>
<script>
import SimpleCard from '../components/SimpleCardComponent.vue';

export default {
    name : 'List',
    components:{
        SimpleCard
    },
    props:{
        title: String,
        items: Array
    },
    data() {
        return {
            
        }
    },
    methods:{
        
    }
}
</script>
<style lang="sass" scoped>

</style>

