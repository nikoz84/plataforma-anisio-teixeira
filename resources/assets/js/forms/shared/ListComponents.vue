<template>
    <q-list>
        <q-item  
        v-ripple v-for="(component, i) in componentes"
        :key="`child-com-${i}`">
        <q-item-section avatar>
            <q-checkbox
            v-model="conteudo.componentes"
            :val="component.id"
            color="negative"
            />
        </q-item-section>
        <q-item-label class="q-pt-sm">
            {{component.name}}
        </q-item-label>
        </q-item>
    </q-list>
</template>

<script>
export default {
    name : 'ListComponents',
    props: ['componentes'],
    

}
</script>

<style>

</style>