<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useSignInMutation } from "../api/queries/authQueries";
import { useAuthStore } from "../stores/Auth";

const router = useRouter();

const valid = ref(false);
const form = ref(null);
const formState = reactive({
    email: "",
    password: "",
});
const emailRules = [(value) => !!value || "Email is required"];
const passwordRules = [(value) => !!value || "Password is required"];

const { mutateAsync, isLoading, error } = useSignInMutation();
const snackbar = ref(false);

const { signIn } = useAuthStore();

const onSubmit = async () => {
    if (!valid.value) {
        return;
    }

    try {
        const userData = await mutateAsync({
            email: formState.email,
            password: formState.password,
        });

        signIn({ email: formState.email }, userData.token);

        router.push("/");
    } catch (err) {
        console.error(err.response.data.message);
        snackbar.value = true;
    }
};

const onCreateAccountPressed = () => {
    router.push("/register");
};
</script>

<template>
    <v-card variant="outlined" class="w-2/5 shadow-2xl">
        <v-card-title
            class="bg-blue-500 border-b-2 border-b-black border-solid"
            >{{ $t("LoginTitle") }}</v-card-title
        >
        <v-icon></v-icon>
        <v-card-text class="ma-0 pa-0">
            <v-container>
                <v-form ref="form" v-model="valid" @submit.prevent="onSubmit">
                    <v-text-field
                        name="email"
                        prepend-icon="mdi-account"
                        type="text"
                        v-model="formState.email"
                        :label="$t('Email')"
                        :rules="emailRules"
                    ></v-text-field>
                    <v-text-field
                        id="password"
                        name="password"
                        prepend-icon="mdi-lock"
                        type="password"
                        v-model="formState.password"
                        :label="$t('Password')"
                        :rules="passwordRules"
                    ></v-text-field>
                    <div class="flex flex-row justify-end">
                        <v-btn
                            class="mr-4"
                            variant="outlined"
                            @click="onCreateAccountPressed"
                            >{{ $t("CreateAccount") }}</v-btn
                        >
                        <v-btn
                            class="self-end"
                            type="submit"
                            variant="elevated"
                            :loading="isLoading"
                            >{{ $t("LoginBtn") }}</v-btn
                        >
                    </div>
                    <v-snackbar
                        color="error"
                        rounded="pill"
                        v-model="snackbar"
                        :timeout="2000"
                    >
                        {{ error?.response?.data?.message || "Error ocurred" }}
                    </v-snackbar>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
