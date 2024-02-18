<script setup>
import NavigationList from "../components/NavigationList.vue";
</script>

<template>
    <v-app-bar color="primary" title="Application bar"></v-app-bar>
    <v-navigation-drawer expand-on-hover rail>
        <v-list>
            <v-list-item
                prepend-avatar="https://randomuser.me/api/portraits/men/73.jpg"
                title="John Doe"
                subtitle="john_doe@example.com"
            ></v-list-item>
        </v-list>
        <v-divider></v-divider>
        <NavigationList />
    </v-navigation-drawer>
    <v-main>
        <router-view></router-view>
    </v-main>
</template>
