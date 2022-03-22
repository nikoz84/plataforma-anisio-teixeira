<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <SearchForm slug="categorias"></SearchForm>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <q-btn
        icon="add"
        color="positive"
        size="xs"
        :to="`/admin/categorias/adicionar`"
        title="Adicionar novo item"
        label="adicionar item"
      />
      <q-btn
        id="gerar_planilha"
        size="xs"
        color="primary"
        label="Gerar Planilha para Exportação"
        @click="getTodasCategorias()"
        v-show="esconder"
      />

      <xlsx-workbook>
        <xlsx-sheet
          :collection="sheet.data"
          v-for="sheet in sheets"
          :key="sheet.name"
          :sheet-name="sheet.name"
        />
        <xlsx-download filename='Categorias.xlsx'>
          <q-btn
            size="xs"
            color="negative"
            label="Download em Excel"
            v-if="sheets!=''"
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
        @input="getCategorias"
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
            <th class="text-center">Nome</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="categoria in paginator.data"
            :key="categoria.id"
            :id="`item-${categoria.id}`"
          >
            <td
              class="text-center"
              v-html="categoria.name"
            ></td>

            <td
              class="text-center"
              style="width:50px;"
            >
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="categoria.user_can && categoria.user_can.update"
                  :to="`/admin/categorias/editar/${categoria.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/categorias/${categoria.id}`, categoria.id)"
                  icon="delete"
                  v-if="categoria.user_can && categoria.user_can.delete"
                />
                <q-btn
                  size="sm"
                  color="primary"
                  title="Visualizar"
                  icon="visibility"
                  type="a"
                  target="__blank"
                  :to="`/${categoria.slug}/`"
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
          @input="getCategorias"
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
  name: "ListarCanais",
  components: {
    SearchForm,
    SemResultados,
    XlsxWorkbook,
    XlsxSheet,
    XlsxDownload,
  },
  data() {
    return {
      categorias: [],
      searchParams: new URLSearchParams({}),
      sheets: [],
      esconder: true,
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"]),
  },
  created() {
    this.getCategorias();
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", "SET_DATA"]),

    async getCategorias(page = 1) {
      this.searchParams.set("page", page);

      const path = `/categorias?${this.searchParams.toString()}`;

      this.$q.loading.show();

      //console.log(path, params)

      const { data } = await axios.get(path);

      this.$q.loading.hide();
      if (data.success) {
        this.SET_PAGINATOR(data.paginator);
      }
    },
    async getTodasCategorias() {
      const path = `/categorias?categoria=&limit=99999`;

      this.$q.loading.show();

      //console.log(path, params)

      const { data } = await axios.get(path);

      //console.log(data);

      this.$q.loading.hide();
      if (data.success) {
        this.sheets = [
          {
            name: "Tags",
            data: data.paginator.data,
          },
        ];

        this.esconder = false;
      }
    },
  },
};
</script>

<style>
</style>