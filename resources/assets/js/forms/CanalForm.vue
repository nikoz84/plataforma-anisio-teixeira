<template>
    <div class="row q-pa-md">
      <div class="col-sm-6">
        <form v-on:submit.prevent="save()">
          <q-stepper
            v-model="step"
            vertical
            color="primary"
            animated
          >
            <q-step
              :name="1"
              title="Nome do Canal, Url Amigável, URL da API"
              icon="settings"
              :done="step > 1"
            >
              <q-input filled v-model.trim="canal.options.extend_name" label="Nome do canal em extenso" hint="Verdadeiro nome do canal em extenso"></q-input>
              <q-input filled v-model.trim="canal.name" label="Nome do Canal" hint="Nome abreviado ou reduzido"></q-input>
              <q-input filled v-model.trim="canal.slug" label="Url Amigável" hint="Url amigável separado por ifens e em minusculas sem espaços"></q-input>
              <q-input filled v-model.trim="canal.options.back_url" label="URL da API" hint="BackEnd URL"></q-input>
              <q-select filled 
                        v-model="canal.tipos"
                        use-input
                        use-chips
                        multiple
                        option-value="id"
                        option-label="name"
                        input-debounce="0"
                        :options="tipos"
                        label="Tipos de conteúdos" 
                        hint="Tipos de conteúdos que o canal vai cadastrar">
              </q-select>
              
              <q-stepper-navigation>
                <q-btn @click="step = 2" color="primary" label="Próximo" />
              </q-stepper-navigation>
            </q-step>
            <q-step
              :name="2"
              title="Descrição e complementos da descrição"
              icon="settings"
              :done="step > 2"
            >
              <div class="q-mt-md">
                <p class="text-center">Escreva uma descrição do canal</p>
              </div>
              <q-editor v-model="canal.description" min-height="15rem" id="editor"/>
              <div class="q-mt-md">
                <p class="text-center">Complementos da descrição</p>
              </div>
              <q-input
                  label="O quê?"
                  v-model="canal.options.complement_description.que"
                  filled
                  type="textarea"
                  hint="Razão de ser do canal"
                />
              <q-input
                  label="O cômo"
                  v-model="canal.options.complement_description.como"
                  filled
                  type="textarea"
                  hint="Cômo o canal pode ajudar seus usuários"
                />
              <q-input
                  label="O porquê"
                  v-model="canal.options.complement_description.porque"
                  filled
                  type="textarea"
                  hint="Porquê existe o canal"
                />
              
                
              <q-stepper-navigation>
                <q-btn @click="step = 3" color="primary" label="Próximo" />
                <q-btn flat @click="step = 1" color="primary" label="Voltar" class="q-ml-sm" />
              </q-stepper-navigation>
            </q-step>
            <q-step
              :name="3"
              title="Ativar: Canal, Possui Home, Possui Categorias, Possui Acesso Rápido, Possui Sobre"
              icon="settings"
              :done="step > 2"
            >
            <q-toggle
                  class="q-mt-md"
                  label="Ativar ou Desativar Canal"
                  color="pink"
                  checked-icon="check"
                  unchecked-icon="clear"
                  v-model="canal.is_active"
                />
              <q-toggle
                class="q-mt-md"
                label="O canal possui página de inicio?"
                color="pink"
                checked-icon="check"
                unchecked-icon="clear"
                v-model="canal.options.has_home"
              />
              <q-toggle
                class="q-mt-md"
                label="O canal possui categorias?"
                color="pink"
                checked-icon="check"
                unchecked-icon="clear"
                v-model="canal.options.has_categories"
              />
              <q-toggle
                class="q-mt-md"
                label="O canal possui acesso rápido na página de inicio?"
                color="pink"
                checked-icon="check"
                unchecked-icon="clear"
                v-model="canal.options.has_quick_access"
              />
              <q-toggle
                class="q-mt-md"
                label="O canal possui sobre?"
                color="pink"
                checked-icon="check"
                unchecked-icon="clear"
                v-model="canal.options.has_about"
              />
              <q-color
                v-model="canal.options.color"
                :default-value="canal.options.color"
                style="max-width: 250px; margin-top:30px;"
              />
          
          <q-stepper-navigation>
                <q-btn flat @click="step = 2" color="primary" label="Voltar" class="q-ml-sm" />
                <q-btn class="full-width q-mt-md" label="Salvar" type="submit" color="primary"/>
              </q-stepper-navigation>
            </q-step>
          </q-stepper>
        </form>
      </div>
      <div class="col-sm-6"> 
        <q-card flat bordered class="q-ml-sm">
          <q-card-section>
            <p v-if="canal.id">ID: <strong>{{canal ? canal.id : null }}</strong></p> 
            <p>URL AMIGÁVEL: <strong>{{url}}</strong></p> 
            <p>ATIVO: <strong>{{active}}</strong></p>
            <p>NOME: <strong>{{canal.name}}</strong></p>
            <p>NOME EM EXTENSO: <strong>{{canal.options.extend_name}}</strong></p>
            <p>TIPOS DE CONTEÚDOS: <strong v-for="(tipo, t) in canal.tipos" :key="t"> {{tipo.name}} </strong></p>
          </q-card-section>
          <q-card-section v-if="canal.options">
            <p>DESCRIÇÃO: <small v-html="canal.description"></small></p>
            <p>O QUÊ?: <span>{{canal.options.complement_description.porque}}</span></p>
            <p>O PORQUÊ: <span>{{canal.options.complement_description.porque}}</span></p>
            <p>O CÔMO: <span>{{canal.options.complement_description.como}}</span></p>
          </q-card-section>
        </q-card>
       </div>
    </div>
