<template>
    <v-card variant="outlined" class="w-2/5">
        <v-card-title class="bg-gray-300 border-b-2 border-b-black border-solid"
            >Login</v-card-title
        >
        <v-icon></v-icon>
        <v-card-text class="ma-0 pa-0">
            <v-container>
                <v-form class="flex flex-col">
                    <v-text-field
                        prepend-icon="mdi-account"
                        name="login"
                        label="Login"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        id="password"
                        prepend-icon="mdi-lock"
                        name="password"
                        label="Password"
                        type="password"
                    ></v-text-field>
                    <v-btn variant="elevated" class="self-end">Login</v-btn>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</template>
