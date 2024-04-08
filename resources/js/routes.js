import AdminDashboard from './Pages/Admin/Dashboard/Dashboard.vue'
import NotFound from './Pages/Error/404.vue'

import AdminEnterprise from './Pages/Admin/Enterprise/EnterpriseList.vue'
import AdminEnterpriseRegister from './Pages/Admin/Enterprise/EnterpriseRegister.vue'
import AdminEnterpriseArchive from './Pages/Admin/Enterprise/EnterpriseArchive.vue'

import AdminMerchant from './Pages/Admin/Merchant/MerchantList.vue'
import AdminMerchantRegister from './Pages/Admin/Merchant/MerchantRegister.vue'
import AdminMerchantArchive from './Pages/Admin/Merchant/MerchantArchive.vue'

import AdminTripidkard from './Pages/Admin/Tripidkard/TripidkardList.vue'
import AdminTripidkardRegister from './Pages/Admin/Tripidkard/TripidkardRegister.vue'

import AdminCustomer from './Pages/Admin/Customer/CustomerList.vue'
import AdminCustomerregister from './Pages/Admin/Customer/CustomerRegister.vue'

import AdminLoyaltyPoint from './Pages/Admin/Points/LoyaltyPointList.vue'
import AdminLoyaltyPointRegister from './Pages/Admin/Points/LoyaltyPointRegister.vue'
import AdminLogs from './Pages/Admin/ActivityLogs/Logs.vue'

const routes = [


    {
        path: '/:catchAll(.*)',
        component: NotFound, // Gamitin ang iyong custom 404 component dito
        meta: {
          title: '404 Not Found'
        }
      },
    
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

    {
        path: '/admin/enterprise/register',
        name: 'admin.enterprise.register',
        component: AdminEnterpriseRegister,
        meta: {
            title: 'Enterprise Register'
        }
    },

    {
        path: '/admin/enterprise/archive',
        name: 'admin.enterprise.archive',
        component: AdminEnterpriseArchive,
        meta: {
            title: 'Enterprise Archive'
        }
    },



    {
        path: '/admin/merchant/',
        name: 'admin.merchant',
        component: AdminMerchant,
        meta: {
            title: 'Merchant List'
        }
    },

    {
        path: '/admin/merchant/register',
        name: 'admin.merchant.register',
        component: AdminMerchantRegister,
        meta: {
            title: 'Merchant Register'
        }
    },


    {
        path: '/admin/merchant/archive',
        name: 'admin.merchant.archive',
        component: AdminMerchantArchive,
        meta: {
            title: 'Merchant Archive'
        }
    },



    {
        path: '/admin/tripidkard/',
        name: 'admin.tripidkard',
        component: AdminTripidkard,
        meta: {
            title: 'Tripidkard List'
        }
    },


    {
        path: '/admin/tripidkard/register',
        name: 'admin.tripidkard.register',
        component: AdminTripidkardRegister,
        meta: {
            title: 'Tripidkard Register'
        }
    },

    {
        path: '/admin/customer/',
        name: 'admin.customer',
        component: AdminCustomer,
        meta: {
            title: 'Customer List'
        }
    },

    {
        path: '/admin/customer/register',
        name: 'admin.customer.register',
        component: AdminCustomerregister,
        meta: {
            title: 'Customer Register'
        }
    },


    {
        path: '/admin/loyalty-points',
        name: 'admin.loyalty-points',
        component: AdminLoyaltyPoint,
        meta: {
            title: 'Loyalty Points List'
        }
    },

    {
        path: '/admin/loyalty-points/register',
        name: 'admin./loyalty-points.register',
        component: AdminLoyaltyPointRegister,
        meta: {
            title: 'Loyalty Points Register'
        }
    },


    {
        path: '/admin/activity-log/',
        name: 'admin./activity-log',
        component: AdminLogs,
        meta: {
            title: 'Activity Logs List'
        }
    },

]

export default routes;