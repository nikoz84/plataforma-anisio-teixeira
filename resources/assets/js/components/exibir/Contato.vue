<template>
    <article class="q-pa-sm">
      <q-card>
        <q-card-section>
          <strong>Fonte: </strong>
                {{contato.action}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Nome: </strong>
                {{contato.name}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Assunto: </strong>
                {{contato.subject}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Email: </strong>
                {{contato.email}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Mensagem: </strong>
                {{contato.message}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Url:  </strong>
                {{contato.url}}
                
            <q-separator class="q-my-md"></q-separator>
          <strong>Enviado em: </strong>
                {{contato.created_at}}
                
            <q-separator class="q-my-md"></q-separator>
        </q-card-section>
      </q-card>
    </article>
</template>
<script>
export default {
  name: "Contato",
  data() {
    return {
      contato: {}
    };
  },
  mounted() {
    this.getContato();
  },
  methods: {
    async getContato() {
      let resp = await axios.get(`/contato/${this.$route.params.id}`);
      if (resp.data.success) {
        this.contato = resp.data.metadata;
      }
    }
  }
};
</script>


