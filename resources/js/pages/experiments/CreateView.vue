<template>
  <v-card class="rounded-t-xl">
    <v-card-title>
      <header-component
        :back-button="true"
        :title="title"
      >
        <v-btn icon>
          <v-icon>mdi-content-save</v-icon>
        </v-btn>
      </header-component>
    </v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
      >
        <div class="ma-auto w-50">
          <v-text-field
            v-model="formState.name"
            label="Name"
            prepend-icon="mdi-rename-outline"
            required
            :rules="nameRules"
            variant="outlined"
          />
          <v-file-input
            v-model="formState.file"
            accept=".zcos"
            chips
            label="Experiment file"
            required
            :rules="fileRules"
            variant="outlined"
          />
          <v-textarea
            v-model="formState.output"
            label="Output object"
            prepend-icon="mdi-code-json"
            :rules="outputRules"
            variant="outlined"
          />
          <v-textarea
            v-model="formState.input"
            label="Input object"
            prepend-icon="mdi-code-json"
            :rules="inputRules"
            variant="outlined"
          />
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import HeaderComponent from './components/HeaderComponent.vue';

const route = useRoute();
const isEditView = ref(route.path.includes('edit'));
const title = computed(()=> isEditView.value ? 'Edit View' : 'Create View');

const valid = ref(false);
const form = ref(null);
const formState = reactive({
    name: "",
    file: undefined,
    output: "{}",
    input: "{}",
});
const nameRules = [(value) => !!value || "Name is required"];
const fileRules = [(value) => !!value || "Experiment schema is required"];
const outputRules = [(value) => isJsonString(value) || "Output is not a valid JSON"];
const inputRules = [(value) => isJsonString(value) || "Input is not a valid JSON"];

const isJsonString = (jsonString) => {
  try {
        var o = JSON.parse(jsonString);

        if (o && typeof o === "object") {
            return true;
        }
    }
    catch (e) { /* empty */ }

    return false;
};
</script>

<style scoped>
.v-card-title{
  padding: 0;
}

.v-card-text{
  padding: 16;
}
</style>