<template>
  <div class="row items-start">
    <q-card class="my-card text-dark" style="" square>
      <!-- TÍTULO DOS DADOS -->
      <q-card-section>
        <div class="text-h6">
          {{ titulo }}
        </div>
      </q-card-section>
      <q-separator />
      <!-- ENTRADA DE DADOS -->
      <q-card-section v-if="id === 'conteudos-por-ano'">
        <span>
          Total de conteúdos: {{ cardContent.total }}
          <br />
          Ano: {{ cardContent.ano }}


        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-por-canal'">
        <span>
          Quantidade: {{ cardContent.total }}
          <br />
          Nome canal: {{ cardContent.name }}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tags-mais-procuradas'">
        <span>
          Vezes buscada: {{ cardContent.name }}
          <br />
          Palavra-chave: {{ cardContent.searched }}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tipos-de-midia'">
        <span>
          Nome da mída: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.total}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'aplicativos-mais-visualizados'">
        <span>
          Nome do aplicativo: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.qt_access}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-acessados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_access}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-baixados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_downloads}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-mensal-por-usuario'">
        <span>
          Nome: {{ cardContent.name}}
          <br />
          Total: {{ cardContent.total}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-total-mensal'">
        <span>
          Mês: {{ cardContent.mes}}
          <br />
          Quantidade: {{ cardContent.quantidade}}
        </span>
      </q-card-section>

      <!-- AÇÕES DOS DADOS -->
      <q-card-actions>
        <q-btn flat :to="`/admin/dashboard/${id}`" size="sm">Ver relatório completo</q-btn>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script>
export default {
  name: "CardDashboard",
  props: ["id", "titulo"],
  data () {
    return {
      cardContent: 'null'
    }
  },
  created () {
    this.getDataFromId()
  },
  methods: {
    async getDataFromId () {
      console.log(this.id)
      const { data } = await axios.get(`/dashboard/${this.id}`)
      if (data.success) {
        const [first] = data.metadata
        console.log(first)
        this.cardContent = first
      }
    }
  },
};
</script>
<style scoped>
.my-card {
  width: 450px;
  max-width: 450px;
}
</style>
