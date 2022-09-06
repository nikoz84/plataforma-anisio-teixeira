<template>
    <div class="q-pa-md row items-start q-gutter-md">
        <q-card class="my-card text-white" style="background: radial-gradient(circle, #35a2ff 0%, #014a88 100%)">
            <q-card-section>
                <div class=" text-h6">
                    {{ data.titulo }}
                </div>
                <q-card-section horizontal>
                    <q-card-section>
                        Quantidade: {{ data.quantidade }}
                    </q-card-section>
                </q-card-section>
            </q-card-section>
            <q-card-section>
                <q-btn label="Ver mais" @click="goto(id)"></q-btn>
            </q-card-section>
        </q-card>
    </div>
</template>

<script>
export default {
    name: 'CardDashboard',
    props: [
        'id',
        'data'
    ],
    methods: {
        goto (ID) {
            this.$router.push('/admin/dashboard/listar/' + ID)
        }
    }

}
</script>
<style scoped>
.my-card {
    width: 100%;
    max-width: 250px;
    border-radius: 15px
}
</style>
