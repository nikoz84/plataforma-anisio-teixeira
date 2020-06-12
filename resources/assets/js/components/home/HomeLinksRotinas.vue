<template>
    <div>
        <div class="text-h5 title-page text-primary separatriz q-pb-md">
            Rotinas de Estudo
        </div>
        <div class="separatriz-6"></div>
        <div class="row justify-center q-py-lg q-gutter-lg">
            <q-btn v-for="(button, s) in buttons" 
                :key="`${s}`"
                stack 
                size="md" 
                class="col-xs-5 col-sm-3" 
                :color="button.color" 
                text-color="white"
                :title="`Rotinas de estudo ${button.label}`"
                :label="button.label">
                <q-avatar
                    style="width: 200px;height: 44px;fill: currentColor;border-radius: 0%;"
                    alt="Marca"
                    title="marca"
                    aria-label="Marca da plataforma Anísio Teixeira">
                    <svg class="icon-pat" height="35" width="35">
                        <use v-bind="{'xlink:href':'#peteca-icon-branco'}"></use> 
                    </svg>
                </q-avatar>
            </q-btn>
        </div>
    </div>
</template>

<script>
export default {
    name: "HomeLinksRotinas",
    data() {
        return {
            buttons: [
                {'color':'petecavermelho', 'label':'Ensino Fundamental I'},
                {'color':'petecaamarelo', 'label':'Ensino Fundamental II'},
                {'color':'petecaazul', 'label':'Ensino Médio'}
            ]
        }
    }
}
</script>

<style>

</style>