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
    <div class="pa-2">
        <v-btn prepend-icon="mdi-logout" block @click="onLogoutClicked"
            >Logout</v-btn
        >
    </div>
</template>
