<template>
  <v-app-bar elevation="2">
    <template #prepend>
      <v-app-bar-nav-icon
        variant="tonal"
        @click.prevent="emit('toggle')"
      />
    </template>
    <template #title>
      <v-app-bar-title class="font-weight-bold">
        {{ $t("Title") }}
      </v-app-bar-title>
    </template>
    <template #append>
      <theme-toggle />
      <language-menu />
    </template>
  </v-app-bar>
</template>

<script setup>
import LanguageMenu from "./LanguageMenu.vue";
import ThemeToggle from "./ThemeToggle.vue";

const emit = defineEmits(["toggle"]);
</script>
