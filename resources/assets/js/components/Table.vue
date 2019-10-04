<template>
<div v-if="paginator">
    <div class="col-lg-12 q-pa-md">
        <SearchForm></SearchForm>
    </div>
    <div class="col-lg-12 q-pa-md"  v-if="paginator && paginator.total > 0">
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
                    <td class="text-left" >{{row.id}}</td>
                    <td class="text-center" v-html="row.name ? row.name : row.title"></td>
                    <td class="text-center" style="width:150px;">
                        <q-btn-group spread>
                            <q-btn color="primary" icon="edit" :to="`/admin/${$route.params.slug}/editar/${row.id}`"/>
                            <q-btn color="negative" icon="delete" :to="`/admin/${$route.params.slug}/apagar/${row.id}`"/>
                        </q-btn-group>
                    </td>
                </tr>
            </tbody>
        </q-markup-table>
        <div class="row q-mt-lg" v-if="paginator && paginator.total > paginator.per_page">
            <div class="col-sm-5">
                <p> 
                    <strong>Total</strong>: {{paginator.total}} itens - {{paginator.per_page}} itens por página 
                </p>
            </div>
            <div class="col-sm-7">
                <q-pagination
                v-model="current"
                :max="paginator.last_page"
                :input="true"
                @input="getPage"
                >
                </q-pagination>
            </div>
        </div>
        <q-page-sticky position="bottom-right" :offset="[18, 480]">
                <q-btn icon="add" color="positive" :to="`/admin/${$route.params.slug}/adicionar`"/>
        </q-page-sticky>
    </div>
</div>
</template>
<script>
import SearchForm from "../forms/SearchForm.vue";
import {
  QMarkupTable,
  QDialog,
  ClosePopup,
  QPagination,
  QParallax
} from "quasar";
import { mapMutations, mapState } from "vuex";

export default {
  name: "Table",
  components: {
    SearchForm,
    QMarkupTable,
    QDialog,
    ClosePopup,
    QPagination
  },
  data() {
    return {
      current: this.paginator ? this.paginator.current_page : 1
    };
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async getPage() {
      this.$q.loading.show();
      let url = "";
      if (this.paginator.next_page_url) {
        url = this.paginator.next_page_url.replace(
          /page=\d+/g,
          `page=${this.current}`
        );
      } else {
        url = this.paginator.prev_page_url.replace(
          /page=\d+/g,
          `page=${this.current}`
        );
      }
      if (url) {
        let resp = await axios.get(`${url}`);
        if (resp.data.paginator) {
          this.SET_PAGINATOR(resp.data.paginator);
          this.$q.loading.hide();
        }
      }

      this.$q.loading.hide();
    }
  }
};
</script>