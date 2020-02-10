<template>
    <div>
        <p>Código de segurança:</p>
        <vue-recaptcha :id="r_id" :sitekey="siteKey" :loadRecaptchaScript="true" />
        <div bottom-slots
            :error="errors.recaptcha && errors.recaptcha > 0">
                <ShowErrors :errors="errors.recaptcha"></ShowErrors>
        </div>
    </div>
</template>

<script>
import ShowErrors from "../components/ShowErrors.vue";
import VueRecaptcha from "vue-recaptcha";
export default {
  name: "Recaptcha",
  components: { VueRecaptcha, ShowErrors },
  data() {
    return {
      siteKey: "6LczPtQUAAAAAOcgJ9NP9GXPJmA98rppQbsmzuX5",
      r_id: 0,
      gResponse: ""
    };
  },
  mounted() {
    if (window.grecaptcha) {
      let container = document.getElementsByClassName("g-recaptcha")[0];
      if (typeof grecaptcha.render === "function") {
        this.r_id = grecaptcha.render(container, {
          sitekey: this.siteKey
        });
      }
    }
  },
  destroyed() {
    window.grecaptcha.reset();
  }
};
</script>