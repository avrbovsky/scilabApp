<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/Auth";
import NavigationList from "../components/NavigationList.vue";
import LogoutBtn from "../components/LogoutBtn.vue";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>

<template>
  <v-layout>
    <v-app-bar class="shadow-md">
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
    <v-main class="flex items-center justify-center">
      <div class="h-full md:px-0 px-4 py-5 w-full">
        <div
          class="bg-white h-full lg:w-2/3 md:w-11/12 mx-auto rounded-lg shadow-md w-full"
        >
          <router-view />
        </div>
      </div>
    </v-main>
  </v-layout>
</template>
