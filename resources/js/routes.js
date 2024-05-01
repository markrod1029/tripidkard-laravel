import Login from './Pages/Auth/Login.vue'
import AdminDashboard from './Pages/Admin/Dashboard/Dashboard.vue'
import NotFound from './Pages/Error/404.vue'

import AdminEnterprise from './Pages/Admin/Enterprise/EnterpriseList.vue'
import AdminEnterpriseForm from './Pages/Admin/Enterprise/EnterpriseRegister.vue'
import AdminEnterpriseArchive from './Pages/Admin/Enterprise/EnterpriseArchive.vue'

import AdminMerchant from './Pages/Admin/Merchant/MerchantList.vue'
import AdminMerchantForm from './Pages/Admin/Merchant/MerchantRegister.vue'
import AdminMerchantArchive from './Pages/Admin/Merchant/MerchantArchive.vue'

import AdminTripidkard from './Pages/Admin/Tripidkard/TripidkardList.vue'
import AdminTripidkardForm from './Pages/Admin/Tripidkard/TripidkardRegister.vue'

import AdminCustomer from './Pages/Admin/Customer/CustomerList.vue'
import AdminCustomerForm from './Pages/Admin/Customer/CustomerRegister.vue'

import AdminLoyaltyPoint from './Pages/Admin/Points/LoyaltyPointList.vue'
import AdminLoyaltyStarForm from './Pages/Admin/Points/LoyaltyPointRegister.vue'
import AdminCustomerStars from './Pages/Admin/Points/CustomerStars.vue'
import AdminLogs from './Pages/Admin/ActivityLogs/Logs.vue'


// Merchant
import MerchantDashboard from './Pages/Merchant/Dashboard/Dashboard.vue'
import MerchantScanner from './Pages/Merchant/Scanner/Qr-Code.vue'
import MerchantTripidkard from './Pages/Merchant/Tripidkard/TripidkardList.vue'
import MerchantCustomer from './Pages/Merchant/Customer/CustomerList.vue'
import MerchantCustomerForm from './Pages/Merchant/Customer/CustomerRegister.vue'


import MerchantLoyaltyPoint from './Pages/Merchant/Points/LoyaltyPointList.vue'
import MerchantStarsPointForm from './Pages/Merchant/Points/LoyaltyPointRegister.vue'
import MerchantLogs from './Pages/Merchant/ActivityLogs/Logs.vue'


import Profile from './Pages/Profiles/Information.vue';
const routes = [


    {
        path: '/:catchAll(.*)',
        component: NotFound, // Gamitin ang iyong custom 404 component dito
        meta: {
          title: '404 Not Found'
        }
      },
      {
        path: '/login/',
        name: 'login',
        component: Login,
        meta: {
            title: 'User Login'
        }
    },

    {
        path: '/admin/login/',
        name: 'admin.login',
        component: Login,
        meta: {
            title: 'Admin Login'
        }
    },

    {
        path: '/admin/dashboard/',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            title: 'Admin Dashboard'
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
        component: AdminEnterpriseForm,
        meta: {
            title: 'Enterprise Register'
        }
    },

    {
        path: '/admin/enterprise/:id/edit',
        name: 'admin.enterprise.edit',
        component: AdminEnterpriseForm,
        meta: {
            title: 'Enterprise Update'
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
        component: AdminMerchantForm,
        meta: {
            title: 'Merchant Register'
        }
    },

    {
        path: '/admin/merchant/:id/edit',
        name: 'admin.merchant.edit',
        component: AdminMerchantForm,
        meta: {
            title: 'Merchant Update'
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
        component: AdminTripidkardForm,
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
        component: AdminCustomerForm,
        meta: {
            title: 'Customer Register'
        }
    },



    {
        path: '/admin/customer/:id/edit',
        name: 'admin.customer.edit',
        component: AdminCustomerForm,
        meta: {
            title: 'Customer Update'
        }
    },

    {
        path: '/admin/loyalty-stars',
        name: 'admin.loyalty-stars',
        component: AdminLoyaltyPoint,
        meta: {
            title: 'Loyalty Stars List'
        }
    },

    {
        path: '/admin/loyalty-stars/register',
        name: 'admin.loyalty-stars.register',
        component: AdminLoyaltyStarForm,
        meta: {
            title: 'Loyalty Stars Register'
        }
    },

    {
        path: '/admin/loyalty-stars/:id/edit',
        name: 'admin.loyalty-stars.edit',
        component: AdminLoyaltyStarForm,
        meta: {
            title: 'Loyalty Stars Udate'
        }
    },

    {
        path: '/admin/loyalty-stars/:id/customer',
        name: 'admin.loyalty-stars.customer',
        component: AdminCustomerStars,
        meta: {
            title: 'Customer Loyalty Stars List'
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

    {
        path: '/merchant/dashboard/',
        name: 'merchant.dashboard',
        component: MerchantDashboard,
        meta: {
            title: 'Merchant Dashboard'
        }
    },

    {
        path: '//merchant/scanner',
        name: 'merchant.scanner',
        component: MerchantScanner,
        meta: {
            title: 'Merchant QR '
        }
    },



    {
        path: '/merchant/tripidkard/',
        name: 'merchant.tripidkard',
        component: MerchantTripidkard,
        meta: {
            title: 'Tripidkard List'
        }
    },

    {
        path: '/merchant/customer/',
        name: 'merchant.customer',
        component: MerchantCustomer,
        meta: {
            title: 'Customer List'
        }
    },

    {
        path: '/merchant/customer/register',
        name: 'merchant.customer.register',
        component: MerchantCustomerForm,
        meta: {
            title: 'Customer Register'
        }
    },



    {
        path: '/merchant/customer/:id/edit',
        name: 'merchant.customer.edit',
        component: MerchantCustomerForm,
        meta: {
            title: 'Customer Update'
        }
    },


    {
        path: '/merchant/loyalty-stars',
        name: 'merchant.loyalty-stars',
        component: MerchantLoyaltyPoint,
        meta: {
            title: 'Loyalty Stars List'
        }
    },

    {
        path: '/merchant/loyalty-stars/register',
        name: 'merchant./loyalty-stars.register',
        component: MerchantStarsPointForm,
        meta: {
            title: 'Loyalty Stars Register'
        }
    },


    {
        path: '/merchant/loyalty-stars/:id/edit',
        name: 'merchant.loyalty-stars.edit',
        component: MerchantStarsPointForm,
        meta: {
            title: 'Loyalty Stars Update'
        }
    },


    {
        path: '/merchant/activity-log/',
        name: 'merchant.activity-log',
        component: MerchantLogs,
        meta: {
            title: 'Activity Logs List'
        }
    },

    {
        path: '/merchant/profile/',
        name: 'merchant.profile',
        component: Profile,
        meta: {
            title: 'Merchant Profile Information'
        }
    }





]

export default routes;
