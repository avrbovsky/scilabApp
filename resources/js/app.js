import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router/index.js";
import App from "./layouts/app.vue";
import vuetify from "./vuetify";

const app = createApp(App);
const pinia = createPinia();

app.use(vuetify);
app.use(pinia);
app.use(router);
app.mount("#app");
