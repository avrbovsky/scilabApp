<script setup>
import { useAuthStore } from "../stores/Auth";
import { useRouter } from "vue-router";

const router = useRouter();
const { signOut } = useAuthStore();

const onLogoutClicked = () => {
    signOut();
    router.push("/login");
};
</script>

<template>
    <v-list density="compact" variant="tonal" nav class="flex flex-col">
        <v-list-item
            prepend-icon="mdi-folder"
            title="My Files"
            value="myfiles"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-account-multiple"
            title="Shared with me"
            value="shared"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-star"
            title="Starred"
            value="starred"
        ></v-list-item>
        <v-list-item
            class="justify-self-end"
            prepend-icon="mdi-logout"
            value="logout"
            :title="$t('Logout')"
            @click="onLogoutClicked"
        >
        </v-list-item>
    </v-list>
</template>
