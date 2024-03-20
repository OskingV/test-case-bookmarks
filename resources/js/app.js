import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from "vue-router";
import { routes } from "./routes";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'toastr/build/toastr.min.css'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faEye } from "@fortawesome/free-solid-svg-icons";
library.add(faEye);

import App from './components/App.vue'
let app = createApp(App)

const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
})

app.use(router);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app")
