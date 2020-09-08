 <template>
      <q-expansion-item
        dense
        dense-toggle
        expand-separator
        label="Relatórios"
      >
      <q-separator />

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
        exact>
        <q-item-section>
          <q-item-label>Conteúdos Mais Visualizados</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
      </q-expansion-item>
</template>
<script>
    import { Notify } from 'quasar';
    export default {
        name : "ReportsMenu",
        methods:{
          downloadPdf(response)
          {
              this.loaddingIcon = true;
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
          }
        }
    }
    
</script>