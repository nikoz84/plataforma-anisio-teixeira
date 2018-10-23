<template>
    <div class="container-columns">
        <div class="column" v-if="items" v-for="(item, i) in items" :key="i">
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
<style lang="scss" scoped>
.container-columns {
  display: flex;
  flex-wrap: wrap;
  min-height: 90vh;
  padding: 0 4px;
}

.column {
  flex: 50%;
  padding: 0 4px;
}
</style>

