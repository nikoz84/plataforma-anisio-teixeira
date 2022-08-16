<template>
  <div class="q-pa-md row justify-center q-gutter-xs">
    <q-stepper v-model="step" ref="stepper" color="primary" header-nav animated>
      <!-- STEPER 1 -->
      <q-step
        :name="1"
        title="Informações básicas"
        icon="settings"
        :error="false"
        :done="step > 1"
      >
        <b
          >Em essa seção você encontrará: TÍTULO, TIPO DE CONTEÚDO, CANAL,
          CATEGORIA DO CANAL, LICENÇA, AUTORES E FONTE
        </b>
        <!-- TITLE -->
        <q-input
          v-model="conteudo.title"
          label="Título do Conteúdo"
          autogrow
          dense
          bottom-slots
          :error="errors && errors.title && errors.title.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.title"></ShowErrors>
          </template>
        </q-input>
        <!-- TIPO CONTEÚDO -->
        <q-select
          dense
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.tipo_id"
          :options="tipos"
          label="Tipo de Mídia"
          :error="errors && errors.tipo_id && errors.tipo_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.tipo_id"></ShowErrors>
          </template>
        </q-select>
        <!-- CANAIS -->
        <q-select
          dense
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.canal_id"
          :options="canais"
          label="Escolha um Canal"
          @input="getCategories"
          :error="errors && errors.canal_id && errors.canal_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.canal_id"></ShowErrors>
          </template>
        </q-select>
        <!-- CATEGORIAS -->
        <q-select
          v-if="categories && categories.length > 0"
          dense
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.category"
          :options="categories"
          @input="setCategory"
          options-selected-class="text-deep-orange"
          :label="`Escolha um(a) ${categoryName}`"
          :error="errors && errors.category_id && errors.category_id.length > 0"
          bottom-slots
        >
          <template v-slot:option="scope">
            <q-item
              v-if="scope.opt.has_children"
              :active="true"
              active-class="bg-teal-1 text-grey-8"
            >
              <q-item-section>
                <q-item-label>{{ scope.opt.name }}</q-item-label>
              </q-item-section>
            </q-item>
            <q-item
              v-else
              clickable
              v-ripple
              v-close-popup
              @click="setCategory(scope.opt)"
              :class="{
                'bg-light-blue-5': conteudo.category_id === scope.opt.id,
              }"
            >
              <q-item-section>{{ scope.opt.name }}</q-item-section>
            </q-item>
            <q-separator></q-separator>
            <template>
              <q-item
                v-for="child in scope.opt.sub_categories"
                :key="child.id"
                clickable
                v-ripple
                v-close-popup
                @click="setCategory(child)"
                :class="{
                  'bg-light-blue-5': conteudo.category_id === child.id,
                }"
                style="border: solid 1px #ddd"
              >
                <q-item-section>
                  <q-item-label v-html="child.name"></q-item-label>
                </q-item-section>
              </q-item>
            </template>
          </template>
          <template v-slot:error>
            <ShowErrors :errors="errors.category_id"></ShowErrors>
          </template>
        </q-select>

        <!-- LICENÇAS -->
        <q-select
          v-if="licencas && licencas.length > 0"
          dense
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.license"
          :options="licencas"
          @input="setLicense"
          options-selected-class="text-deep-orange"
          label="Escolha uma licença"
          :error="errors && errors.license_id && errors.license_id.length > 0"
          bottom-slots
        >
          <template v-slot:option="scope">
            <q-item
              v-if="scope.opt.has_children"
              :active="true"
              active-class="bg-teal-1 text-grey-8"
            >
              <q-item-section>
                <q-item-label>{{ scope.opt.name }}</q-item-label>
              </q-item-section>
            </q-item>
            <q-item
              v-else
              clickable
              v-ripple
              v-close-popup
              @click="setLicense(scope.opt)"
              :class="{
                'bg-light-blue-5': conteudo.license_id === scope.opt.id,
              }"
            >
              <q-item-section>{{ scope.opt.name }}</q-item-section>
            </q-item>
            <q-separator></q-separator>
            <template>
              <q-item
                v-for="child in scope.opt.childs"
                :key="child.id"
                clickable
                v-ripple
                v-close-popup
                @click="setLicense(child)"
                :class="{ 'bg-light-blue-5': conteudo.license_id === child.id }"
                style="border: solid 1px #ddd"
              >
                <q-item-section>
                  <q-item-label
                    v-html="child.name"
                    class="q-ml-md"
                  ></q-item-label>
                </q-item-section>
              </q-item>
            </template>
          </template>
          <template v-slot:error>
            <ShowErrors :errors="errors.license_id"></ShowErrors>
          </template>
        </q-select>

        <!-- AUTORES -->
        <q-input
          dense
          v-model="conteudo.authors"
          label="Autores"
          autogrow
          bottom-slots
          :error="errors && errors.authors && errors.authors.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.authors"></ShowErrors>
          </template>
        </q-input>
        <!-- FONTE -->
        <q-input
          dense
          v-model="conteudo.source"
          label="Fonte"
          autogrow
          bottom-slots
          :error="errors && errors.source && errors.source.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.source"></ShowErrors>
          </template>
        </q-input>
      </q-step>
      <!-- STEPER 2 -->
      <q-step
        :name="2"
        title="Informações complementares"
        icon="create_new_folder"
        :done="step > 2"
      >
        <!-- DESCRIÇÃO -->
        <b class="q-my-lg"
          >Para melhorar a qualidade de nossa oferta e busca de conteúdos,
          escreva uma descrição como mínimo de 100 caracteres</b
        >
        <q-editor
          v-model="conteudo.description"
          min-height="18rem"
          ref="editor_ref"
          @paste.native="(evt) => pasteCapture(evt)"
          :toolbar="[['bold', 'italic', 'strike', 'underline']]"
        />

        <ShowErrors
          v-if="errors && errors.description && errors.description.length > 0"
          :errors="errors.description"
        >
        </ShowErrors>
        <q-separator class="q-my-lg"></q-separator>
        <b class="q-my-lg"
          >Pesquise como mínimo 3 até 15 palavras-chave para aprimorar os
          resultados de busca. Se não achar a palavra, escreva uma palavra e
          adicione apertando enter, aparecerá na parte inferior da sua tela uma
          opção para salvar
        </b>
        <!-- TAGS -->
        <q-select
          dense
          v-model="conteudo.tags"
          use-input
          hint="Adicione palavras-chave"
          multiple
          option-value="id"
          option-label="name"
          use-chips
          stack-label
          hide-dropdown-icon
          label="Palavras-Chave"
          input-debounce="200"
          new-value-mode="add-unique"
          @new-value="addTag"
          :options="autocompleteTags"
          @filter="getTags"
          bottom-slots
          map-options
          :error="errors && errors.tags && errors.tags.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.tags"></ShowErrors>
          </template>
          <template v-slot:no-option>
            <q-item>
              <q-item-section class="text-grey">
                Sem Resultados
              </q-item-section>
            </q-item>
          </template>
        </q-select>
      </q-step>
      <q-step
        :name="3"
        title="Componentes e níveis de ensino"
        icon="create_new_folder"
        :done="step > 3"
      >
        <q-tabs
          v-model="tab"
          dense
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab name="componentes" label="Componentes Curriculares" />
          <q-tab name="niveis" label="Níveis de Ensino" />
        </q-tabs>

        <q-separator />

        <q-tab-panels
          v-model="tab"
          animated
          :class="{
            'error-card':
              errors && errors.componentes && errors.componentes.length > 0,
          }"
        >
          <q-tab-panel name="componentes" v-if="componentes">
            <div class="text-h6 q-mb-md">Escolha um Componente Curricular</div>
            <q-list
              dense
              bordered
              v-for="component in componentes"
              :key="`c-${component.id}`"
            >
              <q-expansion-item
                header-class="text-deep-purple"
                expand-separator
                :label="component.name"
              >
                <q-item>
                  <q-item-section>
                    <q-toggle
                      @input="selectAll(component)"
                      v-model="allCheckbox"
                      :val="component.id"
                      label="Marcar Todas"
                    />
                  </q-item-section>
                </q-item>
                <q-item
                  dense
                  v-ripple
                  v-for="(component, i) in component.componentes"
                  :key="`child-com-${i}`"
                >
                  <q-item-section avatar>
                    <q-checkbox
                      dense
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="purple"
                    />
                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{ component.name }}
                  </q-item-label>
                </q-item>
              </q-expansion-item>
            </q-list>
          </q-tab-panel>

          <q-tab-panel name="niveis" v-if="niveis">
            <div class="text-h6 q-mb-md">Escolha um Nível de Ensino</div>
            <q-list
              dense
              bordered
              v-for="nivel in niveis"
              :key="`n-${nivel.id}`"
            >
              <q-expansion-item :label="nivel.name">
                <q-item>
                  <q-item-section>
                    <q-toggle
                      @input="selectAll(nivel)"
                      v-model="allCheckbox"
                      :val="nivel.id"
                      label="Marcar Todas"
                    />
                  </q-item-section>
                </q-item>
                <q-item
                  v-for="(component, i) in nivel.componentes"
                  :key="`child-com-${i}`"
                  v-ripple
                >
                  <q-item-section avatar>
                    <q-checkbox
                      dense
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="teal"
                    />
                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{ component.name }}
                  </q-item-label>
                </q-item>
              </q-expansion-item>
            </q-list>
          </q-tab-panel>
        </q-tab-panels>

        <q-card-section
          v-if="errors && errors.componentes && errors.componentes.length > 0"
        >
          <ShowErrors :errors="errors.componentes"></ShowErrors>
        </q-card-section>
      </q-step>

      <!-- STEPER 4 -->
      <q-step :name="4" title="Upload de arquivos" icon="add_comment">
        <b
          >IMAGEN ASSOCIADA, ARQUIVO PARA DOWNLOAD, GUIA PEDAGÓGICO, URL SITE,
          APROVAR CONTEÚDO, MARCAR COMO DESTAQUE, TERMOS DE USO</b
        >

        <q-img
          loading="lazy"
          width="640"
          height="460"
          :src="conteudo.image"
          :placeholder-src="`/img/fundo-padrao.svg`"
          alt="imagem de destaque"
        />
        <!-- IMAGEM DE DESTAQUE -->
        <q-input
          @input="
            (val) => {
              file = val[0];
            }
          "
          outlined
          accept=".png,.jpeg,.jpg,.svg,.webp"
          @change="onImageFileChange"
          type="file"
          hint="IMAGEM de destaque"
          bottom-slots
          :error="
            errors &&
            errors.imagem_associada &&
            errors.imagem_associada.length > 0
          "
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.imagem_associada"></ShowErrors>
          </template>
        </q-input>

        <DeleteFiles
          message="Download"
          :file="
            conteudo && conteudo.arquivos ? conteudo.arquivos['download'] : null
          "
          directory="download"
        >
        </DeleteFiles>
        <DeleteFiles
          message="Visualização"
          :file="
            conteudo && conteudo.arquivos
              ? conteudo.arquivos['visualizacao']
              : null
          "
          directory="visualizacao"
        >
        </DeleteFiles>
        <q-input
          class="q-mt-md"
          @input="
            (val) => {
              file = val[0];
            }
          "
          outlined
          @change="onDownloadFileChange"
          type="file"
          hint="Arquivo para Download"
          bottom-slots
          :error="errors && errors.download && errors.download.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.download"></ShowErrors>
          </template>
        </q-input>
        <!-- ARQUIVO DE UPLOAD -->
        <br />
        <DeleteFiles
          message="Guias Pedagógicos"
          :file="
            conteudo && conteudo.arquivos
              ? conteudo.arquivos['guias-pedagogicos']
              : null
          "
          directory="guias-pedagogicos"
        >
        </DeleteFiles>

        <q-input
          dense
          class="q-mt-md"
          @input="
            (val) => {
              file = val[0];
            }
          "
          @change="onguiaPedagogicoFileChange"
          type="file"
          hint="Arquivo para Guia Pedagógico"
          bottom-slots
          :error="
            errors &&
            errors.guias_pedagogicos &&
            errors.guias_pedagogicos.length > 0
          "
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.guias_pedagogicos"></ShowErrors>
          </template>
        </q-input>
        <!-- ENVIAR SITE -->
        <br />
        <q-input
          dense
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
          bottom-slots
          :error="
            errors &&
            errors.options &&
            errors.options.site &&
            errors.options.site.length > 0
          "
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.options.site"></ShowErrors>
          </template>
        </q-input>

        <div class="q-gutter-sm q-my-lg">
          <!-- APROVAR -->
          <q-checkbox
            v-model="conteudo.is_approved"
            label="Aprovar conteúdo"
            color="pink"
            true-value="true"
            false-value="false"
            :toggle-indeterminate="false"
          />
          <div
            v-if="errors && errors.is_approved && errors.is_approved.length > 0"
          >
            <ShowErrors :errors="errors.is_approved"></ShowErrors>
          </div>

          <!-- MARCAR COMO DESTAQUE -->
          <q-checkbox
            v-model="conteudo.is_featured"
            label="Marcar como destaque"
            color="pink"
            true-value="true"
            false-value="false"
            :toggle-indeterminate="false"
          />
          <div
            v-if="errors && errors.is_featured && errors.is_featured.length > 0"
          >
            <ShowErrors :errors="errors.is_featured"></ShowErrors>
          </div>
        </div>
        <!-- TERMOS DE USO -->
        <div class="q-my-lg">
          Li e concordo com os <a href="#terms">termos e condições de uso</a> :
          <q-checkbox
            v-model="terms"
            color="pink"
            true-value="true"
            false-value="false"
            :toggle-indeterminate="false"
          />
          <div v-if="errors && errors.terms && errors.terms.length > 0">
            <ShowErrors :errors="errors.terms"></ShowErrors>
          </div>
        </div>
      </q-step>

      <template v-slot:navigation>
        <q-stepper-navigation>
          <!-- SALVAR -->
          <q-btn
            color="primary"
            @click="save()"
            label="Salvar"
            :loading="loading"
            v-if="step === 4"
          ></q-btn>
          <q-btn
            v-else
            @click="$refs.stepper.next()"
            color="primary"
            label="Continuar"
          />
          <q-btn
            v-if="step > 1"
            flat
            color="primary"
            @click="$refs.stepper.previous()"
            label="Voltar"
            class="q-ml-sm"
          />
        </q-stepper-navigation>
      </template>
    </q-stepper>
  </div>
