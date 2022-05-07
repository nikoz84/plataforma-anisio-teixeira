<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR 
      <q-btn icon="add" 
        color="positive" 
        size="xs"
        :to="`/admin/contato/responder`" 
        title="Responder"
        label="Responder"
        />
        -->
        <q-space></q-space>
        <!-- PAGINAÇÃO -->
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="paginator.current_page"
        :max="paginator.last_page"
        :input="true"
        @input="getContatos"
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
            <th class="text-center">Fonte</th>
            <th class="text-center">Nome</th>
            <th class="text-center">Assunto</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contato in paginator.data" :key="contato.id" :id="`item-${contato.id}`">
            <td
              class="text-center"
              v-html="contato.action"
            ></td>
            <td
              class="text-center"
              v-html="contato.name"
            ></td>
            <td
              class="text-center"
              v-html="contato.subject"
            ></td>
            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Responder mensagem"
                  icon="reply"
                  v-if="contato.user_can && contato.user_can.update"
                  :to="`/admin/contato/responder/${contato.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  @click="deleteItem(`/contato/${contato.id}`, contato.id)"
                  icon="delete"
                  v-if="contato.user_can && contato.user_can.delete"
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
            @input="getContatos"
          >
          </q-pagination>
        </div>
      </div>
  </div>
</template>

<script>
// @ts-nocheck
import { mapMutations, mapState } from "vuex";
import { SemResultados } from "@components/paginator";

export default {
    name: "ListarContato",
    components: {SemResultados},
    data() {
      return {
        contatos: [],
        searchParams: new URLSearchParams({}),
      }
    },
    computed: {
      ...mapState(["paginator", "isLogged"])
    },
    created() {
      this.getContatos()
    },
    methods: {
      ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING", 'SET_DATA']),
      
      async getContatos(page = 1){
        this.searchParams.set('page', page)
        
        const path =`/contato?${this.searchParams.toString()}`;
        
        this.$q.loading.show();
        
        //console.log(path, params)
        
        const { data } = await axios.get(path);
        
        this.$q.loading.hide();
        if(data.success){
          this.SET_PAGINATOR(data.paginator)  
        }
  
      }
    },

}
</script>

<style>

</style>