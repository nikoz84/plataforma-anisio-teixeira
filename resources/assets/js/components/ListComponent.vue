<template>
    <section class="row">
        <div v-if="items" class="col-sm-6 col-lg-3" v-for="(key, item) in items" :key="key">
            <Card v-bind:item="item"></Card>
        </div>
    </section>
</template>
<script>
import Card from '../components/CardComponent.vue';

export default {
    name : 'List',
    components:{
        Card
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

