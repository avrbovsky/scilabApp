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

        try {
            const langModule = await langs[`../../lang/${lang}.json`]();
            return langModule;
        } catch (error) {
            console.error(
                `Could not load ${lang}, falling back to default language.`
            );
            const fallbackLang = "en";
            const fallbackLangModule = await langs[
                `../../lang/${fallbackLang}.json`
            ]();
            return fallbackLangModule;
        }
    },
});
app.mount("#app");
