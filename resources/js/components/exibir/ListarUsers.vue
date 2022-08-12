<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <SearchForm slug="usuarios"></SearchForm>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <q-btn
        icon="add"
        color="positive"
        size="xs"
        :to="`/admin/usuarios/adicionar`"
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
        @input="getUsers"
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
            <th class="text-center">Role</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in paginator.data"
            :key="user.id"
            :id="`item-${user.id}`"
          >
            <td class="text-center" v-html="user.name"></td>
            <td
              v-if="user.role"
              class="text-center"
              v-html="user.role.name"
            ></td>

            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="user.user_can && user.user_can.update"
                  :to="`/admin/usuarios/editar/${user.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/usuarios/${user.id}`, user.id)"
                  icon="delete"
                  v-if="user.user_can && user.user_can.delete"
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
          @input="getUsers"
        >
        </q-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import { SearchForm } from "@/forms/search";
import { mapMutations, mapState } from "vuex";
import { SemResultados } from "@/components/paginator";

export default {
  name: "ListarUsers",
  components: { SearchForm, SemResultados },
  data() {
    return {
      users: [],
      searchParams: new URLSearchParams({}),
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"]),
  },
  created() {
    this.getUsers();
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", "SET_DATA"]),

    async getUsers(page = 1) {
      this.searchParams.set("page", page);

      const path = `/usuarios?${this.searchParams.toString()}`;

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
