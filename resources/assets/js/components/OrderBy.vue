<template>
  <q-btn-dropdown auto-close stretch dropdown-icon="arrow_drop_down" flat label="Ordenar Por">
        <q-list >
            <q-item clickable v-close-popup
                v-for="(filter, i) in filters" 
                :key="i"
                @click="search(filter.id)"
                >
                <q-item-section>{{filter.name}}</q-item-section>
            </q-item>
        </q-list>
    </q-btn-dropdown>
</template>

<script>
export default {
    name : "OrderBy",
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
        search(id) {
            let path = `/${this.$route.params.slug}/listar`;

            this.$router.replace({
                path,
                query: { ordenar: id }
            });
        }
    },
}
</script>

<style>

</style>