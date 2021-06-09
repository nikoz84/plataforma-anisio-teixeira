<template>
<div class="q-pa-md row justify-center q-gutter-xs">
    <q-card class="col-sm-6">
      <q-card-section class="q-gutter-sm">
        <q-input label="Pesquisar conteúdo" v-model="term"></q-input>
        <q-list bordered>      
            <q-item clickable v-ripple v-for="conteudo in conteudos" :key="conteudo.id">
            <q-item-section thumbnail>
              <img :src="conteudo.image">
            </q-item-section>
            <q-item-section>{{conteudo.title}}</q-item-section>
          </q-item>
        </q-list>
          
        </q-card-section>
        <q-card-actions>
          <q-btn color="primary" label="Buscar" @click="search()"></q-btn>
        </q-card-actions>
      </q-card>
      <q-card class="col-sm-5">
        <q-card-section>
          <h6 class="text-h6 text-center">Criar Playlist</h6>
        </q-card-section>
        <q-card-section>
          <q-input outlined v-model.trim="title" 
           label="Título da lista de reprodução"
           bottom-slots
          :error="errors && errors.title && errors.title.length > 0"
           >
            <template v-slot:error>
              <ShowErrors :errors="errors.title"></ShowErrors>
            </template>
          </q-input>
          <q-input outlined v-model="description" 
           label="Escreva uma descrição"
           clearable
           type="textarea"
           bottom-slots
          :error="errors && errors.description && errors.description.length > 0"
           >
            <template v-slot:error>
              <ShowErrors :errors="errors.description"></ShowErrors>
            </template>
          </q-input>
        </q-card-section>
        <q-card-actions>
          <q-btn @click="createPlayList" color="primary" label="Adicionar PlayList"></q-btn>
        </q-card-actions>
      </q-card>
  
</div>
</template>

<script>
import axios from "axios";

export default {
    name : "PlayListForm",
    data() {
      return {
        title: '',
        description: '',
        term: '',
        conteudos: [],
        errors: []
      }
    },
    methods: {
      async createPlayList() {
        console.log(this.title, this.description);
        const form = new FormData();
        form.append('document', JSON.stringify({
          title: this.title,
          description: this.description
        }))
        
        const { data } = await axios.post('/playlist', form);
        console.log(data)
      },

      async search()
      {
        
        const { data } = await axios.get(`/playlist/search/${this.term}`);
        this.conteudos = data.metadata
        console.log(data);
        
      }
    },
}
</script>

<style>

</style>