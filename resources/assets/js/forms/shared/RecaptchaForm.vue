<template>
  <div ref="recaptchaForm">
    <p>Código de segurança:</p>
    <vue-recaptcha :id="r_id" :sitekey="siteKey" :loadRecaptchaScript="loadRecaptcha" />
    <div bottom-slots
        :error="errors && errors.length > 0">
            <ShowErrors :errors="errors"></ShowErrors>
    </div>
  </div>
</template>

<script>
import { ShowErrors } from "@forms/shared";
import VueRecaptcha from "vue-recaptcha";
import { mapGetters, mapMutations } from 'vuex';

export default {
  name: "Recaptcha",
  components: { VueRecaptcha, ShowErrors },
  props: ['errors'],
  data() {
    return {
      siteKey: process.env.MIX_RECAPTCHA_SITE_KEY,
      r_id: 'recaptcha_id',
      gResponse: "",
      loadRecaptcha: true
    };
  },
  mounted() {
    if (window.grecaptcha) {
      
      let container = document.getElementById(this.r_id);
      if (typeof grecaptcha.render === "function" && container.length) {
        this.r_id = grecaptcha.render(container, {
          sitekey: this.siteKey
        });
      }
    }
  },
  destroyed() {
    //window.grecaptcha.reset();
  }
};
</script>