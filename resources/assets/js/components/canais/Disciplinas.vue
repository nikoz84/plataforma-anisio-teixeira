<template>
  <nav
    role="menu disciplinas ensino medio"
    v-if="disciplinas"
    style="margin-top:30px;"
  >
    <h5 class="text-center">{{ disciplinas.name }}</h5>
    <ul class="nav nav-pills nav-stacked">
      <li v-for="(disciplina, d) in disciplinas.components" :key="d">
        <q-btn
          :to="{
            name: 'Listar',
            params: { slug: $route.params.slug },
            query: {
              categoria: $route.query.categoria,
              componentes: disciplina.id,
            },
          }"
        >
          {{ disciplina.name }}
        </q-btn>
      </li>
    </ul>
  </nav>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "Disciplinas",
  computed: {
    ...mapState(["disciplinas"]),
  },
};
</script>
