import { createRouter, createWebHashHistory } from "vue-router";
import AuthLayout from "../layouts/AuthLayout.vue";
import MainLayout from "../layouts/MainLayout.vue";
import Login from "../pages/Login.vue";

const routes = [
    {
        path: "/login",
        component: AuthLayout,
        children: [
            {
                path: "/",
                component: Login,
            },
        ],
    },
    {
        path: "/",
        component: MainLayout,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
