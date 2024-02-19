import { createRouter, createWebHashHistory } from "vue-router";
import AuthLayout from "../layouts/AuthLayout.vue";
import MainLayout from "../layouts/MainLayout.vue";
import LoginView from "../pages/LoginView.vue";
import RegisterView from "../pages/RegisterView.vue";

const routes = [
    {
        path: "/login",
        component: AuthLayout,
        children: [
            {
                path: "",
                component: LoginView,
            },
        ],
    },
    {
        path: "/register",
        component: AuthLayout,
        children: [
            {
                path: "",
                component: RegisterView,
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
