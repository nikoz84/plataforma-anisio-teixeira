<template>
  <div class="q-pa-md">
    <header class="row wrap items-center q-my-md">
      <div class="text-h5 color-primary">
        Rotinas de Estudo - {{ this.nivel.label }}
      </div>
    </header>
    <div class="row justify-center q-gutter-md">
      <q-select
        v-model="nivel"
        :options="niveisModel"
        style="min-width: 250px"
        @input="changeNivel" 
      ></q-select>
      <q-select
        v-model="semana"
        :options="semanasModel"
        @input="changeSemana"
        style="min-width: 200px"
      ></q-select>
    </div>
    <div v-if="rotinas">
      <div class="row justify-start q-mt-md q-gutter-md" v-for="(rotina, i) in rotinas" :key="i">
        <div class="col-sm-2" v-for="(atividade, d) in rotina" :key="d">
          <b class="text-center" v-if="i == 0">
            {{ getDay(d) }}
          </b>
          <q-card :class="{'segunda' : d == 'segunda'}" v-if="d == 'segunda'">
            <q-card-section >
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).sugestao }} 
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'terca'">
            <q-card-section >
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).sugestao }} 
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'quarta'">
            <q-card-section >
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).sugestao }} 
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'quinta'">
            <q-card-section >
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).sugestao }} 
            </q-card-section>
            <q-card-actions>
              <a target="_blank" :href="toJson(atividade).link">
                Visitar
              </a>
            </q-card-actions>
          </q-card>
          <q-card v-if="d == 'sexta'">
            <q-card-section >
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              {{ toJson(atividade).sugestao }} 
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
        semanasModel: [],
        semana: {
          value : 'semana-1',
          label : 'Semana 1'
        },
        nivel: {
          value: 'ensino-fundamental-1',
          label: 'Ensino Fundamental 1',
        },
        niveisModel:[
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
      if (this.$route.params.nivel){
        this.nivel = this.niveisModel.filter((item)=>{
          return item.value === this.$route.params.nivel
        }).reduce(obj => obj);
      }
      this.getRotinas();
    },
    methods: {
      async getRotinas(){
        let nivel = this.nivel.value ? this.nivel.value : 'ensino-fundamental-1';
        let semana = this.semana.value ? this.semana.value : 'semana-1';
        const { data } = await axios.get(`/rotinas/${nivel}/${semana}`);
        
        this.rotinas = data.metadata.rotinas;
        this.semanasModel = data.metadata.semanas;
        console.log(data.metadata)
        
      },
      changeSemana(value){
        this.semana = value;
        this.getRotinas();
      },
      changeNivel(value){
        this.nivel = value;
        this.getRotinas();
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