</template>
<script>
import {
  QInput,
  QEditor,
  QCard,
  QCardSection,
  QBtn,
  QToggle,
  QColor,
  QStepper,
  QStep,
  QStepperNavigation
} from "quasar";

export default {
  name: "CanalForm",
  components: {
    QInput,
    QEditor,
    QCard,
    QCardSection,
    QBtn,
    QToggle,
    QColor,
    QStepper,
    QStep,
    QStepperNavigation
  },
  data() {
    return {
      step: 1,
      tipos: [],
      canal: {
        name: "",
        description: "",
        slug: "",
        is_active: false,
        options: {
          color: "",
          back_url: "",
          extend_name: "",
          has_about: false,
          has_categories: false,
          has_home: false,
          has_quick_access: false,
          order_menu: null,
          tipo_conteudo: null,
          complement_description: {
            que: "",
            como: "",
            porque: ""
          }
        }
      }
    };
  },
  created() {
    this.getCanal();
    this.getTipos();
  },
  computed: {
    url() {
      let slug = this.canal ? this.canal.slug : "url-amigavel";
      return `http://${window.location.hostname}/${slug}`;
    },
    active() {
      return this.canal.is_active ? "Sim" : "Não";
    }
  },
  methods: {
    async save() {
      let id = this.$route.params.id ? `/${this.$route.params.id}` : "";
      let form = new FormData();

      this.canal.options.tipo_conteudo = this.canal.tipos.map(i => i.id);
      form.append("name", this.canal.name);
      form.append("is_active", this.canal.is_active);
      form.append("options", this.canal.options);
      form.append("slug", this.canal.slug);
      form.append("description", this.canal.description);
      if (this.$route.params.action == "editar") {
        form.append("_method", "PUT");
      }

      let resp = await axios.post(this.$route.params.slug + id, form);
      if (resp.data.success) {
        this.$q.notify({
          message: resp.data.message,
          color: "grey-4",
          textColor: "primary",
          possition: "center"
        });
      } else {
        this.$q.notify({
          message: resp.data.message,
          color: "grey-4",
          textColor: "primary",
          possition: "center"
        });
      }
    },
    async getTipos() {
      let resp = await axios.get("tipos");
      if (resp.data.success) {
        this.tipos = resp.data.metadata;
      }
    },
    async getCanal() {
      if (!this.$route.params.id) return;
      let resp = await axios.get(`canais/${this.$route.params.id}`);
      if (resp.data.success) {
        this.canal = resp.data.metadata;
      }
    }
  }
};
</script>
<style lang="stylus" scoped>
</style>
