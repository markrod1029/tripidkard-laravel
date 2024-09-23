import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import { routesAdmin, routesMerchant, routesInfluencer, routesDefault } from './routes.js';
import { createPinia } from 'pinia';
import { useAuthStore } from './Stores/auth';

const pinia = createPinia();
const app = createApp({});

// Create router
const router = createRouter({
    history: createWebHistory(),
    routes: [...routesAdmin, ...routesMerchant, ...routesInfluencer, ...routesDefault],
});

// Navigation guard
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Load authUser from localStorage if not already loaded
    if (authStore.authUser === null) {
        const storedUser = localStorage.getItem('authUser');
        if (storedUser) {
            try {
                authStore.authUser = JSON.parse(storedUser);
            } catch (error) {
                console.error('Error parsing stored user data:', error);
                localStorage.removeItem('authUser'); // Clean up invalid data
            }
        }
    }

    // Check access based on user roles
    const isAuthenticated = authStore.isAuthenticated;
    const userRole = authStore.authUser ? authStore.authUser.role : null;
    if (to.matched.some(record => record.meta.requiresAdminAuth)) {
        if (!isAuthenticated || userRole !== 'admin') {
            next({ path: '/admin/login' });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresMerchantAuth)) {
        if (!isAuthenticated || userRole !== 'merchant') {
            next({ path: '/login' });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresInfluencerAuth)) {
        if (!isAuthenticated || userRole !== 'influencer') {
            next({ path: '/login' });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresGuest)) {
        if (isAuthenticated) {
            next({ path: '/' });
        } else {
            next();
        }
    } else {
        next(); // Proceed to the route
    }
});

// Register plugins
app.use(pinia);
app.use(router);

// Mount the app
app.mount('#app');
