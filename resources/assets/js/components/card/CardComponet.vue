<template>
    <div class="q-pa-md row items-start q-gutter-md">
        <q-card class="my-card">
            <q-card-section>
                {{ title }} {{ percent }} {{ day }}
                <q-card-section horizontal>
                    <q-card-section>
                        {{ conteudo }}
                    </q-card-section>
                    {{ icon }}
                </q-card-section>
            </q-card-section>
        </q-card>
    </div>
</template>

<script>
export default {
    name: 'CardComponent',
    props: [
        'title',
        'percent',
        'day',
        'conteudo',
        'icon'

    ]
}
</script>
