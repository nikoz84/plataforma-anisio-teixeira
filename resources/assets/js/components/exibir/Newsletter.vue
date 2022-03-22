<template>

  <div class="q-pa-md">
    <h3>Emails cadastrados para o Newsletter</h3>
    <div class="col-lg-12">
      <!--
      <SearchForm slug="newsletter"></SearchForm>-->
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <!--<q-btn
        icon="add"
        color="positive"
        size="xs"
        :to="`/admin/newsletter/adicionar`"
        title="Adicionar Email"
        label="adicionar Email"
      />
-->
      <xlsx-workbook>
        <xlsx-sheet
          :collection="sheet.data"
          v-for="sheet in sheets"
          :key="sheet.name"
          :sheet-name="sheet.name"
        />
        <xlsx-download filename='Emails do Newsletter.xlsx'>
          <q-btn
            color="primary"
            size="xs"
            label="Download em Excel"
          />

        </xlsx-download>
      </xlsx-workbook>
      <q-space></q-space>
      <!-- PAGINAÇÃO -->
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="paginator.current_page"
        :max="paginator.last_page"
        :input="true"
        @input="getNewsletter"
      >
      </q-pagination>

    </div>
    <div
      class="col-lg-12 q-mt-xs"
      v-if="paginator && paginator.total > 0"
    >
      <!-- LISTA -->
      <q-markup-table
        separator="horizontal"
        flat
        bordered
        :dense="$q.screen.lt.md"
      >
        <thead>
          <tr>
            <th class="text-center">Email</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="email in paginator.data"
            :key="email.id"
            :id="`item-${email.id}`"
          >
            <td
              class="text-center"
              v-html="email.email"
            ></td>

            <td
              class="text-center"
              style="width:50px;"
            >
              <q-btn-group spread>

                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/newsletter/${email.id}`, email.id)"
                  icon="delete"
                />

              </q-btn-group>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </div>

    <SemResultados
      v-else
      :paginator="paginator"
    ></SemResultados>

    <div
      class="col-lg-12 q-mt-lg"
      v-if="paginator && paginator.total > paginator.per_page"
    >
      <div class="flex flex-center">
        <p>
          <strong>Total</strong>: {{ paginator.total }} itens -
          {{ paginator.per_page }} itens por página
        </p>
      </div>
      <div class="flex flex-center">
        <q-pagination
          v-model="paginator.current_page"
          :max="paginator.last_page"
          :max-pages="10"
          boundary-numbers
          @input="getNewsletter"
        >
        </q-pagination>
      </div>
    </div>
  </div>
</template>

<script>
// @ts-nocheck
import { SearchForm } from "@forms/search";
import { mapMutations, mapState } from "vuex";
import { SemResultados } from "@components/paginator";
import XlsxWorkbook from "../../../../../node_modules/vue-xlsx/dist/components/XlsxWorkbook";
import XlsxSheet from "../../../../../node_modules/vue-xlsx/dist/components/XlsxSheet";
import XlsxDownload from "../../../../../node_modules/vue-xlsx/dist/components/XlsxDownload";

export default {
  name: "ListarNewsletter",
  components: {
    SearchForm,
    SemResultados,
    XlsxWorkbook,
    XlsxSheet,
    XlsxDownload,
  },
  data() {
    return {
      email: [],
      searchParams: new URLSearchParams({}),
      sheets: [],
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"]),
  },
  created() {
    this.getNewsletter();
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", "SET_DATA"]),

    async getNewsletter(page = 1) {
      this.searchParams.set("page", page);

      const path = `/newsletter?${this.searchParams.toString()}`;

      this.$q.loading.show();

      //console.log(path, params)

      const { data } = await axios.get(path);

      this.$q.loading.hide();
      if (data.success) {
        this.SET_PAGINATOR(data.paginator);

        this.sheets = [
          {
            name: "Newsletter",
            data: data.paginator.data,
          },
        ];

        //console.log(data.paginator.data);
      }
    },
  },
};
</script>

<style>
</style>