<template>
    <div class="q-pa-md">
        <form v-on:submit.prevent="send">
            <q-input filled v-model.trim="name" label="Palavra Chave" style="max-width: 400px"/>
            <q-btn label="Salvar" type="submit" color="primary" style="margin-top:15px"/>
            
            <div v-if="name.length > 2" style="margin-top:30px;"> 
                <p>Palavras chave semelhantes à <b>{{name}}</b></p>
                <q-chip icon="bookmark" v-for="(tag,i) in tags" :key="i" :label="tag.name" />
            </div>
        </form>
    </div>
</template>
<script>
import { QInput, QChip } from "quasar";
import { debounce } from "lodash";

export default {
  name: "TagForm",
  components: { QInput, QChip },
  data(){
      return {
          name: '',
          tags: []
      }
  },
  watch:{
    name : debounce(function (val) {
        if(val.length > 2 && val != ''){
            this.getTags(val)
        }
    }, 300)
      
  },
  methods:{
      async send() {
          console.warn(this.name)
    
      },
      async getTags(val){
        let resp = await axios.get(`tags/search/${val}?limit=100`)
        if(resp.data.success == true){
            this.tags = resp.data.paginator.data
        }
      }
  }
};
</script>