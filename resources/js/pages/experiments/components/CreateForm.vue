<template>
  <v-form
    ref="form"
    :disabled="loading"
  >
    <v-container class="ma-0 pa-0">
      <v-row dense>
        <v-col>
          <v-text-field
            v-model="formState.name"
            class="form-field"
            :label="$t('ExperimentName')"
            prepend-icon="mdi-rename-outline"
            required
            :rules="nameRules"
            variant="outlined"
          />
        </v-col>
        <v-col>
          <v-file-input
            v-model="formState.file"
            accept=".zcos"
            chips
            class="form-field"
            :label="$t('ExperimentSchema')"
            required
            :rules="fileRules"
            variant="outlined"
          />
          <div
            v-if="file"
            class="file-info ml-10"
          >
            <strong>File:</strong> {{ file }}
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-textarea
            v-model="formState.output"
            class="form-field"
            :label="$t('ExperimentOutput')"
            prepend-icon="mdi-code-brackets"
            :rules="outputRules"
            variant="outlined"
          />
        </v-col>
        <v-col>
          <v-textarea
            v-model="formState.input"
            class="form-field"
            :label="$t('ExperimentContext')"
            prepend-icon="mdi-code-json"
            :rules="inputRules"
            variant="outlined"
          />
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script setup>
import { trans } from "laravel-vue-i18n";
import { reactive, watch } from "vue";
import { ref } from "vue";

const props = defineProps({
    loading: {
        type: Boolean,
        required: true,
    },
    experiment: {
        type: Object,
        default: undefined,
    },
});

const form = ref(null);
const formState = reactive({
    name: "",
    file: undefined,
    output: "[]",
    input: "{}",
});
const file = ref("");

watch(props, () => {
    if (props.experiment) {
        const { context, name, output, file_name } = props.experiment;
        formState.input = context;
        formState.output = output;
        formState.name = name;
        file.value = file_name;
    }
});

defineExpose({
    form,
    formState,
    file,
});

const nameRules = [(value) => !!value || trans("ExperimentNameError")];
const fileRules = [
    (value) =>
        !value ||
        !!value.length ||
        !!file.value ||
        trans("ExperimentSchemaError"),
];
const outputRules = [
    (value) => isArrayString(value) || trans("ExperimentOutputArrayError"),
    (value) => onlyStrings(value) || trans("ExperimentOutputStringsError"),
    (value) =>
        containsUnique(value) || trans("ExperimentOutputUniqueStringError"),
];
const inputRules = [
    (value) => isJsonString(value) || trans("ExperimentContextError"),
];

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
    const notString = array.find((item) => typeof item !== "string");

    return !notString;
};

const isArrayString = (arrayString) => {
    try {
        const o = JSON.parse(arrayString);

        if (o && typeof o === "object" && Array.isArray(o)) {
            return true;
        }
    } catch (e) {
        /* empty */
    }

    return false;
};

const isJsonString = (jsonString) => {
    try {
        const o = JSON.parse(jsonString);

        if (o && typeof o === "object") {
            return true;
        }
    } catch (e) {
        /* empty */
    }

    return false;
};
</script>

<style lang="scss" scoped>
.file-info {
    margin-top: -16px;
}

.form-field {
    min-width: 300px;

    @media (min-width: 600px) {
        min-width: 430px;
    }
}
</style>
