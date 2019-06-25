<template>
    <ul class="list-unstyled">
        <li v-for="(tipo, ti) in tipos" :key="ti" style="padding-left:5px;">
            <input type="checkbox"
                    :id="'tipo-' + tipo.id"
                    :value="tipo.id"
                    v-model="checkedTipos"
                    v-on:change="addToQuery">
            <label :for="'tipo-' + tipo.id">
                {{ tipo.name }}
            </label>
        </li>
    </ul>
</template>
<script>
import { mapState } from 'vuex';

export default {
    name: "TiposChechBox",
    data(){
        return {
            checkedTipos: []
        }
    },
    computed: {
        ...mapState(["tipos"])
    },
    methods: {
        addTipo(id){
            return console.log(id);
        }
    },

}
</script>