<template>
    <q-input @change="onChange($event)"
            filled
            type="file"
            :hint="hint"
        />
</template>
<script>
export default {
  name: "FileUpload",
  props: ["file", "hint"],
  computed: {
    fileChange: {
      get() {
        return this.file;
      },
      set(val) {
        this.$emit("update:file", val);
      }
    }
  },
  methods: {
    onChange(e) {
      console.log(e);
      this.fileChange = e.target.files[0];
    }
  }
};
</script>
