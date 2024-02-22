<template>
  <v-layout>
    <v-app-bar elevation="2">
      <template #title>
        <v-app-bar-title class="font-weight-bold">
          Application Bar
        </v-app-bar-title>
      </template>
    </v-app-bar>
    <v-navigation-drawer theme="dark">
      <v-list>
        <v-list-item
          prepend-avatar="https://randomuser.me/api/portraits/men/73.jpg"
          :subtitle="user?.email || 'Unknown Email'"
          :title="user?.name || 'Unknown Name'"
        />
      </v-list>
      <v-divider thickness="3" />
      <navigation-list />
      <template #append>
        <logout-btn />
      </template>
    </v-navigation-drawer>
    <v-main class="align-center d-flex justify-center">
      <v-container class="h-100 px-4 py-5 w-100">
        <v-container
          class="bg-surface elevation-3 h-100 mx-auto rounded-lg shadow-md w-75 w-full"
        >
          <router-view />
        </v-container>
      </v-container>
    </v-main>
  </v-layout>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/Auth";
import NavigationList from "@/components/NavigationList.vue";
import LogoutBtn from "@/components/LogoutBtn.vue";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>