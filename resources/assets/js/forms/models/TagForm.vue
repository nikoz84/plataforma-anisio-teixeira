<template>
    <div class="row q-pa-md">
        <div class="col-sm-6 q-pa-md">
            <form v-on:submit.prevent="save()">
                <q-input filled v-model.trim="tag.name" label="Adicionar palavra-chave"
                  :error="errors.name && errors.name.length > 0"
                  bottom-slots>
                  <template v-slot:error>
                    <ShowErrors :errors="errors.name"></ShowErrors>
                  </template>
                </q-input>
                <q-card v-if="tag.id">
                    <q-card-section>
                        <p>Vezes pesquisada: {{ tag.searched }}</p> 
                        <p>Criada em: {{ format(tag.created_at) }}</p>
                        <p>Atualizada em: {{ format(tag.updated_at) }}</p>
                        <p>ID: {{ tag.id }}</p>
                    </q-card-section>
                </q-card>
                <q-btn label="Salvar" type="submit" color="primary" style="margin-top:15px"/>
            </form>
        </div>
        <div class="col-sm-6 q-pa-md">
            <q-input filled v-model.trim="busca" label="Pesquisa de palavras-chave"/>
            <div v-if="busca.length > 2" style="margin-top:30px;"> 
                <p>Palavras chave semelhantes à <b>{{busca}}, clique em uma palavra para poder editar</b></p>
                <div v-if="tags && tags.length">
                    <q-chip icon="bookmark" 
                            clickable 
                            v-for="(tag,i) in tags" 
                            :key="i" 
                            :label="tag.name" 
                            @click="onClick(`/admin/tags/editar/${tag.id}`)"/>
                </div>
                <q-chip icon="" v-else label="Não encontrado"/>
            </div>
        </div>
    </div>
</template>
<script>
import { QInput, QChip, QCard, QCardSection, date } from "quasar";
import { debounce } from "lodash";
import { ShowErrors } from "@forms/shared";

export default {
  name: "TagForm",
  components: { QInput, QChip, QCard, QCardSection, ShowErrors },
  data() {
    return {
      busca: "",
      tag: {
        name:''
      },
      tags: [],
      errors: {}
    };
  },
  watch: {
    busca: debounce(function(val) {
      if (val.length > 2 && val != "") {
        this.getTags(val);
      }
    }, 500),
    $route(to, from) {
      this.getTag();
    }
  },
  created() {
    this.getTag();
  },
  methods: {
    async save() 
    {
      let id = this.$route.params.id ? `/${this.$route.params.id}` : "";
      let form = new FormData();
      form.append("name", this.tag.name.toLowerCase());

      if (this.$route.params.action == "editar") 
      {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }
      try 
      {
        let response = await axios.post(this.$route.params.slug + id, form);
        this.$router.push(`/admin/tags/listar`);
      } 
      catch (response) 
      {
        this.errors = response.errors;
      }
      
    },
    format(data) {
      return date.formatDate(data, "DD/MM/YYYY");
    },
    async getTags(val) {
      if (!val) return;
      let resp = await axios.get(`tags/search/${val}?limit=150`);
      if (resp.data.success == true) {
        this.tags = resp.data.paginator.data;
      }
    },
    async getTag() {
      if (!this.$route.params.id) return;
      let resp = await axios.get(`tags/${this.$route.params.id}`);
      if (resp.data.success) {
        this.tag = resp.data.metadata;
      }
    },
    onClick(url) {
      this.$router.push(url);
    }
  }
};
</script>