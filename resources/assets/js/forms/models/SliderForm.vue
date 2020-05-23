<template>
    <q-card>
        <q-card-section>
            <q-input filled readonly label="Nome da Opção" v-model="name"/>
        </q-card-section>
        <q-card-section v-for="(slide, i) in slides" :key="i">
            {{ slide || json }} 
            <q-input class="q-mb-md" filled label="Título do destaque" v-model="slide.title"></q-input>
            <q-input class="q-mb-md" filled label="URL do destaque" v-model="slide.url"></q-input>
            <q-img style="width: 100%" :src="slide.image"></q-img>
            <q-input class="q-mb-md"
                    @input="file => { file = val[0] }"
                    filled
                    type="file"
                    hint="Imagem de destaque 1200x250"
                /> 
        </q-card-section>
    </q-card>
</template>

<script>
export default {
    name: "SliderForm",
    props: ['item'],
    data(){
        return {
            name: '',
            slides: [],
            file: null
        }
    },
    created(){
        this.name = this.item.name
        this.slides = this.item.meta_data
    },
    methods: {
        save(){
            
        }
    }
}
</script>