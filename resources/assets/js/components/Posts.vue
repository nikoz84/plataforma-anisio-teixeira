<template>
    <div>
        <div class="container-columns">
            <!-- LISTA -->
            <div class="column" v-for="(item, i) in posts" :key="i">
                   {{ item.title }}
            </div>
        </div>
    </div>
</template>
<script>
import {mapState} from 'vuex';
import SimpleCard from './SimpleCard.vue'

export default {
    name: "Posts",
    computed: {
        ...mapState(["posts"])
    },

}
</script>
<style lang="scss" scoped>

</style>