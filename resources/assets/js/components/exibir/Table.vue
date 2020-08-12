<template>
  <div class="q-pa-md">
    <div class="col-lg-12">
      <SearchForm></SearchForm>
    </div>
    <div class="col-lg-12 flex flex-center q-gutter-sm">
      <!-- ADICIONAR -->
      <q-btn icon="add" 
        color="positive" 
        size="xs"
        :to="`/admin/${$route.params.slug}/adicionar`" 
        title="Adicionar novo item"
        label="adicionar item"
        v-if="userCan()"/>
        <!-- LISTAR CONTEÚDOS APROVADOS -->
        <q-btn icon="checked" 
        color="primary" 
        size="xs"
        label="Aprovar"
        @click="aprovar"
        v-if="$route.params.slug == 'conteudos' && userCan()"/>
        <q-space></q-space>
        <!-- PAGINAÇÃO -->
      <q-pagination
        v-if="paginator && paginator.total > paginator.per_page"
        v-model="current"
        :max="last"
        :input="true"
        @input="getPage"
      >
      </q-pagination>
      <q-card v-if="paginator && paginator.total == 0">
        <q-card-section class="text-center">
          <p class="text-h6">Sem resultados</p>
        </q-card-section>
      </q-card>
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
            <th class="text-center">Nome/Título</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, i) in paginator.data" :key="`row-${i}`">
            <td
              class="text-center"
              v-html="row.name ? row.name : row.title"
            ></td>
            <td class="text-center" style="width:50px;">
              <q-btn-group spread>
                <q-btn
                  size="sm"
                  color="primary"
                  title="Editar item"
                  icon="edit"
                  v-if="row.user_can && row.user_can.update"
                  :to="`/admin/${$route.params.slug}/editar/${row.id}`"
                />
                <q-btn
                  size="sm"
                  color="negative"
                  title="Deletar item"
                  icon="delete"
                  @click="confirm(row.name ? row.name : row.title, row.id)"
                  v-if="row.user_can && row.user_can.delete"
                />
                <q-btn
                  size="sm"
                  color="primary"
                  title="Visualizar"
                  icon="visibility"
                  v-if="$route.params.slug == 'conteudos' || $route.params.slug == 'aplicativos'"
                  @click="goTo(row)"
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
            v-model="current"
            :max="last"
            :input="true"
            @input="getPage"
          >
          </q-pagination>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { SearchForm } from "@forms/search";
import { mapMutations, mapState } from "vuex";
import {
  QMarkupTable,
  QDialog,
  ClosePopup,
  QPagination,
  LocalStorage
} from "quasar";

export default {
  name: "Table",
  components: {
    SearchForm,
    QMarkupTable,
    QDialog,
    ClosePopup,
    QPagination,
    LocalStorage
  },
  data() {
    return {
      current: this.paginator ? this.paginator.current_page : 1,
      //confirm: false,
      text: ""
    };
  },
  computed: {
    ...mapState(["paginator", "isLogged"]),
    last() {
      return this.paginator ? this.paginator.last_page : 1;
    }
  },
  watch: {
    $route(to, from, next) {
      this.getData();
    }
  },
  created() {
    this.getData();
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
    async getData() {
      this.$q.loading.show();
      let path = `/${this.$route.params.slug}`;
      if(path){
        let { data } = await axios.get(path);
        if (data.success && data.paginator) {
          this.$q.loading.hide();
          this.SET_PAGINATOR(data.paginator);
        }
      }
      
      this.$q.loading.hide();
    },
    goTo(item){
      if(item.hasOwnProperty('url_exibir')){
        let host = window.location.host;
        let protocol = window.location.protocol;
        let url = `${protocol}//${host}${item.url_exibir}`;
        window.open(url, '_blank');
      }
    },
    async aprovar(){
      this.$q.loading.show();
      const {data} = await axios.get('/conteudos?aprovados=false')
      this.SET_PAGINATOR(data.paginator);
      this.$q.loading.hide();
    },
    userCan(){
      let can = null;
      if(LocalStorage.has('user')){
        const user = JSON.parse(LocalStorage.getItem('user'));
        let role = user.role;
        can = this.isLogged && role === 1 || role === 2 || role === 3;
      }
      
      const slug = this.$route.params.slug;
      if(slug == 'contato'){
        return false;
      }
      
      return can;
    },
    confirm (title, id) {
      const context = this;
      this.$q.dialog({
       
        title: 'Confirmar',
        message: `<b>Realmente deseja apagar este item </b> <em>${title}</em>?`,
        cancel: true,
        html: true,
        persistent: true,
        ok: 
        {
          color: 'negative',
          label: 'Apagar'
        }
        }).onOk(() =>   
        {
            try
            {
                axios.delete(`/${this.$route.params.slug}/${id}`, {data:{delete_confirmation: true}});
                //this.$router.push('/admin/categorias/listar/'+this.$route.params.slug);
                var paginatorUpdate = JSON.parse(JSON.stringify(this.paginator));
                (paginatorUpdate.data = []);
                this.paginator.data.forEach(element => {
                  if(element.id !== id)
                  paginatorUpdate.data.push(element)
                });
                this.SET_PAGINATOR(paginatorUpdate);
                console.log(paginatorUpdate.data);
            }
            catch(ex)
            {
                console.log(ex);
            }
        })
      }
  }
};
</script>
