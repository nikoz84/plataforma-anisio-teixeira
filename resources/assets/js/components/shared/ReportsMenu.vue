 <template>
      <q-expansion-item
        dense
        dense-toggle
        expand-separator
        label="Relatórios"
      >
      <q-separator />
      <q-item clickable>
        <q-item-section>Relatorio de Usuários do Sistema</q-item-section>
        <q-item-section side>
          <q-icon name="keyboard_arrow_right" />
        </q-item-section>
         <q-menu anchor="top right" self="top left">
                <q-list>
                  <q-item
                    clickable 
                    dense
                    v-for="role in rolesUsers"
                    :key="role.id"
                    @click="usuariosRelatorio(role.id, true)"
                  >
                    <q-item-section>{{role.name}}</q-item-section>
                  </q-item>
                  
                </q-list>
          </q-menu>
      </q-item>
      <q-item clickable 
        @click="maisBaixadosRelatorio()"
        aria-label="Conteudos Mais Baixados"
        active-class="active-link-pat">
        <q-item-section>
          <q-item-label>Conteúdos Mais Baixados</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator/>
      <!-- GALERIA -->
      <q-item clickable 
        aria-label="" 
        active-class="active-link-pat" 
        @click="maisVisualizadosRelatorio()"
        >
        <q-item-section>
          <q-item-label>Conteúdos Mais Visualizados</q-item-label>
        </q-item-section>
      </q-item>
        <q-item clickable>
          <q-item-section>Conteúdos publicados por Ano</q-item-section>
          <q-item-section side>
            <q-icon name="keyboard_arrow_right" />
          </q-item-section>
          <q-menu anchor="top right" self="top left">
                <q-list>
                  <q-item
                    clickable 
                    v-for="ano in anos"
                    :key="ano.anopublicacao"
                    
                    dense
                    @click="conteudosPorAno(ano.anopublicacao)"
                  >
                  <q-item-section>{{ano.anopublicacao}}</q-item-section>
                  </q-item>
                </q-list>
          </q-menu>
          </q-item>
        </q-item>
      <q-separator />
      </q-expansion-item>
</template>
<script>
    import { Notify } from 'quasar';
    export default {
        name : "ReportsMenu",
        anosPublicacoes : [],
       
        data () 
        {
            return {
               anos:[],
               rolesUsers : []
            }
        },
        mounted() {
          
        },
        created() 
        {
          this.anosPublicacoes();
          this.rolesMenuReport();
        },
        methods:{
          async usuariosRelatorio(role_id, is_active){
              this.$q.loading.show();
              let response = await axios.get(`/relatorio/usuarios/role/${role_id}\/${is_active}` ,{responseType: 'arraybuffer'});
              this.$q.loading.hide();
              this.downloadPdf(response)
          },
          async rolesMenuReport()
          {
             let response = await axios.get("/roles");
             
             this.rolesUsers = response.data.paginator.data;
          },
          downloadPdf(response)
          {
              let blob = new Blob([response.data], { type: 'application/pdf' }),
              url = window.URL.createObjectURL(blob)
              window.open(url) 
          },
          async maisBaixadosRelatorio()
          {
              this.$q.loading.show();
              let response = await axios.get("/relatorio/conteudos/baixados",{responseType: 'arraybuffer'});
              this.$q.loading.hide();
              this.downloadPdf(response)
          },
          async maisVisualizadosRelatorio()
          {
             this.$q.loading.show();
             let response = await axios.get("/relatorio/conteudos/visualizados", {responseType: 'arraybuffer'});
             this.$q.loading.hide();
             this.downloadPdf(response);
          },
          async anosPublicacoes()
          {
             let response = await axios.get("/relatorio/anospublicacao");
             this.anos = response.data;
          },
          async conteudosPorAno(ano){
              this.$q.loading.show();
              let response = await axios.get(`/relatorio/conteudosporoano/${ano}`, {responseType: 'arraybuffer'});
              this.$q.loading.hide();
              this.downloadPdf(response);
          }
        }
    }
    
</script>