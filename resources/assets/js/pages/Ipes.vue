<template>
  <div class="q-pa-md">
      <div class="q-mt-lg" v-for="(item, i) in items" :key="i" :id="item.document.slug">
            <div class="text-h5 title-page text-primary separatriz q-pb-md" 
                v-text="item.document.faculdade">
            </div>
            <div class="separatriz-6"></div>
            <div class="q-gutter-sm">
                <q-card v-for="(action, a) in item.document.actions" :key="a">
                    <q-card-section>
                        <strong>Ação:</strong> {{ action.name }} <q-space></q-space>
                        <strong>descrição:</strong> {{ action.description }}
                    </q-card-section>
                    <q-card-actions>
                        <q-btn>
                            SAIBA MAIS
                        </q-btn>
                    </q-card-actions>
                </q-card>
            </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "Ipes",
    data(){
        return { 
            items: []
        }
    },
    created() {
        this.getIpes();
    },
    methods: {
        async getIpes(){
            const { data } = await axios.get('/planilhas?slug=ipes');
            
            this.items = data.paginator.data;
        }
    },
}
</script>

<style>

</style>