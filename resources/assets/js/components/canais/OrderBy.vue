<template>
  <q-btn-dropdown auto-close stretch dropdown-icon="arrow_drop_down" icon="list_alt" flat label="Ordenar Por">
        <q-list >
            <q-item clickable v-close-popup 
                v-for="(filter, i) in filters" 
                :key="i"
                @click="replaceURL('ordenar', filter.id)"
                >
                <q-item-section>{{filter.name}}</q-item-section>
            </q-item>
        </q-list>
    </q-btn-dropdown>
</template>

<script>
import { QueryString } from '@mixins/QueryString';

export default {
    name : "OrderBy",
    mixins: [QueryString],
    data() {
        return {
            filters : [
                {id:'data', name:'Data publicação'},
                {id:'titulo', name:'Título'},
                {id:'downloads', name:'Mais Baixados'},
                {id:'acessos', name:'Mais Acessados'}
            ]
        }
    },
    methods: {
        
    },
}
</script>

<style>

</style>