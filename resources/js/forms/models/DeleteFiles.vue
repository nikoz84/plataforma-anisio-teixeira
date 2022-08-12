<template>
  <div v-if="file">
    Baixar arquivo {{ message }}:
    <a :href="file.url" :download="file.url">
      {{ file.name }}
    </a>
    -
    <a
      class="text-negative"
      :href="file.url"
      @click.prevent="deleteFile(directory, file.name)"
    >
      APAGAR ARQUIVO
    </a>
  </div>
</template>

<script>
export default {
  name: "DeleteFiles",
  props: ["message", "file", "directory"],

  data() {
    return {
      show: false,
    };
  },

  methods: {
    async deleteFile(directory, filename) {
      if (directory && filename) {
        const { data } = await axios.post("/files", {
          directory,
          filename,
          _method: "DELETE",
        });
        this.file = null;
      }
    },
  },
};
</script>

<style></style>
