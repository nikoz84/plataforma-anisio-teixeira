<template>
  <div class="q-pa-md row justify-center q-gutter-xs">
    <q-card class="col-sm-5">
      <q-card-section class="q-gutter-sm">
<<<<<<< HEAD
        <q-input
          v-model="conteudo.title"
          label="Título do conteúdo"
          autogrow
          dense
          bottom-slots
          :error="errors && errors.title && errors.title.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.title"></ShowErrors>
          </template>
          <template v-slot:after>
=======
          <q-input v-model="conteudo.title" 
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
>>>>>>> f9151613628e0cb8cdce5a1fe421eb5825b61663

            <q-btn
              round
              dense
              flat
              icon="info"
              @click="alert = true"
            />
          </template>
        </q-input>

        <q-dialog v-model="alert">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Critérios para Formatação do Título</div>
              <q-space />
              <q-btn
                icon="close"
                flat
                round
                dense
                v-close-popup
              />
            </q-card-section>

            <q-card-section>
              <p><strong>A formata&ccedil;&atilde;o do T&iacute;tulo deve obedecer aos seguintes crit&eacute;rios:</strong></p>
              <p><br /><strong>1.1</strong> Somente a inicial de cada palavra deve ser mai&uacute;scula, exceto em caso de siglas, como IBGE,<br />FMI etc.<br /><strong>Exemplos:</strong><br /><strong>a)</strong> Explorando o Ensino de Matem&aacute;tica<br /><strong>b)</strong> Anu&aacute;rio Estat&iacute;stico do Brasil - IBGE 2016</p>
              <p><br /><strong>1.2</strong> Havendo necessidade de se fazer refer&ecirc;ncia a m&oacute;dulo (m&oacute;d.), volume (vol.), tomo(tom.) edi&ccedil;&atilde;o<br />(ed.), cap&iacute;tulo (cap.), parte (par.), bloco (blc.) etc., esse deve ser colocado sempre depois do t&iacute;tulo,<br />separado por 'h&iacute;fen' e de forma abreviada. Necessitando fazer refer&ecirc;ncia a mais de um desses itens,<br />devem aparecer nessa sequ&ecirc;ncia, separados por v&iacute;rgula.</p>
              <p><br /><strong>1.3</strong> Sempre que se fizer men&ccedil;&atilde;o a parti&ccedil;&otilde;es dos itens acima, est&aacute; deve ter o seguinte formato:<br />n&uacute;mero da parte/total de partes (sem o zero &agrave; esquerda)</p>
              <p><br /><strong>1.4</strong>. N&atilde;o deve ser mencionado o total de m&oacute;dulo, volume, tomo e edi&ccedil;&atilde;o, ainda que haja v&aacute;rios<br />deles no Ambiente.<br />Exemplos:<br /><strong>a)</strong> Explorando o Ensino de Geografia &ndash; vol. 8<br /><strong>b)</strong> Explorando o Ensino de Geografia &ndash; vol. 3<br /><strong>c)</strong> Entrevista com Clarice Lispector &ndash; par. 1/5<br /><strong>d)</strong> Geografia do Brasil &ndash; m&oacute;d. 2<br /><strong>e)</strong> Explorando o Ensino da Matem&aacute;tica &ndash; vol. 17, cap. 3/6<br /><strong>f)</strong> Explorando o Ensino de Geografia &ndash; ed. 2<br /><strong>g)</strong> Explorando o Ensino da Matem&aacute;tica &ndash; vol. 3, cap. 1/6, par. 1/2<br /><strong>OBSERVA&Ccedil;&Atilde;O</strong>: Deve-se colocar espa&ccedil;o entre o ponto da abrevia&ccedil;&atilde;o e o n&uacute;mero, como nos<br />exemplos acima.</p>
              <p><br /><strong>1.5</strong> Se o Conte&uacute;do Digital (CD) corresponder a um epis&oacute;dio de um quadro de um programa, o nome do programa, o nome do quadro e o n&uacute;mero do epis&oacute;dio n&atilde;o devem ser mencionados no t&iacute;tulo. Os campos 'canal' e 'categoria do conte&uacute;do digital' no Formul&aacute;rio Digital, dever&atilde;o ser preenchidas conforme itens 3 e 4.<br /><strong>Exemplo:</strong><br />Programa Intervalo &ndash; Fa&ccedil;a Acontecer: ep. 6 &ndash; Dispositivo de Seguran&ccedil;a para Panelas &ndash; Lucas Borges<br /><strong>Fica assim</strong>: Dispositivo de seguran&ccedil;a para panelas &ndash; Lucas Borges<br /><strong>OBSERVA&Ccedil;&Atilde;O</strong>: Sempre que nos referirmos a Conte&uacute;do Digital, a partir de agora, usaremos CD.</p>
              <p><br /><strong>1.6</strong> No caso de CD oriundos da web, o t&iacute;tulo original deve ser mantido na sua ess&ecirc;ncia, sendo, apenas, formatado para obedecer aos crit&eacute;rios estabelecidos nesse documento e corrigir erros de ortografia, quando houver.<br /><strong>Exemplos:</strong><br /><strong>a)</strong> T&iacute;tulo da web: a hist&oacute;ria da &Aacute;frica &ndash; Volume 1, Cap&iacute;tulo 2<br />Como deve ficar no AEW: A Hist&oacute;ria da &Aacute;frica &ndash; vol. 1, cap. 2<br />Manual Para Cataloga&ccedil;&atilde;o no Ambiente Educacional Web &ndash; 2016. Vers&atilde;o 1.1 &ndash; Rede An&iacute;sio Teixeira 3/13</p>
              <p><strong>1.7</strong> Caso o t&iacute;tulo apresente subt&iacute;tulo, o mesmo deve ser separado por h&iacute;fen, respeitando-se a ordem:<br />T&iacute;tulo &ndash; subt&iacute;tulo<br /><strong>Exemplo</strong>: Explorando o Ensino da Matem&aacute;tica &ndash; Geometria</p>
              <p><br /><strong>1.8</strong> Caso o t&iacute;tulo apresente cap&iacute;tulo e t&iacute;tulo do cap&iacute;tulo, esses devem ser separados por h&iacute;fen, escrito<br />primeiro o t&iacute;tulo do cap&iacute;tulo: T&iacute;tulo do cap&iacute;tulo &ndash; T&iacute;tulo &ndash; cap. x/y<br /><strong>Exemplo</strong>: A Geometria Euclidiana &ndash; Explorando o Ensino da Matem&aacute;tica &ndash; cap. 3/4<br /><strong>1.8.1</strong> Caso o t&iacute;tulo apresente, ainda, outros elementos constantes do item 1.2, deve-se obedecer &agrave; seguinte ordem: T&iacute;tulo do cap&iacute;tulo &ndash; T&iacute;tulo do livro &ndash; vol.x, cap. x/y, par. x/y<br /><strong>Exemplo</strong>: A Geometria Euclidiana &ndash; Explorando o Ensino da Matem&aacute;tica &ndash; vol. 1, cap. 1/3, par. 1/2</p>
              <p><br /><strong>1.9</strong> O nome da disciplina n&atilde;o deve ser colocado no t&iacute;tulo, a menos que fa&ccedil;a parte, de fato, dele.<br /><strong>Exemplos</strong>: Express&atilde;o &ldquo;Where is the restroom?&rdquo; &ndash; L&iacute;ngua inglesa</p>
              <p><br /><strong>1.10</strong> No t&iacute;tulo s&oacute; &eacute; permitida a utiliza&ccedil;&atilde;o de caracteres especiais que aparecem no teclado, exceto quando se tratar de letras gregas ou de t&iacute;tulo original oriundo da web.<br /><strong>Exemplos:</strong><br /><strong>a)</strong> A f&oacute;rmula: A = 2&pi;r<br /><strong>b)</strong> &Sigma; '&alpha;&gamma;&alpha;&pi;ώ (Eu te amo, em grego)</p>
            </q-card-section>
          </q-card>
        </q-dialog>

        <q-dialog v-model="titulo_existente">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Conteúdos encontrados com o mesmo Título</div>
              <q-space />
              <q-btn
                icon="close"
                flat
                round
                dense
                v-close-popup
              />
            </q-card-section>

            <q-card-section>

              <div class="q-pa-sm">
                <q-card
                  class="q-mt-sm"
                  v-for="(item, i) in results"
                  :key="`result-${i}`"
                >

                  <q-card-section class="q-px-sm">

                    <a
                      :href="item.url_exibir"
                      target="new"
                      class="text-dark"
                    >
                      <h5
                        class="q-my-xs"
                        v-html="item.title"
                      ></h5>
                    </a>
                    <q-separator class="q-my-md"></q-separator>
                    <div
                      class="paginator-excerpt"
                      v-html="item.description"
                    ></div>
                  </q-card-section>

                  <q-card-actions
                    horizontal
                    align="left"
                  >
                    <q-chip
                      color="primary"
                      text-color="white"
                      icon="event"
                    >
                      {{item.formated_date}}
                    </q-chip>

                    <q-chip>
                      <q-avatar
                        color="petecavermelho"
                        text-color="white"
                      >{{item.qt_access}}</q-avatar>
                      Acessos
                    </q-chip>

                    <q-chip
                      color="petecavermelho"
                      text-color="white"
                      clickable
                      @click="irTipoConteudo(item.tipo.id)"
                    >
                      {{item.tipo.name}}
                    </q-chip>

                    <q-chip
                      clickable
                      @click="irCanal(item.canal.slug)"
                      color="petecavermelho"
                      text-color="white"
                    >
                      {{item.canal.name}}
                    </q-chip>

                    <!--q-btn color="pink-9" type="a" target="_blank" :href="item.url_exibir">Visualizar</q-btn-->
                  </q-card-actions>
                </q-card>
              </div>
            </q-card-section>
          </q-card>
        </q-dialog>

        <q-btn
          label="Verificar se existe Conteúdo com o mesmo título"
          color="primary"
          stack
          size="xs"
          glossy
          @click="verificar_existencia()"
        />
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
      </q-card-section>

      <q-card-section class="q-gutter-sm">

        <!-- CATEGORIA 
        <ParentAndChildSelect :parent="categories" 
          :label="categoryName"
          :selectedId="conteudo.category_id"
          @click="setCategory"
        ></ParentAndChildSelect>
        <div class="q-my-md" v-if="errors && errors.category_id && errors.category_id.length > 0">
          <ShowErrors :errors="errors.category_id"></ShowErrors>
        </div>
          -->
        <!--q-select
          v-if="categories && categories.length > 0"
          outlined
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.category_id"
          :options="categories"
          @input="setCategory"
          @getOptionLabel="getOptionLabel"
          options-selected-class="text-deep-orange"
          label="Escolha uma Categoria"
          :error="errors && errors.category_id && errors.category_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.category_id"></ShowErrors>
          </template>
        </!--q-select -->

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

      </q-card-section>

      <q-card-section>
        <!-- TAGS -->
        <q-select
          dense
          v-model="conteudo.tags"
          use-input
          multiple
          option-value="id"
          option-label="name"
          hint="Pesquise entre 3 a 10 palavras-chave para melhorar as buscas, se não achar a palavra chave, escreva uma palavra e adicione apertando enter"
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
      </q-card-section>

      <q-card-section>

        <!-- LICENÇAS 
        <ParentAndChildSelect :parent="licencas" 
          label="Licença"
          :selectedId="conteudo.license_id"
          @click="setLicense"
        ></ParentAndChildSelect>
        <div> {{license_description ? license_description : '' }} </div>
        <div class="q-my-md" v-if="errors && errors.license_id && errors.license_id.length > 0">
          <ShowErrors :errors="errors.license_id"></ShowErrors>
        </div>
        -->

        <!-- DESCRIÇÃO -->
        <div class="q-mt-md">

          <p class="text-center">Escreva uma descrição </p>
          <small>
            <b>(Para melhorar a qualidade de nossa oferta e busca de conteúdos,
              escreva um texto como mínimo de 100 caracteres)</b>
          </small>

        </div>
        <q-editor
          v-model="conteudo.description"
          min-height="18rem"
          ref="editor_ref"
          @paste.native="evt => pasteCapture(evt)"
          :toolbar="[['bold', 'italic', 'strike', 'underline']]"
        />
        <ShowErrors
          v-if="errors && errors.description && errors.description.length > 0"
          :errors="errors.description"
        >
        </ShowErrors>
      </q-card-section>

      <q-card-section>
        <q-img
          loading="lazy"
          width="100%"
          height="200"
          :src="conteudo.image"
          placeholder-src="/img/fundo-padrao.svg"
          alt="imagem de destaque"
        />
        <!-- IMAGEM DE DESTAQUE -->
        <q-input
          @input="val => { file = val[0];}"
          outlined
          accept=".png,.jpeg,.jpg,.svg,.webp"
          @change="onImageFileChange"
          type="file"
          hint="IMAGEM de destaque"
          bottom-slots
          :error="errors && errors.imagem_associada && errors.imagem_associada.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.imagem_associada"></ShowErrors>
          </template>
        </q-input>
      </q-card-section>
      <!-- ARQUIVO DE DOWNLOAD -->
      <q-card-section>
        <DeleteFiles
          message="Download"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['download'] : null"
          directory="download"
        >
        </DeleteFiles>
        <DeleteFiles
          message="Visualização"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['visualizacao'] : null"
          directory="visualizacao"
        >
        </DeleteFiles>
        <q-input
          class="q-mt-md"
          @input="val => {file = val[0];}"
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
        <br>
        <DeleteFiles
          message="Guias Pedagógicos"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['guias-pedagogicos'] : null"
          directory="guias-pedagogicos"
        >
        </DeleteFiles>

        <q-input
          dense
          class="q-mt-md"
          @input="val => {file = val[0];}"
          @change="onguiaPedagogicoFileChange"
          type="file"
          hint="Arquivo para Guia Pedagógico"
          bottom-slots
          :error="errors && errors.guias_pedagogicos && errors.guias_pedagogicos.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.guias_pedagogicos"></ShowErrors>
          </template>
        </q-input>
        <!-- ENVIAR SITE -->
        <br>
        <q-input
          dense
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
          bottom-slots
          :error="errors && errors.options && errors.options.site && errors.options.site.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.options.site"></ShowErrors>
          </template>
        </q-input>

      </q-card-section>
      <q-card-section>
        <div class="q-gutter-sm">
          <!-- CONTEUDO APROVADO -->
          <q-checkbox
            v-model="conteudo.is_approved"
            label="Aprovar conteúdo"
            color="pink"
          />
          <div v-if="errors && errors.is_approved && errors.is_approved.length > 0">
            <ShowErrors :errors="errors.is_approved"></ShowErrors>
          </div>

          <!-- MARCAR COMO DESTAQUE -->
          <q-checkbox
            v-model="conteudo.is_featured"
            label="Marcar como destaque"
            color="pink"
          />
          <div v-if="errors && errors.is_featured && errors.is_featured.length > 0">
            <ShowErrors :errors="errors.is_featured"></ShowErrors>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <!-- TERMOS DE USO -->
        <div class="q-gutter-sm">
          Li e concordo com os <a href="#terms">termos e condições de uso</a> :
          <q-checkbox
            v-model="terms"
            color="pink"
          />
          <div v-if="errors && errors.terms && errors.terms.length > 0">
            <ShowErrors :errors="errors.terms"></ShowErrors>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <!-- SALVAR -->
        <q-btn
          class="full-width"
          color="primary"
          @click="save()"
          label="Salvar"
          :loading="loading"
        ></q-btn>
      </q-card-section>
    </q-card>
    <q-card
      class="col-sm-3"
      :class="{'error-card' : errors && errors.componentes && errors.componentes.length > 0 }"
    >
      <q-card-section v-if="errors && errors.componentes && errors.componentes.length > 0">
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      <q-card-section>
        <!-- COMPONENTES CURRICULARES -->
        <div v-if="componentes">
          <div class="text-center text-positive q-pt-md">
            <h6 class="text-primary "> <b>Componentes</b></h6>
          </div>
          <div
            v-for="component in componentes"
            :key="`c-${component.id}`"
          >

            <q-expansion-item
              dense
              header-class="bg-primary text-white shadow-2 glossy"
              :label="component.name"
            >

              <q-btn
                color="negative"
                text-color="white"
                label="Marcar todos"
                size="xs"
                style="margin-top:5px"
                @click="selectAll(component.id,'componente')"
              ></q-btn>
              <q-btn
                color="negative"
                text-color="white"
                label="Desmarcar todos"
                size="xs"
                style="margin-top:5px"
                @click="UnselectAll(component.id,'componente')"
              ></q-btn>

              <q-separator
                class="q-mt-lg"
                inset
                color="negative"
              ></q-separator>

              <q-list
                dense
                bordered
              >

                <q-item
                  dense
                  v-ripple
                  v-for="(component, i) in component.componentes"
                  :key="`child-com-${i}`"
                >
                  <q-item-section avatar>

                    <q-checkbox
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="negative"
                      :id="component.id"
                      ref="comp"
                    />

                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{component.name}}
                  </q-item-label>
                </q-item>
              </q-list>
            </q-expansion-item>
            <q-separator
              class="q-mt-lg"
              inset
              color="white"
            ></q-separator>
          </div>
        </div>
      </q-card-section>

      <q-card-section
        class="q-mt-lg"
        v-if="errors && errors.componentes && errors.componentes.length > 0"
      >
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>

    </q-card>
    <q-card
      class="col-sm-3"
      :class="{'error-card' : errors && errors.componentes && errors.componentes.length > 0 }"
    >
      <q-card-section
        class="q-mt-lg"
        v-if="errors && errors.componentes && errors.componentes.length > 0"
      >
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      <q-card-section>
        <!-- NIVEIS DE ENSINO -->
        <div v-if="niveis">

          <div class="text-center text-primary q-pt-md">
            <h6> <b>Níveis de Ensino</b></h6>
          </div>
          <div
            v-for="nivel in niveis"
            :key="`n-${nivel.id}`"
          >
            <q-expansion-item
              dense
              header-class="bg-primary text-white shadow-2 glossy"
              :label="nivel.name"
            >
              <q-btn
                color="negative"
                text-color="white"
                label="Marcar todos"
                size="xs"
                style="margin-top:5px"
                @click="selectAll(nivel.id ,'nivel')"
              ></q-btn>
              <q-btn
                color="negative"
                text-color="white"
                label="Desmarcar todos"
                size="xs"
                style="margin-top:5px"
                @click="UnselectAll(nivel.id,'nivel')"
              ></q-btn>
              <q-separator
                class="q-mt-lg"
                inset
                color="positive"
              ></q-separator>

              <q-list
                dense
                bordered
              >
                <q-item
                  v-for="(component, i) in nivel.componentes"
                  :key="`child-com-${i}`"
                  v-ripple
                >
                  <q-item-section avatar>
                    <q-checkbox
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="teal"
                    />
                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{component.name}}
                  </q-item-label>
                </q-item>
              </q-list>
            </q-expansion-item>
            <q-separator
              class="q-mt-lg"
              inset
              color="white"
            ></q-separator>
          </div>
        </div>
      </q-card-section>

      <q-card-section
        class="q-mt-lg"
        v-if="errors && errors.componentes && errors.componentes.length > 0"
      >
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
// @ts-nocheck

