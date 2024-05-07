import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';

import Routes from './routes.js';

import { createPinia } from 'pinia';
import { useAuthUserStore } from './Stores/AuthUser';


const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});

// router.beforeEach((to, from, next) => {
//     const authUserStore = useAuthUserStore();
//     if (!authUserStore.user || authUserStore.user.fname === '' && to.name !== 'admin.login') {
//         authUserStore.getAuthUser().then(() => {
//             next();
//         });
//     } else {
//         next();
//     }
// });



const app = createApp({});
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount('#app');
