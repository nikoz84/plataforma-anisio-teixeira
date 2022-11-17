<template>
  <section>
    <div class="text-h5 title-page text-primary separatriz q-pb-md">
      Práticas Inspiradoras
    </div>
    <div class="separatriz-6"></div>
    <div class="row justify-center q-py-lg q-gutter-lg">
      Assista a lista de reprodução
      <q-btn :to="{ path: '/praticas-inspiradoras' }">
        Visitar
      </q-btn>
    </div>
  </section>
</template>

<script>
export default {
  name: "PlayListHome",
};
</script>
