import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { i18nVue } from "laravel-vue-i18n";
import router from "./router/index.js";
import App from "./App.vue";
import vuetify from "./vuetify";

const app = createApp(App);
const pinia = createPinia();

app.use(vuetify);
app.use(pinia);
app.use(router);
app.use(i18nVue, {
    resolve: async (lang) => {
        const langs = import.meta.glob("../../lang/*.json");
        return await langs[`../../lang/${lang}.json`]();
    },
});
app.mount("#app");