</template>

<script>
import { ShowErrors } from "@/forms/shared";
import { PasteCapture } from "@/mixins/RemoveFormat";
import DeleteFiles from "./DeleteFiles.vue";
import { ClosePopup } from "quasar";

export default {
  name: "ConteudoForm",
  mixins: [PasteCapture],
  directives: {
    ClosePopup,
  },
  components: {
    DeleteFiles,
    ShowErrors,
  },
  data() {
    return {
      step: 1,
      conteudo: {
        download: "",
        guiaPedagogico: "",
        license_id: "",
        canal_id: "",
        category_id: "",
        tipo_id: "",
        title: "",
        description: "",
        canal: "",
        options: {
          site: "",
        },
        category: null,
        license: null,
        authors: "",
        source: "",
        image: "",
        tags: [],
        componentes: [],
        is_approved: false,
        is_featured: false,
        is_site: false,
      },
      canais: [],
      terms: null,
      tipos: [],
      componentesCurriculares: [],
      niveis: [],
      componentes: [],
      licencas: [],
      autocompleteTags: [],
      categoryName: null,
      selectedCategory: "",
      categories: [],
      imagem_associada: null,
      download_file: null,
      guias_pedagogicos: null,
      license_description: null,
      loading: false,
      errors: {},
      dialog: {
        text: "",
        open: false,
        confirm: false,
        new_tag: "",
      },
      tab: "componentes",
      allCheckbox: [],
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    onImageFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.imagem_associada = files[0];
    },
    onDownloadFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.download_file = files[0];
    },
    onguiaPedagogicoFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.guias_pedagogicos = files[0];
    },
    async save() {
      this.loading = true;
      const form = new FormData();
      form.append("title", this.conteudo.title);
      form.append("tipo_id", this.conteudo.tipo_id);
      form.append(
        "category_id",
        this.conteudo.category_id ? this.conteudo.category_id : null
      );
      form.append("canal_id", this.conteudo.canal_id);
      form.append("license_id", this.conteudo.license_id);
      form.append("title", this.conteudo.title);
      form.append("description", this.conteudo.description);
      form.append("source", this.conteudo.source);
      form.append("authors", this.conteudo.authors);
      this.componentesCurriculares.map((item) => {
        form.append("componentes[]", item);
      });
      this.conteudo.tags.map((item) => {
        form.append("tags[]", item.id);
      });
      console.log(this.terms);
      form.append("terms", this.terms);
      console.log(this.conteudo.is_featured);
      form.append("is_featured", this.conteudo.is_featured);
      form.append("is_approved", this.conteudo.is_approved);
      form.append("is_site", this.conteudo.options.site == "" ? 0 : 1);
      form.append(
        "options",
        JSON.stringify({ site: this.conteudo.options.site })
      );

      /*
      form.append(
        "conteudo",
        JSON.stringify({
          category_id: this.conteudo.category_id
            ? this.conteudo.category_id
            : null,
          title: this.conteudo.title,
          tipo_id: this.conteudo.tipo_id,
          canal_id: this.conteudo.canal_id,
          license_id: this.conteudo.license_id,
          title: this.conteudo.title,
          description: this.conteudo.description,
          source: this.conteudo.source,
          authors: this.conteudo.authors,
          componentes: this.componentesCurriculares,
          tags: this.conteudo.tags.map((item) => item.id),
          terms: this.terms,
          is_featured: this.conteudo.is_featured,
          is_approved: this.conteudo.is_approved,
          is_site: this.conteudo.options.site == "" ? false : true,
          options: {
            site: this.conteudo.options.site,
          },
        })
      );
      */
      if (this.imagem_associada) {
        form.append("imagem_associada", this.imagem_associada);
      }
      if (this.download_file) {
        form.append("download", this.download_file);
      }
      if (this.guias_pedagogicos) {
        form.append("guias_pedagogicos", this.guias_pedagogicos);
      }

      let url = "/conteudos";
      if (this.$route.params.id) {
        form.append("id", this.conteudo.id);
        form.append("_method", "PUT");
        url = url + "/" + this.conteudo.id;
      }
      try {
        const { data } = await axios.post(url, form, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        this.loading = false;
        if (data.success == true) {
          this.$router.push(`/admin/conteudos/listar`);
        }
      } catch (ex) {
        this.errors = ex.errors;
        this.loading = false;
      }
    },

    async getCategories(val) {
      if (!val) return;
      const id = val.hasOwnProperty("id") ? val.id : val;
      this.$q.loading.show();
      try {
        const { data } = await axios.get(`/categorias/canal/${id}`);
        console.log(data);
        this.categories = data.metadata.categories;
        this.categoryName = data.metadata.category_name;
        this.$q.loading.hide();
      } catch (error) {
        this.$q.loading.hide();
      }
    },
    getSubCategorias(val) {
      let subCat = null;
      if (!val) return;

      subCat = this.categories.filter((item) => {
        return item.id == val;
      });
      return subCat;
    },
    async getData() {
      this.$q.loading.show();

      const canais = await axios.get("/canais?select");
      const tipos = await axios.get("/tipos?select");
      const licencas = await axios.get("/licencas?select");
      const niveis = await axios.get("/niveis-ensino?select");
      const componentes = await axios.get("/componentescategorias?select");
      this.canais = canais.data.metadata;
      this.tipos = tipos.data.metadata;
      this.licencas = licencas.data.metadata;
      this.niveis = niveis.data.metadata;
      this.componentes = componentes.data.metadata;
      //this.componentesCurriculares = componentes.data.metadata;

      if (this.$route.params.id) {
        let { data } = await axios.get("/conteudos/" + this.$route.params.id);
        this.conteudo = data.metadata;

        this.componentesCurriculares = data.metadata.componentes.map(
          (a) => a.id
        );
      }
      this.$q.loading.hide();
      if (this.conteudo.category && this.conteudo.canal) {
        this.getCategories(this.conteudo.canal);
        //this.selectedCategory = this.conteudo.category.name;
      }
    },
    setCategory(cat) {
      this.conteudo.category = cat;
      this.conteudo.category_id = cat.id;
    },
    setLicense(license) {
      this.conteudo.license = license;
      this.conteudo.license_id = license.id;
    },
    selectAll(componente) {
      const { componentes } = componente;
      if (this.allCheckbox.includes(componente.id)) {
        componentes.map((c) => {
          this.componentesCurriculares.push(c.id);
        });
        this.componentesCurriculares = [
          ...new Set(this.componentesCurriculares),
        ];
      } else {
        componentes.map((c) => {
          const id = c.id;
          for (var i = 0; i < this.componentesCurriculares.length; i++) {
            if (this.componentesCurriculares[i] === id) {
              return this.componentesCurriculares.splice(i, 1);
            }
          }
        });
      }
    },
    setCanal(id) {
      this.conteudo.canal_id = id;

      this.getCategories({ id });
    },
    setTipo(id) {
      this.conteudo.tipo_id = id;
    },
    addTag(val, done) {
      console.log(val);
      this.showTagModal(val);
    },
    showTagModal(val) {
      this.$q.notify({
        message: `Essa palavra-chave não existe, deseja adicionar ${val}?`,
        multiLine: true,
        color: "grey-4",
        textColor: "primary",
        possition: "center",
        timeout: Math.random() * 5000 + 5000,
        actions: [
          {
            label: "Confirmar",
            color: "positive",
            handler: async () => {
              let tag = { name: val };

              let { data } = await axios.post("/tags", tag);

              if (data.success) {
                let label = data.metadata.name;
                //done({ id, label });
              }
            },
          },
          {
            label: "Cancelar",
            color: "secondary",
            handler: () => {
              //this.tags = this.tags.pop(0,);
            },
          },
        ],
      });
    },
    getTags(val, update, abort) {
      update(async () => {
        if (val === "" && val.length < 2) {
          this.autocompleteTags = [];
        } else {
          const { data } = await axios.get(`tags/autocomplete/${val}`);

          const term = val.toUpperCase();
          this.autocompleteTags = data.metadata.filter((item) => {
            console.log(item.name.toUpperCase());
            return item.name.toUpperCase().includes(term);
          });
        }
      });
    },
  },
};
</script>
<style lang="stylus" scoped>
.error-card {
  border: solid 2px #a54a54;
}
</style>
