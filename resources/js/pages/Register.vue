<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
const onAlreadyHavenAnAccountPressed = () => {
    router.push("/login");
};
</script>

<template>
    <v-card variant="outlined" class="w-2/5">
        <v-card-title
            class="bg-gray-300 border-b-2 border-b-black border-solid"
            >{{ $t("Register") }}</v-card-title
        >
        <v-icon></v-icon>
        <v-card-text class="ma-0 pa-0">
            <v-container>
                <v-form>
                    <v-text-field
                        id="username"
                        prepend-icon="mdi-account"
                        name="username"
                        :label="$t('Username')"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="email"
                        prepend-icon="mdi-email"
                        name="email"
                        :label="$t('Email')"
                        type="email"
                    ></v-text-field>
                    <v-text-field
                        id="password"
                        prepend-icon="mdi-lock"
                        name="password"
                        :label="$t('Password')"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="passwordRepeat"
                        prepend-icon="mdi-lock"
                        name="passwordRepeat"
                        :label="$t('RepeatPassword')"
                        type="password"
                    ></v-text-field>
                    <div class="flex flex-row justify-end">
                        <v-btn
                            variant="outlined"
                            class="mr-4"
                            @click="onAlreadyHavenAnAccountPressed"
                            >{{ $t("LoginToAccount") }}</v-btn
                        >
                        <v-btn variant="elevated" class="self-end">{{
                            $t("RegisterBtn")
                        }}</v-btn>
                    </div>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
