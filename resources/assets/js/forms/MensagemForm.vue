<template>
    <div>
        <ul class="list-unstyled" v-if="errors">
          <li class="text-danger"
                  v-for="(error,i) in errors"
                  v-bind:key="i"
                  v-text="error">
          </li>
        </ul>
    </div>
</template>
<script>
export default {
  name: "mensagem",
  props: ["errors"]
};
</script>
<style lang="scss">
</style>
