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
                            <q-btn color="negative" icon="delete" @click="confirmDelete(row)"/>
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

        <!-- CONFIRMAR APAGADO -->
        <q-dialog v-model="confirm" persistent>
          <q-card>
            <q-card-section class="row items-center">
              <q-avatar icon="delete" color="negative" text-color="white" />
              <span class="q-ml-sm" v-html="text"></span>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn flat label="Cancelar" color="primary" v-close-popup />
              <q-btn flat label="Confirmar" color="negative" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
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
      current: this.paginator ? this.paginator.current_page : 1,
      confirm: false,
      text: ""
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
    },
    confirmDelete(item) {
      this.confirm = true;
      let title = item.name ? item.name : item.title;
      this.text = `Realmente deseja <strong class="text-negative">deletar</strong> <strong>${title}</strong>?`;
      console.log(this.$route.params.slug, item.id);
    }
  }
};
</script>