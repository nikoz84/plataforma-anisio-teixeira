<template>
    <q-input @change="onChange($event)"
            filled
            type="file"
            :hint="hint"
            bottom-slots
            :error="errors && errors.file && errors.file.length > 0"
        >
      <template v-slot:error>
              <ShowErrors :errors="errors.file"></ShowErrors>
      </template>
    </q-input>
</template>
<script>
import { ShowErrors } from "@forms/shared";

export default {
  name: "FileUpload",
  components: { ShowErrors },
  props: ["file", "hint", "errors"],
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
      console.log(e.target.files);
      this.fileChange = e.target.files[0];
    }
  }
};
</script>
