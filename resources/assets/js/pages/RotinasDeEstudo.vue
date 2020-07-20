<template>
  <div class="q-pa-md">
    <q-card v-if="rotinas">
      <!-- LISTA DE ITENS -->
      <div class="q-pa-sm">
        
        <div class="flex" v-for="(rotina, i) in rotinas" :key="i">
          <q-card class="col-3" v-for="(atividade, d) in rotina" :key="d">
            <q-card-section>
              {{ getDay(d) }}
            </q-card-section>
            <q-card-section >
              
              {{ toJson(atividade).sugestao }}
              {{ toJson(atividade).descricao }}
            </q-card-section>
          </q-card>
        </div>
        
      </div>
    </q-card>
  </div>
</template>

<script>
export default {
    name: "RotinasDeEstudo",
    data() {
      return {
        rotinas: [],
        paginator: {},
        current: 0,
        last: 0,
        total: 0
      }
    },
    created() {
      this.getRotinas();
    },
    methods: {
      async getRotinas(){
        const { data } = await axios.get('/rotinas/ensino-medio/semana-2');
        
        this.rotinas = data.metadata

        /*
        this.paginator = data.paginator
        this.total = data.paginator.total 
        this.current = data.paginator.current_page
        this.last = data.paginator.last_page
    */
        
        console.log(data)
        
      },
      toJson(data){
        return JSON.parse(data);
      },
      getDay(day){
        switch (day) {
          case 'segunda':
              return 'Segunda Feira';
            break;
          case 'terca':
              return 'Terça Feira';
            break;
          case 'quarta':
              return 'Quarta Feira';
            break;
          case 'quinta':
              return 'Quinta Feira';
            break;
          case 'sexta':
              return 'Sexta Feira';
            break;
          default:
            return '';
            break;
        }
      }
    },
}
</script>

<style>

</style>