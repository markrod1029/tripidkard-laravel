import AdminDashboard from './Pages/Admin/Dashboard.vue'
import AdminEnterprise from './Pages/Admin/Enterprise.vue'

const routes = [
    
    {
        path: '/admin/dashboard/',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            title: 'Dashboard'
        }
    },

    {
        path: '/admin/enterprise/',
        name: 'admin.enterprise',
        component: AdminEnterprise,
        meta: {
            title: 'Enterprise List'
        }
    },



]

export default routes;