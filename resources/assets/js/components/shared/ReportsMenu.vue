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
      <q-menu
        anchor="top right"
        self="top left"
      >
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
    <q-item
      clickable
      @click="maisBaixadosRelatorio()"
      aria-label="Conteudos Mais Baixados"
      active-class="active-link-pat"
    >
      <q-item-section>
        <q-item-label>Conteúdos Mais Baixados</q-item-label>
      </q-item-section>
    </q-item>
    <q-separator />
    <!-- GALERIA -->
    <q-item
      clickable
      aria-label=""
      active-class="active-link-pat"
      @click="maisVisualizadosRelatorio()"
      exact
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
      <q-menu
        anchor="top right"
        self="top left"
      >
        <q-list>
          <q-item
            v-for="ano in anos"
            :key="ano.anopublicacao"
            dense
          >
            <q-item-section>{{ano.anopublicacao}}</q-item-section>
            <q-separator
              vertical
              inset
            />
            <q-btn
              style="margin-left: 5px;"
              size="10px"
              color="primary"
              label="PDF"
              padding="xs"
              @click="conteudosPorAno(ano.anopublicacao, 'PDF')"
            />

            <q-btn
              padding="xs"
              :id="`gerar_planilha-${ano.anopublicacao}`"
              style="margin-left: 5px;"
              size="10px"
              color="primary"
              label="Gerar Planilha para Exportar"
              @click="conteudosPorAno(ano.anopublicacao, 'EXCEL')"
              v-show="esconder"
            />

            <xlsx-workbook>
              <xlsx-sheet
                :collection="sheet.data"
                v-for="sheet in sheets"
                :key="sheet.name"
                :sheet-name="sheet.name"
              />

              <xlsx-download filename='Planilha por ano.xlsx'>
                <q-btn
                  :id="`${ano.anopublicacao}`"
                  size="xs"
                  color="negative"
                  label="Download em Excel"
                  v-if="ano_escolhido==ano.anopublicacao"
                />

              </xlsx-download>
            </xlsx-workbook>

          </q-item>
        </q-list>
      </q-menu>
    </q-item>

    <q-item
      to="/admin/quantidade_arquivos"
      aria-label="Quantidade de Arquivos"
      title="Quantidade de Arquivos"
      clickable
      tabindex="0"
      active-class="active-link-pat"
      exact
    >
      <q-item-section>
        <q-item-label>Quantidade de arquivos por Tipos de Conteúdos</q-item-label>
      </q-item-section>
    </q-item>
    <q-separator />
  </q-expansion-item>
</template>
<script>
import { Notify } from "quasar";
import XlsxWorkbook from "../../../../../node_modules/vue-xlsx/dist/components/XlsxWorkbook";
import XlsxSheet from "../../../../../node_modules/vue-xlsx/dist/components/XlsxSheet";
import XlsxDownload from "../../../../../node_modules/vue-xlsx/dist/components/XlsxDownload";
export default {
  name: "ReportsMenu",
  anosPublicacoes: [],
  components: {
    XlsxWorkbook,
    XlsxSheet,
    XlsxDownload,
  },

  data() {
    return {
      ano_escolhido: "",
      anos: [],
      rolesUsers: [],
      sheets: [],
      esconder: true,
    };
  },
  mounted() {},
  created() {
    this.anosPublicacoes();
    this.rolesMenuReport();
  },
  methods: {
    async usuariosRelatorio(role_id, is_active) {
      this.$q.loading.show();
      let response = await axios.get(
        `/relatorio/usuarios/role/${role_id}\/${is_active}`,
        { responseType: "arraybuffer" }
      );
      this.$q.loading.hide();
      this.downloadPdf(response);
    },
    async rolesMenuReport() {
      let response = await axios.get("/roles");

      this.rolesUsers = response.data.paginator.data;
    },
    downloadPdf(response) {
      let blob = new Blob([response.data], { type: "application/pdf" }),
        url = window.URL.createObjectURL(blob);
      window.open(url);
    },
    async maisBaixadosRelatorio() {
      this.$q.loading.show();
      let response = await axios.get("/relatorio/conteudos/baixados", {
        responseType: "arraybuffer",
      });
      this.$q.loading.hide();
      this.downloadPdf(response);
    },
    async maisVisualizadosRelatorio() {
      this.$q.loading.show();
      let response = await axios.get("/relatorio/conteudos/visualizados", {
        responseType: "arraybuffer",
      });
      this.$q.loading.hide();
      this.downloadPdf(response);
    },
    async anosPublicacoes() {
      let response = await axios.get("/relatorio/anospublicacao");
      this.anos = response.data;
    },
    async conteudosPorAno(ano, tipo) {
      if (tipo == "PDF") {
        this.$q.loading.show();
        let response = await axios.get(
          `/relatorio/conteudosporoano/${ano}\/${tipo}`,
          {
            responseType: "arraybuffer",
          }
        );
        this.$q.loading.hide();
        this.downloadPdf(response);
      }

      if (tipo == "EXCEL") {
        this.$q.loading.show();
        let response = await axios.get(
          `/relatorio/conteudosporoano/${ano}\/${tipo}`
        );
        this.$q.loading.hide();

        if (response) {
          this.sheets = [
            {
              name: "Conteudos por Ano",
              data: response.data,
            },
          ];
          (this.ano_escolhido = ano), (this.esconder = true);
        }

        console.log(response);
        //this.downloadPdf(response);
      }
    },
  },
};
</script>