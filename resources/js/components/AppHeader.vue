<template>
  <v-app-bar elevation="2">
    <template #prepend>
      <v-app-bar-nav-icon @click.prevent="emit('toggle')" />
    </template>
    <template #title>
      <v-app-bar-title class="font-weight-bold">
        {{ $t("Title") }}
      </v-app-bar-title>
    </template>
  </v-app-bar>
</template>

<script setup>
import { defineEmits } from "vue";

const emit = defineEmits(["toggle"]);
</script>
