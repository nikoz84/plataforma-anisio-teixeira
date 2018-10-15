<template>
    <section>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <Card></Card>
            </div>
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
        items: {}
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

