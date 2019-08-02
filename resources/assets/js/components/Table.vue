<template>
<div class="row" v-if="paginator.data">
    <div class="col-lg-12">
        <SearchForm v-if="paginator.data && paginator.data.length > 0"></SearchForm>
    </div>
    <div class="col-lg-12 table-responsive">
        <q-table title="Tabela" 
            :data="paginator.data" 
            :columns="columns" 
            :pagination.sync="pagination" 
            row-key="name" 
            binary-state-sort>

        </q-table> 
    </div>
</div>
</template>
<script>
import SearchForm from "../forms/SearchForm.vue";
import { QTable } from "quasar";

export default {
  name: "Table",
  components: {
    SearchForm,
    QTable
  },
  props: ["paginator"],
  data() {
    return {
      pagination: {
        page: this.paginator.current_page,
        rowsPerPage: this.paginator.per_page
        // rowsNumber: xx if getting data from a server
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
          label: "Nome",
          field: "name",
          sortable: true
        },
        {
          name: "title",
          align: "center",
          label: "Título",
          field: "title",
          sortable: true
        }
      ]
    };
  }
};
</script>