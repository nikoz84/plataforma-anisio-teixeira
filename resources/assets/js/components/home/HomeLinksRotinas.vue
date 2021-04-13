<template>
    <div>
        <div class="text-h5 title-page text-primary separatriz q-pb-md">
            Rotinas de Estudo
        </div>
        <div class="separatriz-6"></div>
        <div class="row justify-center q-py-lg q-gutter-lg">
            <q-btn v-for="(button, s) in buttons" 
                :key="`${s}`"
                size="md" 
                push
                class="col-xs-5 col-sm-3" 
                :color="button.color" 
                text-color="white"
                :to="`/rotinas-de-estudo/${button.slug}`"
                :title="`Rotinas de estudo ${button.label}`"
                :label="button.label">
                <q-avatar 
                    left
                    alt="Marca"
                    title="marca"
                    aria-label="Marca da plataforma Anísio Teixeira">
                    <img class="q-pa-sm" lazyload src="/img/sprite/peteca-icon-branco.svg" alt="icone">
                </q-avatar>
            </q-btn>
        </div>
    </div>
</template>

<script>
import { QBtn, QAvatar } from 'quasar';
export default {
    name: "HomeLinksRotinas",
    components:{QBtn, QAvatar},
    data() {
        return {
            buttons: [
                {color:'petecavermelho', label:'Ensino Fundamental I', slug: 'ensino-fundamental-1'},
                {color:'petecaamarelo', label:'Ensino Fundamental II', slug: 'ensino-fundamental-2'},
                {color:'petecaazul', label:'Ensino Médio', slug: 'ensino-medio'}
            ]
        }
    }
}
</script>

<style>

</style>