import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { ShowErrors, ParentAndChildSelect } from "@forms/shared";
import { PasteCapture } from "@mixins/RemoveFormat";
import {
  QInput,
  QEditor,
  QCard,
  QCardSection,
  QSelect,
  QStepper,
  QStep,
  QStepperNavigation,
  QDialog,
  ClosePopup,
  QCheckbox,
  QSeparator,
  QBtn,
  QList,
  QItem,
  QItemSection,
  QItemLabel,
} from "quasar";
import DeleteFiles from "./DeleteFiles";
import { useQuasar } from "quasar";

export default {
  setup() {
    const $q = useQuasar();
  },
  name: "ConteudoForm",
  mixins: [PasteCapture],
  directives: {
    ClosePopup,
  },
  components: {
    DeleteFiles,
    QInput,
    QItemSection,
    QCheckbox,
    QBtn,
    QList,
    QItem,
    QItemLabel,
    QSeparator,
    QEditor,
    QCard,
    QSelect,
    QCardSection,
    QStepper,
    QStep,
    QStepperNavigation,
    ShowErrors,
    QDialog,
    ParentAndChildSelect,
  },
  data() {
    return {
      current: 0,
      last: 0,
      selected: [],
      allSelected: false,
      alert: false,
      titulo_existente: false,
      step: 1,

      multiple: null,
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
        category: "",
        authors: "",
        source: "",
        image: "",
        tags: [],
        componentes: [],
        is_approved: false,
        is_featured: false,
        is_site: false,
      },
      categoriesList: [],
      canais: [],
      terms: false,
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
      results: [],
      errors: {},
      dialog: {
        text: "",
        open: false,
        confirm: false,
        new_tag: "",
      },
    };
  },
  mounted() {
    this.getData();
  },
  computed: {
    //
  },
  methods: {
    async verificar_existencia() {
      if (this.conteudo.title == "") {
        alert("Digite Algum título para ser pesquisado");
        return;
      }
      this.$q.loading.show();
      let search = new URLSearchParams(location.search);
      search.set("limit", "999");
      search.set("per", "titulo");
      search.set("busca", this.conteudo.title);

      const { data } = await axios.get(`/conteudos?${search.toString()}`);
      this.$q.loading.hide();

      if (data.paginator.total == 0) {
        alert("Não foi Encontrado nenhum conteúdo com esse título");
      } else {
        this.titulo_existente = true;

        this.results = data.paginator.data;
      }
    },

    selectAll: function (IdComponente, tipo) {
      if (tipo == "componente") {
        axios.get(`/componentescategorias/${IdComponente}`).then((resp) => {
          let dados = resp.data.componentes;

          for (var i = 0; i < dados.length; i++) {
            this.componentesCurriculares.push(dados[i].id);
          }
        });

        // let teste = this.getComponentesIds(IdComponente);

        // alert(IdComponente);
        //this.componentesCurriculares = [84, 85, 86, 87];
        //console.log(this.componentesCurriculares);
        //let items = this.componentesCurriculares;
        //let valuesToRemove = [84, 85];

        //  let filteredItems = items.filter(
        //    (items) => !valuesToRemove.includes(items)
        //  );

        //  this.componentesCurriculares = filteredItems;
        //console.log(filteredItems);
        // this.componentesCurriculares.splice(84, 1);
        //this.componentesCurriculares.splice(84);
        // this.$delete(this.componentesCurriculares, index);
        //console.log(this.componentesCurriculares.map);

        //this.componentesCurriculares.val = this.$refs.comp[0];

        // this.$refs.comp[0].isTrue = true;

        //checkAllCheckbox.setChecked();
        //this.componentesCurriculares[84] = true;

        //if (this.componentesCurriculares.id === 84) {
        //  this.componentesCurriculares = true;
        // return;
        // }

        // this.componentesCurriculares = true;
      }

      if (tipo == "nivel") {
        axios.get(`/niveis-ensino/${IdComponente}`).then((resp) => {
          let dados = resp.data.componentes;

          for (var i = 0; i < dados.length; i++) {
            this.componentesCurriculares.push(dados[i].id);
          }
        });
      }
    },
    UnselectAll: function (IdComponente, tipo) {
      if (tipo == "componente") {
        axios.get(`/componentescategorias/${IdComponente}`).then((resp) => {
          let dados = resp.data.componentes;

          for (var i = 0; i < dados.length; i++) {
            let items = this.componentesCurriculares;
            let valuesToRemove = [dados[i].id];

            let filteredItems = items.filter(
              (items) => !valuesToRemove.includes(items)
            );

            this.componentesCurriculares = filteredItems;
          }
        });
      }

      if (tipo == "nivel") {
        axios.get(`/niveis-ensino/${IdComponente}`).then((resp) => {
          let dados = resp.data.componentes;

          for (var i = 0; i < dados.length; i++) {
            let items = this.componentesCurriculares;
            let valuesToRemove = [dados[i].id];

            let filteredItems = items.filter(
              (items) => !valuesToRemove.includes(items)
            );

            this.componentesCurriculares = filteredItems;
          }
        });
      }
    },

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

    hasChild(scope) {
      return scope.opt.sub_categories.some(
        (c) => c.id === this.conteudo.category_id
      );
      //scope.opt.children.some(c => c.name === this.model)
    },

    async getCategories(val) {
      if (!val) return;
      const id = val.hasOwnProperty("id") ? val.id : val;
      this.$q.loading.show();
      try {
        const { data } = await axios.get(`/categorias/canal/${id}`);

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
        const category = this.conteudo.category;
        this.selectedCategory = category.name;
      }
    },
    setCategory(cat) {
      console.log(cat);
      this.conteudo.category_id = cat.id;
      return cat;
    },
    getOptionLabel(ev) {
      console.log(ev, "sds");
    },
    setLicense(id) {
      this.conteudo.license_id = id;
      axios.get(`/licencas/${id}`).then((resp) => {
        this.license_description = resp.data.metadata.description;
      });
    },
    setCanal(id) {
      this.conteudo.canal_id = id;
      this.getCategories({ id });
    },
    setTipo(id) {
      this.conteudo.tipo_id = id;
    },
    addTag(val, done) {
      //const form = new FormData();
      //const http = axios;
      console.log(val);
      //console.log(val, this.autocompleteTags)

      this.showTagModal(val);
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
    lengths() {},
  },
};
</script>
<style lang="stylus" scoped>
.error-card {
  border: solid 2px #a54a54;
}
</style>
