<template>
  <div class="q-pa-md">

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="footer_logo">
          <a href="http://educadores.educacao.ba.gov.br/">
            <img
              src="/img/educacao_logo_educadores.png"
              alt=""
            >
          </a>
        </div>
        <section
          id="custom_html-2"
          class="widget_text widget widget_custom_html"
        >
          <div class="textwidget custom-html-widget">

            SECRETARIA DA EDUCAÇÃO DO ESTADO DA BAHIA<br><br>
            5ª Avenida Nº 550, Centro Administrativo da Bahia - CAB, Salvador, Bahia, Brasil, CEP: 41.745-004
            <br><br>
            <b>+55 (0xx71) 3115-8933</b><br>
            <b>+55 (0xx71) 3115-9093</b><br>
            <b>+55 (0xx71) 3115-1401</b>

          </div>
        </section>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <section
          id="custom_html-4"
          class="widget_text widget widget_custom_html"
        >
          <h4 class="widget_title no_stripe">Compartilhe</h4>
          <div class="textwidget custom-html-widget">
            <vue-goodshare
              class="row items-left"
              style="margin: auto 10px;"
            ></vue-goodshare>
          </div>

        </section>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <section
          id="custom_html-3"
          class="widget_text widget widget_custom_html"
        >
          <h4 class="widget_title no_stripe">Siga nossas Redes Sociais</h4>
          <div class="textwidget custom-html-widget">

            <div
              class="fb-page fb_iframe_widget"
              data-href="https://www.facebook.com/InstitutoAnisioTeixeira.IAT/"
              data-width=""
              data-height=""
              data-small-header="false"
              data-adapt-container-width="true"
              data-hide-cover="false"
              data-show-facepile="true"
              fb-xfbml-state="rendered"
              fb-iframe-plugin-query="adapt_container_width=true&amp;app_id=&amp;container_width=255&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FInstitutoAnisioTeixeira.IAT%2F&amp;locale=pt_BR&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false&amp;width="
            ><span style="vertical-align: bottom; width: 255px; height: 130px;"><iframe
                  name="f3c0ee75676b304"
                  width="1000px"
                  height="1000px"
                  data-testid="fb:page Facebook Social Plugin"
                  title="fb:page Facebook Social Plugin"
                  frameborder="0"
                  allowtransparency="true"
                  allowfullscreen="true"
                  scrolling="no"
                  allow="encrypted-media"
                  src="https://www.facebook.com/v7.0/plugins/page.php?adapt_container_width=true&amp;app_id=&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df5f9e7ec2e27%26domain%3DInstitutoAnisioTeixeira.IAT%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252FInstitutoAnisioTeixeira.IAT%252Ff133923bddf5a3c%26relation%3Dparent.parent&amp;container_width=255&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FInstitutoAnisioTeixeira.IAT%2F&amp;locale=pt_BR&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false&amp;width="
                  style="border: none; visibility: visible; width: 255px; height: 130px;"
                  class=""
                ></iframe></span>
              <div class="icones_rede_sociais">
                <a
                  href="https://web.facebook.com/InstitutoAnisioTeixeira.IAT/"
                  target="_blank"
                > <img
                    src="/img/icone_facebook.png"
                    style="width: 36px;height: 36px;margin: auto 10px;"
                    title="Instagram Educação Bahia"
                  >
                </a>
                <a
                  href="https://www.instagram.com/educacaobahia/"
                  target="_blank"
                > <img
                    src="/img/icone_instagram.png"
                    style="width: 36px;height: 36px;"
                    title="Facebook Instituto Anisio Teixeira"
                  >
                </a>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <section
          id="mc4wp_form_widget-2"
          class="widget widget_mc4wp_form_widget"
        >
          <h4 class="widget_title no_stripe">Newsletter</h4>

          <div class="newsletter-container c-5 fr">
            <h3 class="newsletter-headline">FAÇA PARTE DA FAMÍLIA</h3>

            <p class="intro-newsletter">Inscreva-se em nossa newsletter e fique por dentro das novidades!</p>
            <div class="form-group clear">
              <div class="c-8 pr">
                <q-form
                  v-on:submit="onSubmit()"
                  class="q-gutter-md"
                  ref="NewsletterForm"
                  style="margin-top: 15px"
                >

                  <q-input
                    bottom-slots
                    v-model="email"
                    label="Digite o Seu email"
                    rounded
                    standout
                    color="primary"
                    bg-color="light"
                    type="email"
                    :error="errors.email && errors.email.length > 0"
                  >
                    <template v-slot:error>
                      <ShowErrors :errors="errors.email"></ShowErrors>
                    </template>

                  </q-input>

                  <q-btn
                    color="negative"
                    icon-right="send"
                    class="q-mt-lg"
                    label="Enviar"
                    type="submit"
                  />
                </q-form>
              </div>

            </div>

          </div>

        </section>
      </div>

    </div>

  </div>

</template>
<script>
import { ShowErrors } from "@forms/shared";
import { mapState } from "vuex";
import VueGoodshare from "vue-goodshare";
import {
  QCard,
  QCardSection,
  QBtn,
  QList,
  QAvatar,
  QItem,
  QItemSection,
  QItemLabel,
  QSeparator,
  QImg,
  QToolbar,
  QForm,
  QInput,
} from "quasar";

export default {
  name: "Footer",
  components: {
    ShowErrors,
    QImg,
    QCard,
    QCardSection,
    QBtn,
    QList,
    QAvatar,
    QItem,
    QItemSection,
    QItemLabel,
    QSeparator,
    QToolbar,
    VueGoodshare,

    QForm,
    QInput,
  },
  data() {
    return {
      errors: {},
      email: "",
    };
  },
  computed: {
    ...mapState(["Footer"]),
  },

  methods: {
    async onSubmit() {
      this.$q.loading.show();

      let data = {
        email: this.email,
      };

      try {
        let resp = await axios.post("/newsletter", data);
        this.$q.loading.hide();
        this.errors = {};

        //this.$router.push("/");
      } catch (response) {
        this.errors = response.errors;
      }
    },
  },
};
</script>
