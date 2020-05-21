<template>
    <div class="q-pa-md" style="max-width: 400px">
        <form v-on:submit.prevent="send()">
            <!-- NOME -->
            <q-input filled v-model="name" label="Nome da função do usuário" />
            <q-btn label="Salvar" type="submit" color="primary"/>
        </form>
    </div>
</template>
<script>
import { QInput } from 'quasar';

export default {
  name: "RoleForm",
  components: { QInput },
  data(){
      return {
          name: ''
      }
  },
  methods:{
      send(){
          console.log("hola")
      }
  }
};
</script>