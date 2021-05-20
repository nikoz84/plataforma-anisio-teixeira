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
        :to="`/admin/conteudos/adicionar`" 
        title="Adicionar novo item"
        label="adicionar item"
        />
        <!-- LISTAR CONTEÚDOS APROVADOS -->
        <q-btn icon="checked" 
        color="primary" 
        size="xs"
        label="Aprovar"
        @click="getAprovados()"
        />
        <q-btn
        color="primary"
        icon="person" 
        size="xs"
        label="Meus Conteúdos"
        @click="getOwnerResources()"
        />
        <q-space></q-space>
        <!-- PAGINAÇÃO -->
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="paginator.current_page"
        :max="paginator.last_page"
        :input="true"
        @input="getConteudos"
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
            <th class="text-center">Título</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Canal</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="conteudo in paginator.data" :key="conteudo.id" :id="`item-${conteudo.id}`">
            <td
              class="text-center"
              v-html="conteudo.title"
            ></td>
            <td
              class="text-center"
            >
              {{ conteudo.tipo ? conteudo.tipo.name : '' }}
            </td>
            <td
              class="text-center"
            >
              {{conteudo.canal.name}}
            </td>
            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="conteudo.user_can && conteudo.user_can.update"
                  :to="`/admin/conteudos/editar/${conteudo.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/conteudos/${conteudo.id}`, conteudo.id)"
                  icon="delete"
                  v-if="conteudo.user_can && conteudo.user_can.delete"
                />
                <q-btn
                  size="sm"
                  color="primary"
                  title="Visualizar"
                  icon="visibility"
                  type="a"
                  target="__blank"
                  :href="conteudo.url_exibir"
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
            @input="getConteudos"
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
        conteudos: [],
        searchParams: new URLSearchParams({}),
      }
    },
    computed: {
      ...mapState(["paginator", "isLogged"])
    },
    created() {
      this.getConteudos()
    },
    methods: {
      ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", 'SET_DATA']),
      
      async getConteudos(page = 1){
        this.searchParams.set('page', page)
        console.log(this.searchParams.toString())
        
        const path =`/conteudos?${this.searchParams.toString()}`;
        console.log(path)
        this.$q.loading.show();
        
        //console.log(path, params)
        
        const { data } = await axios.get(path);
        
        this.$q.loading.hide();
        if(data.success){
          this.SET_PAGINATOR(data.paginator)  
        }
  
      },
      goTo(conteudo){
        console.log(conteudo.url_exibir)
        
        this.$router.push('/admin/conteudos/');
      },
      getOwnerResources(){
        const user = JSON.parse(localStorage.getItem('user'));
        this.searchParams.set('publicador', user.id)
        if(this.searchParams.has('aprovados')){
          this.searchParams.delete('aprovados');
        }
        this.searchParams.set('page', 1)
        this.getConteudos()
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