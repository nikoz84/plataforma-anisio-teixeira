<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <SearchForm slug="conteudos"></SearchForm>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <q-btn icon="add" 
        color="positive" 
        size="xs"
        :to="`/admin/aplicativos/adicionar`" 
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
        @input="getAplicativos"
      >
      </q-pagination>

      <div v-if="paginator && paginator.total == 0">
        
        <q-card>
          <q-card-section class="text-center">
            <p class="text-h6">Sem resultados</p>
          </q-card-section>
        </q-card>
      </div>
      
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
            <th class="text-center">Categoria</th>
            <th class="text-center">Canal</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="aplicativo in paginator.data" :key="aplicativo.id" :id="`item-${aplicativo.id}`">
            <td
              class="text-center"
              v-html="aplicativo.name"
            ></td>
            <td
              class="text-center"
            >
              {{aplicativo.category ? aplicativo.category.name : null}}
            </td>
            <td
              class="text-center"
            >
              {{aplicativo.canal.name}}
            </td>
            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="aplicativo.user_can && aplicativo.user_can.update"
                  :to="`/admin/aplicativos/editar/${aplicativo.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/aplicativos/${aplicativo.id}`, aplicativo.id)"
                  icon="delete"
                  v-if="aplicativo.user_can && aplicativo.user_can.delete"
                />
                <q-btn
                  size="sm"
                  color="primary"
                  title="Visualizar"
                  icon="visibility"
                  type="a"
                  target="__blank"
                  :href="aplicativo.url_exibir"
                />
                
              </q-btn-group>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
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
            @input="getAplicativos"
          >
          </q-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ts-nocheck
import { SearchForm } from "@forms/search";
import { mapMutations, mapState } from "vuex";
export default {
    name: "ListarConteudos",
    components: {SearchForm},
    data() {
      return {
        aplicativos: [],
        searchParams: new URLSearchParams({}),
      }
    },
    computed: {
      ...mapState(["paginator", "isLogged"])
    },
    created() {
      this.getAplicativos()
    },
    methods: {
      ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", 'SET_DATA']),
      
      async getAplicativos(page = 1){
        this.searchParams.set('page', page)
        
        const path =`/aplicativos?${this.searchParams.toString()}`;
        
        this.$q.loading.show();
        
        //console.log(path, params)
        
        const { data } = await axios.get(path);
        
        this.$q.loading.hide();
        if(data.success){
          this.SET_PAGINATOR(data.paginator)  
        }
  
      },
      goTo(aplicativo){
        console.log(aplicativo.url_exibir)
        
        this.$router.push('/admin/aplicativos/listar');
      },
      getAprovados(){
        this.searchParams.set('aprovados', false)
        this.searchParams.set('page', 1)
        if(this.searchParams.has('publicador')){
          this.searchParams.delete('publicador');
        }
        this.getConteudos()
      }
    },

}
</script>

<style>

</style>