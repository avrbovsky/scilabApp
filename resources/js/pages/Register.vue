<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
const onAlreadyHavenAnAccountPressed = () => {
    router.push("/login");
};
</script>

<template>
    <v-card variant="outlined" class="w-2/5">
        <v-card-title class="bg-gray-300 border-b-2 border-b-black border-solid"
            >Register</v-card-title
        >
        <v-icon></v-icon>
        <v-card-text class="ma-0 pa-0">
            <v-container>
                <v-form>
                    <v-text-field
                        id="login"
                        prepend-icon="mdi-account"
                        name="login"
                        label="Login"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="email"
                        prepend-icon="mdi-email"
                        name="email"
                        label="Email"
                        type="email"
                    ></v-text-field>
                    <v-text-field
                        id="password"
                        prepend-icon="mdi-lock"
                        name="password"
                        label="Password"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="passwordRepeat"
                        prepend-icon="mdi-lock"
                        name="passwordRepeat"
                        label="Repeat Password"
                        type="password"
                    ></v-text-field>
                    <div class="flex flex-row justify-end">
                        <v-btn
                            variant="outlined"
                            class="mr-4"
                            @click="onAlreadyHavenAnAccountPressed"
                            >Already have an account? Login</v-btn
                        >
                        <v-btn variant="elevated" class="self-end"
                            >Register</v-btn
                        >
                    </div>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
