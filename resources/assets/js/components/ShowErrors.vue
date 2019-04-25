<template>
    <div v-if="errors">
        <ul class="list-unstyled">
            <li v-for="(error,i) in errors" :key="i">
                <small class="text-danger" v-text="error"></small>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
  name: "ShowErrors",
  computed: {
    errors() {
      return this.$store.state.erros;
    }
  }
};
</script>
