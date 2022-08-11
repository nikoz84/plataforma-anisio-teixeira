<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <SearchForm slug="tags"></SearchForm>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <q-btn
        icon="add"
        color="positive"
        size="xs"
        :to="`/admin/tags/adicionar`"
        title="Adicionar novo item"
        label="adicionar item"
      />

      <q-space></q-space>
      <!-- PAGINAÇÃO -->
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="paginator.current_page"
        :max="paginator.last_page"
        :input="true"
        @input="getTags"
      >
      </q-pagination>
    </div>
    <div class="col-lg-12 q-mt-xs" v-if="paginator && paginator.total > 0">
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
            v-for="tag in paginator.data"
            :key="tag.id"
            :id="`item-${tag.id}`"
          >
            <td class="text-center" v-html="tag.name"></td>

            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="tag.user_can && tag.user_can.update"
                  :to="`/admin/tags/editar/${tag.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/tags/${tag.id}`, tag.id)"
                  icon="delete"
                  v-if="tag.user_can && tag.user_can.delete"
                />
              </q-btn-group>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </div>

    <SemResultados v-else :paginator="paginator"></SemResultados>

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
          @input="getTags"
        >
        </q-pagination>
      </div>
    </div>
  </div>
</template>

<script>
// @ts-nocheck
import { SearchForm } from "@/forms/search";
import { mapMutations, mapState } from "vuex";
import { SemResultados } from "@/components/paginator";

export default {
  name: "ListarTags",
  components: { SearchForm, SemResultados },
  data() {
    return {
      tags: [],
      searchParams: new URLSearchParams({}),
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"]),
  },
  created() {
    this.getTags();
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", "SET_DATA"]),

    async getTags(page = 1) {
      this.searchParams.set("page", page);

      const path = `/tags?${this.searchParams.toString()}`;

      this.$q.loading.show();

      //console.log(path, params)

      const { data } = await axios.get(path);

      this.$q.loading.hide();
      if (data.success) {
        this.SET_PAGINATOR(data.paginator);
      }
    },
  },
};
</script>

<style></style>
