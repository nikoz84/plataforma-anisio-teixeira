<template>
  <div class="row items-start">
    <q-card class="my-card text-dark" style="" square>
      <!-- TÍTULO DOS DADOS -->
      <q-card-section>
        <div class="text-h6">
          {{ data.titulo }}
        </div>
      </q-card-section>

      <q-separator />

      <!-- ENTRADA DE DADOS -->
      <q-card-section>
        {{ data.title ? data.title : '' }} Quantidade: {{ data.quantidade ? data.quantidade : 0}}
      </q-card-section>

      <q-separator />

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
  props: ["id", "data", "title", "slug"],
  methods: {},
};
</script>
<style scoped>
.my-card {
  width: 450px;
  max-width: 450px;
}
</style>
