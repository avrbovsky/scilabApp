<template>
  <div>
    <v-card
      class="rounded-t-xl"
      color="grey-lighten-3"
    >
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
          <div class="d-flex">
            <div class="d-flex flex-1-1-100 flex-column">
              <v-text-field
                v-model="formState.name"
                label="Name"
                required
                :rules="nameRules"
              />
            </div>
            <div class="d-flex flex-1-1-100 flex-column" />
          </div>
          <div class="d-flex">
            <div class="d-flex flex-1-1-100 flex-column">
              <v-text-field
                v-model="formState.name"
                label="Name"
                required
                :rules="nameRules"
              />
            </div>
            <div class="d-flex flex-1-1-100 flex-column" />
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
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
    email: "",
    password: "",
});
const nameRules = [(value) => !!value || "Name is required"];
</script>

<style scoped>
.v-card-title{
  padding: 0;
}

.v-card-text{
  padding: 16;
}
</style>