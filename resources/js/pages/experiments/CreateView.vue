<template>
  <v-card
    class="h-100"
    :loading="isPending"
  >
    <header-component
      :back-button="true"
      :title="title"
    >
      <v-btn
        :disabled="isPending"
        icon
        @click="onSaveClicked"
      >
        <v-icon>mdi-content-save</v-icon>
      </v-btn>
    </header-component>
    <template #loader="{ isActive }">
      <v-progress-linear
        :active="isActive"
        color="blue-grey-lighten-3"
        height="4"
        indeterminate
      />
    </template>
    <v-card-text class="py-8">
      <v-form
        ref="form"
        v-model="valid"
        :disabled="isPending"
      >
        <div class="ma-auto w-50">
          <v-text-field
            v-model="formState.name"
            class="mb-4"
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
            class="mb-4"
            label="Experiment file"
            required
            :rules="fileRules"
            variant="outlined"
          />
          <v-textarea
            v-model="formState.output"
            class="mb-4"
            label="Output object"
            prepend-icon="mdi-code-brackets"
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
        <v-snackbar
          v-model="snackbar"
          :color="snackbarColor"
          rounded="pill"
        >
          {{ snackbarText }}
        </v-snackbar>
      </v-form>
      <graph-component :data="graphData" />
    </v-card-text>
  </v-card>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useExperimentSaveMutation } from '../../api/queries/experimentQueries';
import HeaderComponent from './components/HeaderComponent.vue';
import GraphComponent from './components/GraphComponent.vue';

const route = useRoute();
const isEditView = ref(route.path.includes('edit'));
const title = computed(()=> isEditView.value ? 'Edit View' : 'Create View');

const { isPending, mutateAsync } = useExperimentSaveMutation();
const snackbar = ref(false);
const snackbarColor = ref("success");
const snackbarText = ref("Experiment created successfully");

const valid = ref(false);
const form = ref(null);
const formState = reactive({
    name: "",
    file: undefined,
    output: "[]",
    input: "{}",
});
const nameRules = [(value) => !!value || "Name is required"];
const fileRules = [(value) => !value || !!value.length || "Experiment schema is required"];
const outputRules = [(value) => isArrayString(value) || "Output is not a valid Array",
                      (value) => onlyStrings(value) || "Output must contain only strings",
                      (value) => containsUnique(value) || "Output must contain unique strings"
                    ];
const inputRules = [(value) => isJsonString(value) || "Input is not a valid JSON",
                    (value) => onlyNumbersAsValue(value) || "Input must contain only numbers as values"];

const graphData = ref([]);

const onlyUnique = (value, index, array) => {
  return array.indexOf(value) === index;
};

const containsUnique = (arrayString) => {
  const array = JSON.parse(arrayString);
  const uniqueArray = array.filter(onlyUnique);
  return uniqueArray.length === array.length;
};

const onlyStrings = (arrayString) => {
  const array = JSON.parse(arrayString);
  const notString = array.find(item=> typeof item !== "string");

  return !notString;
};

const isArrayString = (arrayString) => {
  try {
        const o = JSON.parse(arrayString);

        if (o && typeof o === "object" && Array.isArray(o)) {
            return true;
        }
    }
    catch (e) { /* empty */ }

    return false;
};

const onlyNumbersAsValue = (jsonString) => {
  const o = JSON.parse(jsonString);
  const values = Object.values(o);
  const notNumber = values.find(item => typeof item !== "number");

  return notNumber === undefined;
};

const isJsonString = (jsonString) => {
  try {
        const o = JSON.parse(jsonString);

        if (o && typeof o === "object") {
            return true;
        }
    }
    catch (e) { /* empty */ }

    return false;
};

const onSaveClicked = async () => {
  const { valid: isValid } = await form.value.validate();

  if (isValid) {
    try {
      const {data} = await mutateAsync({
        name: formState.name,
        file: formState.file[0],
        context: formState.input,
        output: formState.output,
      });
      
      snackbarText.value = "Experiment created successfully";
      snackbarColor.value = "success";
      snackbar.value = true;
      form.value.reset();
      graphData.value = data.simulation;

    } catch (err) {
      snackbarText.value = "There was an error when creating Experiment";
      snackbarColor.value = "error";
      snackbar.value = true;
    }
    
  }
};
</script>

<style scoped>
.v-card-title{
  padding: 0;
}
.v-card{
  display: flex !important;
  flex-direction: column;
}
.v-card-text{
  overflow: scroll;
  padding: 16;
}
</style>