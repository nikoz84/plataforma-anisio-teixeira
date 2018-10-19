<template>
    <div>
        <div  v-if="items" v-for="(item, i) in items" :key="i">
            <SimpleCard v-bind:item="item"></SimpleCard>
        </div>
    </div>
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

