<template>
  <q-dialog ref="PLForm">
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section>
        <h6 class="text-h6 text-center">Criar Playlist</h6>

        <q-input
          outlined
          v-model.trim="title"
          label="Título da lista de reprodução"
          bottom-slots
          :error="errors && errors.title && errors.title.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.title"></ShowErrors>
          </template>
        </q-input>
        <q-input
          outlined
          v-model="description"
          label="Escreva uma descrição"
          clearable
          type="textarea"
          bottom-slots
          :error="errors && errors.description && errors.description.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.description"></ShowErrors>
          </template>
        </q-input>
      </q-card-section>
      <q-card-actions>
        <q-btn
          @click="createPlayList"
          color="primary"
          label="Adicionar PlayList"
        ></q-btn>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ShowErrors } from "@/forms/shared";
export default {
  name: "PlayListModalForm",
  components: { ShowErrors },
  data() {
    return {
      title: "",
      description: "",
      errors: [],
    };
  },
  methods: {
    async createPlayList() {
      console.log(this.title, this.description);
      const form = new FormData();
      form.append(
        "document",
        JSON.stringify({
          title: this.title,
          description: this.description,
        })
      );
      try {
        const { data } = await axios.post("/playlist", form);
        if (data.success) {
          this.hide();
        }
      } catch (res) {
        this.errors = res.errors;
      }
    },
    show() {
      this.$refs.PLForm.show();
    },
    hide() {
      this.$refs.PLForm.hide();
    },
  },
};
</script>

<style></style>
