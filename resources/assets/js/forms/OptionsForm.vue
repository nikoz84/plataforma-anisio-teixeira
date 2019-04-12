<template>
    <div>
        {{name}} {{options}}
    </div>
</template>
<script>
export default {
  name: "OptionsForm",
  data() {
    return {
      name: "",
      options: []
    };
  },
  mounted() {
    this.getOptions();
  },
  methods: {
    async getOptions() {
      let resp = await axios.get("/api-v1/options", { name: this.name });

      console.warn(resp.data);
      this.options = resp.data.options;
    }
  }
};
</script>