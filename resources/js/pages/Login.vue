<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
const onCreateAccountPressed = () => {
    router.push("/register");
};
</script>

<template>
    <v-card variant="outlined" class="w-2/5">
        <v-card-title
            class="bg-gray-300 border-b-2 border-b-black border-solid"
            >{{ t$("Login") }}</v-card-title
        >
        <v-icon></v-icon>
        <v-card-text class="ma-0 pa-0">
            <v-container>
                <v-form>
                    <v-text-field
                        prepend-icon="mdi-account"
                        name="login"
                        :label="$t('Login')"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="password"
                        prepend-icon="mdi-lock"
                        name="password"
                        :label="t('Password')"
                        type="password"
                    ></v-text-field>
                    <div class="flex flex-row justify-end">
                        <v-btn
                            variant="outlined"
                            class="mr-4"
                            @click="onCreateAccountPressed"
                            >{{ $t("CreateAccount") }}</v-btn
                        >
                        <v-btn variant="elevated" class="self-end">{{
                            $t("Login")
                        }}</v-btn>
                    </div>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
