<template>
  <div class="q-pa-md">
    <q-banner class="bg-primary text-white">
      <header class="row wrap items-center q-my-md">
        <div class="text-h5 color-primary">
          Rotinas de Estudo do {{ this.nivel.label }}
        </div>
      </header>
    </q-banner>
    <q-banner dense class="bg-grey-3">
      <div class="row justify-left q-gutter-md">
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
    </q-banner>
    <div class="row justify-start q-gutter-md">
      <q-badge removable outline class="q-mt-lg q-mb-sm" color="primary" label="Dica: Interaja com cards coloridos para acessar o conteúdo sugerido" />
    </div>
    <div v-if="rotinas && !mobile">
      <div class="row justify-start q-gutter-md" v-for="(rotina, i) in rotinas" :key="i">
        <div class="col-sm-2" v-for="(atividade, d) in rotina" :key="`at-${d}`">
          <q-chip class="q-ml-none" square outline color="grey-7" icon="event" v-if="i == 0">
            <i>{{ getDay(d) }}</i>
          </q-chip>
          <q-btn no-caps align="left" type="a" target="__blank" 
            :href="goTo(toJson(atividade).link)" 
            :class="coresClasses[i]">
            <div class="text-left">  
              {{ toJson(atividade).descricao }}
              <q-space class="q-mt-md"></q-space>
              Sugestão: {{ toJson(atividade).sugestao }} 
            </div>
          </q-btn>
        </div>
      </div>
    </div>
    <div v-if="rotinas && mobile">
      <div class="row justify-start q-gutter-md">
        <div class="col-sm-12 col-lg-2 col-md-2" v-for="(dia, d) in diasSemana" :key="d" >
            <q-chip class="q-ml-none" square outline color="grey-7" icon="event" >
              <i>{{ dia }}</i>
            </q-chip>


              <div class="col-sm-2" v-for="(atividade, j) in rotinas" :key="j" >
                <q-btn no-caps align="left" type="a" target="__blank" 
                  :href="goTo(toJson(atividade[dia]).link)" 
                  :class="coresClasses[d]">
                  <div class="text-left">  
                    {{ toJson(atividade[dia]).descricao }}
                      <q-space class="q-mt-md"></q-space>
                      Sugestão {{ toJson(atividade[dia]).sugestao }}
                  </div>
                </q-btn>
                <q-space class="q-mt-md"></q-space> 
              </div>
            
        </div>
      </div>
    </div>
  </div>
</template>

<script>// @ts-nocheck

export default {
    name: "RotinasDeEstudo",
    data() {
      return {
        rotinas: [],
        diasSemana:['segunda', 'terca', 'quarta', 'quinta','sexta'],
        coresClasses:['bg-amarelo text-left q-py-md q-mb-md', 'bg-rosa text-left q-py-md q-mb-md', 'bg-turquesa', 'bg-verde text-left q-py-md q-mb-md', 'bg-lilas text-left q-py-md q-mb-md'],
        mobile:window.innerWidth <= 700,
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
      addEventListener('resize', () => {
        this.mobile = innerWidth <= 700
       });

      if (this.$route.params.nivel){
        this.nivel = this.niveisModel.filter((item)=>{
          return item.value === this.$route.params.nivel
        }).reduce(obj => obj);
      }
      this.getRotinas();
    },
    methods: {
      async getRotinas(){
        this.$q.loading.show();
        let nivel = this.nivel.value ? this.nivel.value : 'ensino-fundamental-1';
        let semana = this.semana.value ? this.semana.value : 'semana-1';
        const { data } = await axios.get(`/rotinas/${nivel}/${semana}`);
        this.$q.loading.hide();
        this.rotinas = data.metadata.rotinas;
        this.semanasModel = data.metadata.semanas;
        
        
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
      },
      goTo(url) {
        if(!url){
          return false;
        }
        const host = window.location.host;
        const protocol = window.location.protocol;
        const parser = document.createElement('a');
        parser.href = url;
        
        if(parser.host === 'pat.educacao.ba.gov.br'){
          const pathname = parser.pathname;
          const slugCanal = pathname.split('/')[1];
          const idConteudo = pathname.substr(pathname.lastIndexOf('/') + 1);
          
          return this.renameCanal(slugCanal, idConteudo);
        }
        return url.trim();
      },
      renameCanal(slug, id){
        switch (slug) {
          case 'conteudos-digitais':
            return `/recursos-educacionais/conteudo/exibir/${id}`;
            break;
          default:
            return `/${slug}/conteudo/exibir/${id}`;
            break;
        }
      }
    }
}
</script>

<style lang="stylus" scoped>

.bg-amarelo{
  background-color : #ffecb3!important; /* amber 2 na pallete do quasar */
}

.bg-rosa{
  background-color : #f8bbd0!important; /* pink 2 */
}

.bg-turquesa{
  background-color : #b2ebf2!important; /* cyan 2 */
}

.bg-verde{
  background-color : #dcedc8!important; /* light-green 2 */
}

.bg-lilas{
  background-color : #e1bee7!important; /* purple 2 */
}

</style>