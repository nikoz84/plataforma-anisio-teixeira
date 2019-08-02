<template>
<div v-if="paginator.data">
    <div class="col-lg-12 q-pa-md">
        <SearchForm v-if="paginator.data && paginator.data.length > 0"></SearchForm>
    </div>
    <div class="col-lg-12 q-pa-md">
        <q-markup-table :separator="'vertical'" flat bordered>
            <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-center">Nome/Título</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,i) in paginator.data" :key="`row-${i}`">
                    <td class="text-left">{{row.id}}</td>
                    <td class="text-center" v-html="row.name ? row.name : row.title"></td>
                    <td class="text-center" style="width:150px;">
                        <q-btn-group spread>
                            <q-btn color="primary" icon="edit" />
                            <q-btn color="negative" icon="delete" />
                        </q-btn-group>
                    </td>
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
      //
    };
  }
};
</script>