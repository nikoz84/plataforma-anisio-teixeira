<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <q-form v-on:submit.prevent="save()">
          <q-card-section>
            <q-input label="Nome" v-model="tipo.name"></q-input>
            <q-select label="Extensões" v-model="tipo.options.formatos" 
              use-chips
              multiple >
            </q-select>
          </q-card-section>
          <q-card-section>
            {{ errors }}
          </q-card-section>
          <q-card-section>
            <q-btn class="full-width q-mt-md" label="Salvar" type="submit" color="primary"/>
          </q-card-section>
        </q-form>
      </q-card>
    </div>
  </article>
</template>
<script>
export default {
  name: "TipoForm",
  data() {
    return { 
      tipo: {
        name: null,
        options: {
          formatos : []
        }
      },
      errors: {}
    }
  },
  mounted() {
    this.getTipo()
  },
  methods: {
    async getTipo() {
      let {data} = await axios.get(`/tipos/${this.$route.params.id}`);
      this.tipo = data.metadata;
    },
    async save(){
      console.log(this.tipo);
      const form = new FormData();
      form.append('name', this.tipo.name);
      form.append('formatos', this.tipo.options.formatos);

      if (this.$route.params.action == "editar") {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }

      await axios.post(`/tipos/${this.$route.params.id}`).then(
        resp => {
          console.log(resp)
        }
      ).catch(e => {
        this.errors = e.errors
      });
    }

  }

};
</script>

