<template>
  <v-card
    class="h-100"
  >
    <header-component
      :back-button="true"
      title="Detail View"
    >
      <v-btn icon>
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
    </header-component>
    <v-card-text>
      <v-container>
        <div class="d-flex">
          <div class="text-h4">
            {{ data?.experiment?.name }}
          </div>
          <v-spacer />
          <div class="text-h5">
            <span class="font-weight-thin">By:</span>
            <span>{{ data?.experiment?.created_by }}</span>
          </div>
        </div>
        <v-divider />
        <v-form
          ref="form"
          class="mt-10"
          validate-on="submit"
          @submit.prevent="onSubmit"
        >
          <v-textarea
            v-model="experimentInput"
            label="Input object"
            prepend-icon="mdi-code-json"
            :rules="inputRules"
            variant="outlined"
          />
          <div class="d-flex justify-end">
            <v-btn type="submit">
              Simulate
            </v-btn>
          </div>
        </v-form>
        <v-container>
          <graph-component :data="[]" />
        </v-container>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script setup>
import HeaderComponent from './components/HeaderComponent.vue';
import {useExperimentDetailMutation} from "@/api/queries/experimentQueries";
import { useRoute } from 'vue-router';
import GraphComponent from './components/GraphComponent.vue';
import { ref } from 'vue';
import { watch } from 'vue';
import { onMounted } from 'vue';

const route = useRoute();
const {id} = route.params;
const { data, mutateAsync } = useExperimentDetailMutation();

onMounted(()=>{
  mutateAsync(id);
});

const form = ref(null);
const experimentInput = ref("");

watch(data, (newValue)=>{
  if(newValue){
    experimentInput.value = newValue.experiment?.context;
  }
});

const inputRules = [(value) => isJsonString(value) || "Input is not a valid JSON",
                    (value) => onlyNumbersAsValue(value) || "Input must contain only numbers as values"];

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

const onlyNumbersAsValue = (jsonString) => {
  const o = JSON.parse(jsonString);
  const values = Object.values(o);
  const notNumber = values.find(item => typeof item !== "number");

  return notNumber === undefined;
};

const onSubmit = () => {
  console.log("Simulate");
  // simulate experiment
};
</script>

<style scoped>
.v-card{
  display: flex !important;
  flex-direction: column;
}
.v-card-text{
  overflow: scroll;
  padding: 16;
}
</style>