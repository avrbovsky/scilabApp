<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/Auth";
import NavigationList from "../components/NavigationList.vue";
import LogoutBtn from "../components/LogoutBtn.vue";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>

<template>
    <v-app-bar class="shadow-md">
        <template v-slot:title>
            <v-app-bar-title :style="{ fontWeight: 'bold' }"
                >Application Bar</v-app-bar-title
            >
        </template>
    </v-app-bar>
    <v-navigation-drawer class="bg-black">
        <v-list>
            <v-list-item
                prepend-avatar="https://randomuser.me/api/portraits/men/73.jpg"
                :title="user?.name || 'Unknown Name'"
                :subtitle="user?.email || 'Unknown Email'"
            ></v-list-item>
        </v-list>
        <v-divider thickness="3"></v-divider>
        <NavigationList />
        <template v-slot:append> <LogoutBtn /> </template>
    </v-navigation-drawer>
    <v-main class="flex justify-center items-center">
        <div class="py-5 px-4 md:px-0 h-full w-full">
            <div
                class="w-full md:w-11/12 lg:w-2/3 bg-white h-full mx-auto rounded-lg shadow-md"
            >
                <router-view></router-view>
            </div>
        </div>
    </v-main>
</template>
