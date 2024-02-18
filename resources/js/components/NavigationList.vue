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
            :title="$t('Logout')"
            value="logout"
        >
        </v-list-item>
    </v-list>
</template>
