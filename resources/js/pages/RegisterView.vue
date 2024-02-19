<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useSignUpMutation } from "../api/queries/authQueries";

const router = useRouter();
const valid = ref(false);
const form = ref(null);
const formState = reactive({
    username: "",
    email: "",
    password: "",
    passwordRepeat: "",
});

const usernameRules = [(value) => !!value || "Username is required"];

const emailRules = [
    (value) => !!value || "Email is required",
    (value) => /.+@.+\..+/.test(value) || "Email must be valid",
];

const passwordRules = [
    (value) => !!value || "Password is required",
    (value) =>
        (value && value.length >= 6) ||
        "Password must be at least 6 characters long",
];

const passwordRepeatRules = [
    (value) => !!value || "Password Repeat is required",
    (value) => value === formState.password || "Passwords doesn't match",
];

const { mutateAsync, isLoading } = useSignUpMutation();

const onAlreadyHavenAnAccountPressed = () => {
    router.push("/login");
};

const onSubmit = async () => {
    if (!valid.value) {
        return;
    }

    try {
        await mutateAsync({
            name: formState.username,
            email: formState.email,
            password: formState.password,
        });

        router.push("/");
    } catch (err) {
        console.error(err);
    }

    console.log("Submit");
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
                <v-form ref="form" v-model="valid" @submit.prevent="onSubmit">
                    <v-text-field
                        id="username"
                        name="username"
                        prepend-icon="mdi-account"
                        type="text"
                        v-model="formState.username"
                        :label="$t('Username')"
                        :rules="usernameRules"
                    ></v-text-field>
                    <v-text-field
                        id="email"
                        name="email"
                        prepend-icon="mdi-email"
                        type="email"
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
                    <v-text-field
                        id="passwordRepeat"
                        name="passwordRepeat"
                        prepend-icon="mdi-lock"
                        type="password"
                        v-model="formState.passwordRepeat"
                        :label="$t('RepeatPassword')"
                        :rules="passwordRepeatRules"
                    ></v-text-field>
                    <div class="flex flex-row justify-end">
                        <v-btn
                            class="mr-4"
                            variant="outlined"
                            @click="onAlreadyHavenAnAccountPressed"
                            >{{ $t("LoginToAccount") }}</v-btn
                        >
                        <v-btn
                            class="self-end"
                            type="submit"
                            variant="elevated"
                            :loading="isLoading"
                            >{{ $t("RegisterBtn") }}</v-btn
                        >
                    </div>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
