<template>
  <div>
    <header-component
      :back-button="true"
      :title="title"
    >
      <v-btn icon>
        <v-icon>mdi-content-save</v-icon>
      </v-btn>
    </header-component>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';
import HeaderComponent from './components/HeaderComponent.vue';

const route = useRoute();
const isEditView = ref(route.path.includes('edit'));
const title = computed(()=> isEditView.value ? 'Edit View' : 'Create View');
</script>