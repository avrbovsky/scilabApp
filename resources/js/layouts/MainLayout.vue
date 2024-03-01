<template>
  <v-layout>
    <app-header />
    <side-navigation />
    <main-placeholder>
      <router-view />
      <v-snackbar
        v-model="snackbar.show"
        :color="snackbar.color"
        rounded="pill"
      >
        {{ snackbar.message }}
      </v-snackbar>
    </main-placeholder>
  </v-layout>
</template>

<script setup>
import AppHeader from "@/components/AppHeader.vue";
import MainPlaceholder from "@/components/MainPlaceholder.vue";
import SideNavigation from "@/components/SideNavigation.vue";
import { useNotificationStore } from '@/stores/NotificationService';

const {snackbar} = useNotificationStore();
</script>