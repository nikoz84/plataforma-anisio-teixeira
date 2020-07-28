<template>
<div class="q-pa-md">
    <q-card>
        <q-card-section>
            <h6>Formulário do slider da home page, {{slides.length}} slides cadastrados</h6>
        </q-card-section>
        <q-card-section>
            <q-btn color="positive" 
                label="Adicionar novo"
                @click="show = !show"></q-btn>
        </q-card-section>
        <q-card-section v-if="show">
            <q-input class="q-mb-md" filled 
                label="Título do destaque" v-model="newTitle"
                bottom-slots
                :error="errors.title && errors.title.length > 0"
                >
                <template v-slot:error>
                    <ShowErrors :errors="errors.title"></ShowErrors>
                </template>
            </q-input>

            <q-input class="q-mb-md" filled 
                label="URL do destaque" v-model="newUrl"
                bottom-slots
                :error="errors.url && errors.url.length > 0"
                >
                <template v-slot:error>
                    <ShowErrors :errors="errors.url"></ShowErrors>
                </template>
            </q-input>
            <q-input class="q-mb-md"
                    @input="val => { file = val[0] }"
                    filled
                    type="file"
                    hint="Imagem de destaque 1200x250"
                bottom-slots
                :error="errors.image && errors.image.length > 0"
                >
                <template v-slot:error>
                    <ShowErrors :errors="errors.image"></ShowErrors>
                </template>
            </q-input>
        </q-card-section>
        <q-card-actions v-if="show">
            <q-btn class="full-width" color="primary" label="Salvar" @click="save()"></q-btn>
        </q-card-actions>
        
    </q-card>

    <q-card class="q-mt-lg" v-for="(slide, i) in slides" :key="i">
        {{ i }}
        <q-card-section >
            <q-input class="q-mb-md" filled label="Título do destaque" v-model="slide.title"></q-input>
            <q-input class="q-mb-md" filled label="URL do destaque" v-model="slide.url"></q-input>
            <q-img style="width: 100%" :src="slide.image"></q-img>
            <q-input class="q-mb-md"
                    @input="val => { file = val[0] }"
                    filled
                    type="file"
                    hint="Imagem de destaque 1200x250"
                /> 
        </q-card-section>
    </q-card>
</div>
</template>

<script>
import { ShowErrors } from "@forms/shared";

export default {
    name: "SliderForm",
    props: ['item'],
    components: {
        ShowErrors
    },
    data(){
        return {
            newTitle: '',
            newUrl: '',
            newFile: null,
            slides: [],
            file: null,
            name: null,
            show: false,
            errors: {}
        }
    },
    created(){
        this.name = this.item.name
        this.slides = this.item.meta_data
    },
    methods: {
        async save(){
            console.log(this.newTitle, this.newUrl);
            console.log(this.newFile);
            try {
                const { data } = await axios.post('/options/destaques');
                console.log(data);
            } catch (er) {
                this.errors = er.errors;
            }
            
            
            
        }
    }
}
</script>