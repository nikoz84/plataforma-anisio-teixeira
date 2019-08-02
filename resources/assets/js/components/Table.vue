<template>
<div v-if="paginator.data">
    <div class="col-lg-12">
        <SearchForm v-if="paginator.data && paginator.data.length > 0"></SearchForm>
    </div>
    <div class="col-lg-12">
        <q-markup-table :separator="'horizontal'" flat bordered>
            <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-center">Nome/Título</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,i) in paginator.data" :key="`row-${i}`">
                    <td class="text-left">{{row.id}}</td>
                    <td class="text-center">{{ row.name ? row.name : row.title }}</td>
                </tr>
            </tbody>
        </q-markup-table>
    </div>
</div>
</template>
<script>
import SearchForm from "../forms/SearchForm.vue";
import { QMarkupTable } from "quasar";

export default {
  name: "Table",
  components: {
    SearchForm,
    QMarkupTable
  },
  props: ["paginator"],
  data() {
    return {
      pagination: {
        page: this.paginator.current_page,
        rowsPerPage: this.paginator.per_page,
        rowsNumber: this.paginator.total
      },
      columns: [
        {
          name: "id",
          align: "center",
          label: "ID",
          field: "id",
          sortable: true
        },
        {
          name: "name",
          align: "center",
          label: "Nome/Título",
          field: row => (row.name ? row.name : row.title),
          sortable: true
        }
      ]
    };
  }
};
</script>