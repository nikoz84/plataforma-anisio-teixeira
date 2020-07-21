<template>
  <div class="q-pa-md">
    <div class="row justify-center q-gutter-md">
      <q-select
        v-model="option"
        :options="options"
        style="min-width: 250px"
      ></q-select>
      <q-select
        v-model="semana"
        :options="semanas"
        style="min-width: 200px"
      ></q-select>
    </div>
    <div v-if="rotinas">
      <div class="row justify-center q-mt-md q-gutter-md" v-for="(rotina, i) in rotinas" :key="i">
        <div class="col-sm-2" v-for="(atividade, d) in rotina" :key="d">
          <b class="text-center" v-if="i == 0">
            {{ getDay(d) }}
          </b>
          <q-card v-if="d == 'segunda'">
            <q-card-section >
              {{ toJson(atividade).sugestao }} 
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).descricao }}
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'terca'">
            <q-card-section >
              {{ toJson(atividade).sugestao }} 
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).descricao }}
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'quarta'">
            <q-card-section >
              {{ toJson(atividade).sugestao }} 
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).descricao }}
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'quinta'">
            <q-card-section >
              {{ toJson(atividade).sugestao }} 
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).descricao }}
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'sexta'">
            <q-card-section >
              {{ toJson(atividade).sugestao }} 
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).descricao }}
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "RotinasDeEstudo",
    data() {
      return {
        rotinas: [],
        semanas: [],
        semana: {
          value : 'semana-1',
          label : 'Semana 1'
        },
        option: {
          value: 'ensino-fundamental-1',
          label: 'Ensino Fundamental 1',
        },
        options:[
          {
            value: 'ensino-fundamental-1',
            label: 'Ensino Fundamental 1'
          },
          {
            value: 'ensino-fundamental-2',
            label: 'Ensino Fundamental 2'
          },
          {
            value: 'ensino-medio',
            label: 'Ensino Médio'
          }
        ]
      }
    },
    created() {
      this.getRotinas();
    },
    methods: {
      async getRotinas(){
        let nivel = this.$route.params.nivel;
        let semana = this.$route.params.semana;

        const { data } = await axios.get(`/rotinas/${nivel}/${semana}`);
        
        this.rotinas = data.metadata.rotinas;
        this.semanas = data.metadata.semanas;
        console.log(data.metadata)
        
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
            break;
        }
      }
    },
}
</script>

<style>

</style>