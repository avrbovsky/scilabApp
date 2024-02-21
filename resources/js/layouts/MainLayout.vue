<template>
  <v-layout>
    <v-app-bar elevation="2">
      <template #title>
        <v-app-bar-title :style="{ fontWeight: 'bold' }">
          Application Bar
        </v-app-bar-title>
      </template>
    </v-app-bar>
    <v-navigation-drawer class="bg-black">
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
      <div class="h-100 px-4 py-5 w-100">
        <div
          class="bg-white h-100 mx-auto rounded-lg shadow-md w-75 w-full"
        >
          <router-view />
        </div>
      </div>
    </v-main>
  </v-layout>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/Auth";
import NavigationList from "../components/NavigationList.vue";
import LogoutBtn from "../components/LogoutBtn.vue";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>