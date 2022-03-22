<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <h4> Quantidade de Arquivos por Tipos de Conteúdos</h4>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">

      <q-space></q-space>

    </div>
    <div class="col-lg-12 q-mt-xs">
      <!-- LISTA -->
      <q-markup-table
        separator="horizontal"
        flat
        bordered
        :dense="$q.screen.lt.md"
      >
        <thead>
          <tr>
            <th class="text-center">Tipo de Conteúdo</th>
            <th class="text-center">Quantidade</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="qnt in quantidade"
            :key="qnt.id"
            :id="`item-${qnt.id}`"
          >
            <td
              class="text-center"
              v-html="qnt.name"
            ></td>

            <td
              class="text-center"
              style="width:50px;"
              :key="qnt.id"
              :id="qnt.id"
            >

              <span v-html="qnt.total"></span>

            </td>
          </tr>

        </tbody>
      </q-markup-table>
    </div>

  </div>
</template>

<script>
// @ts-nocheck

import { mapMutations, mapState } from "vuex";

export default {
  name: "QuantidadeArquivos",
  components: {},
  data() {
    return {
      quantidade: [],
    };
  },
  mounted() {
    this.getQuantidade();
  },
  computed: {
    ...mapState(["isLogged"]),
  },
  created() {},
  methods: {
    ...mapMutations([""]),
    async getQuantidade() {
      let resp = await axios.get(`/quantidade_arquivos/0`);
      //console.log(resp);

      this.quantidade = resp.data;
      console.log(resp);
    },
  },
};
</script>

<style>
</style>