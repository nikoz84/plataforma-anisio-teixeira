<template>
    <article class="q-pa-sm">
        <div>
            Fonte: {{denuncia.action}}
        </div>
        <div>
            Nome: {{denuncia.name}}
        </div>
        <div>
            Assunto: {{denuncia.subject}}
        </div>
        <div>
            Email: {{denuncia.email}}
        </div>
        <div>
            Mensagem: {{denuncia.message}}
        </div>
        <div>
            Url: {{denuncia.url}}
        </div>
        <div>
            Enviado em: {{denuncia.created_at}}
        </div>
    </article>
</template>
<script>
export default {
  name: "Denuncia",
  data() {
    return {
      denuncia: {}
    };
  },
  mounted() {
    this.getDenuncia();
  },
  methods: {
    async getDenuncia() {
      let resp = await axios.get(`/denuncias/${this.$route.params.id}`);
      if (resp.data.success) {
        this.denuncia = resp.data.metadata;
      }
    }
  }
};
</script>


