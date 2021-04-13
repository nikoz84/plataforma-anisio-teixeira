<template>
  <div class="col-md-8 col-sm-12" >
      <q-card>
        <q-card-section class="descritivo q-mx-md q-mb-sm" v-if="logartisan">
              <h3 title="LogLaravel">LogLaravel #{{logartisan.id}} : {{logartisan.dateTime}}</h3>
              <h4>Mensagem</h4>
              <div class="q-mt-md" v-html="logartisan.message"></div> 
              <h4>StackTrace</h4>
              <div class="q-mt-md" v-html="logartisan.stackError"></div> 
        </q-card-section>
      </q-card>
  </div>
</template>

<script>// @ts-nocheck

import { QCard, QCardSection } from "quasar";
export default {
      name: "LogArtisanForm",
      components: 
      {
        QCard,
        QCardSection
      },
      data() 
      {
        return {
          logartisan:{}
        }
      },
      created() {
        
        this.getLogArtisan();
        
      },
      methods: {
        async getLogArtisan()
        {
          this.$q.loading.show();
          if (!this.$route.params.id) return;
          let resp = await axios.get(`/logartisan/${this.$route.params.id}`);
          console.log("logartisan", resp);
          if (resp.data.success) {
            this.logartisan = resp.data.metadata;
          }
          this.$q.loading.hide();
        }
      }
}
</script>

<style>

</style>