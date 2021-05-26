<template>
<div class="row justify-center q-my-lg" v-if="paginator && paginator.total == 0">
        
        <q-card>
          <q-card-section class="text-center">
            <p class="text-h6">Sem resultados</p>
          </q-card-section>
        </q-card>
</div>
</template>

<script>
export default {
    name: "SemResultados",
    props:["paginator"]
}
</script>

<style>

</style>