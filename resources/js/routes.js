// Import components
import AdminDashboard from './Pages/Admin/Dashboard/Dashboard.vue';
import AdminEnterprise from './Pages/Admin/Enterprise/EnterpriseList.vue';
import AdminEnterpriseForm from './Pages/Admin/Enterprise/EnterpriseRegister.vue';
import AdminEnterpriseArchive from './Pages/Admin/Enterprise/EnterpriseArchive.vue';
import AdminMerchant from './Pages/Admin/Merchant/MerchantList.vue';
import AdminMerchantPending from './Pages/Admin/Merchant/MerchantPending.vue';
import AdminMerchantForm from './Pages/Admin/Merchant/MerchantRegister.vue';
import AdminMerchantArchive from './Pages/Admin/Merchant/MerchantArchive.vue';
import AdminTripidkard from './Pages/Admin/Tripidkard/TripidkardList.vue';
import AdminTripidkardForm from './Pages/Admin/Tripidkard/TripidkardRegister.vue';
import AdminCustomer from './Pages/Admin/Customer/CustomerList.vue';
import AdminCustomerForm from './Pages/Admin/Customer/CustomerRegister.vue';
import AdminLoyaltyPoint from './Pages/Admin/Points/LoyaltyPointList.vue';
import AdminLoyaltyStarForm from './Pages/Admin/Points/LoyaltyPointRegister.vue';
import AdminStarForm from './Pages/Admin/Points/StarsForm.vue';
import AdminCustomerStars from './Pages/Admin/Points/CustomerStars.vue';
import AdminLogs from './Pages/Admin/ActivityLogs/Logs.vue';

import MerchantDashboard from './Pages/Merchant/Dashboard/Dashboard.vue';
import MerchantScanner from './Pages/Merchant/Scanner/Qr-Code.vue';
import MerchantTripidkard from './Pages/Merchant/Tripidkard/TripidkardList.vue';
import MerchantCustomer from './Pages/Merchant/Customer/CustomerList.vue';
import MerchantCustomerForm from './Pages/Merchant/Customer/CustomerRegister.vue';
import MerchantLoyaltyPoint from './Pages/Merchant/Points/LoyaltyPointList.vue';
import MerchantStarsPointForm from './Pages/Merchant/Points/LoyaltyPointRegister.vue';
import MerchantLogs from './Pages/Merchant/ActivityLogs/Logs.vue';

import Login from './Pages/Auth/Login.vue';
import ForgotPassword from './Pages/Auth/Forgot.vue';
import NotFound from './Pages/Error/404.vue';
import Profile from './Pages/Profiles/Information.vue';

import Index from './Pages/Home/Dashboard/HomeList.vue';
import TripidkardDetails from './Pages/Home/Tripidkard/TripidkardList.vue';
import MerchantDetails from './Pages/Home/Merchant/MerchantList.vue';
import MerchantWeb from './Pages/Home/Websites/MerchantWeb.vue';
import JoinForm from './Pages/Home/JoinForm/JoinList.vue';
import ContactUs from './Pages/Home/Contact/ContactUsList.vue';
import MerchantResultCity from './Pages/Home/Result/MerchantResultCity.vue';
import MerchantResultProvince from './Pages/Home/Result/MerchantResultProvince.vue';

import Raffle from './Pages/Home/JoinTheFun/Raffle.vue';
import Points from './Pages/Home/JoinTheFun/Points.vue';
import Events from './Pages/Home/JoinTheFun/Events.vue';

const routesAdmin = [
    { path: '/admin/login/', name: 'admin.login', component: Login, meta: { title: 'Admin Login', requiresAdminAuth: true } },
    { path: '/admin/dashboard/', name: 'admin.dashboard', component: AdminDashboard, meta: { title: 'Admin Dashboard', requiresAdminAuth: true } },
    { path: '/admin/enterprise/', name: 'admin.enterprise', component: AdminEnterprise, meta: { title: 'Enterprise List', requiresAdminAuth: true } },
    { path: '/admin/enterprise/register', name: 'admin.enterprise.register', component: AdminEnterpriseForm, meta: { title: 'Enterprise Register', requiresAdminAuth: true } },
    { path: '/admin/enterprise/:id/edit', name: 'admin.enterprise.edit', component: AdminEnterpriseForm, meta: { title: 'Enterprise Update', requiresAdminAuth: true } },
    { path: '/admin/enterprise/archive', name: 'admin.enterprise.archive', component: AdminEnterpriseArchive, meta: { title: 'Enterprise Archive', requiresAdminAuth: true } },
    { path: '/admin/merchant/', name: 'admin.merchant', component: AdminMerchant, meta: { title: 'Merchant Listing', requiresAdminAuth: true } },
    { path: '/admin/merchant-pending/', name: 'admin.merchant-pending', component: AdminMerchantPending, meta: { title: 'Merchant Pending', requiresAdminAuth: true } },
    { path: '/admin/merchant/register', name: 'admin.merchant.register', component: AdminMerchantForm, meta: { title: 'Merchant Register', requiresAdminAuth: true } },
    { path: '/admin/merchant/:id/edit', name: 'admin.merchant.edit', component: AdminMerchantForm, meta: { title: 'Merchant Update', requiresAdminAuth: true } },
    { path: '/admin/merchant/archive', name: 'admin.merchant.archive', component: AdminMerchantArchive, meta: { title: 'Merchant Archive', requiresAdminAuth: true } },
    { path: '/admin/tripidkard/', name: 'admin.tripidkard', component: AdminTripidkard, meta: { title: 'Tripidkard List', requiresAdminAuth: true } },
    { path: '/admin/tripidkard/register', name: 'admin.tripidkard.register', component: AdminTripidkardForm, meta: { title: 'Tripidkard Register', requiresAdminAuth: true } },
    { path: '/admin/customer/', name: 'admin.customer', component: AdminCustomer, meta: { title: 'Customer List', requiresAdminAuth: true } },
    { path: '/admin/customer/register', name: 'admin.customer.register', component: AdminCustomerForm, meta: { title: 'Customer Register', requiresAdminAuth: true } },
    { path: '/admin/customer/:id/edit', name: 'admin.customer.edit', component: AdminCustomerForm, meta: { title: 'Customer Update', requiresAdminAuth: true } },
    { path: '/admin/loyalty-stars', name: 'admin.loyalty-stars', component: AdminLoyaltyPoint, meta: { title: 'Loyalty Stars List', requiresAdminAuth: true } },
    { path: '/admin/loyalty-stars/register', name: 'admin.loyalty-stars.register', component: AdminLoyaltyStarForm, meta: { title: 'Loyalty Stars Register', requiresAdminAuth: true } },
    { path: '/admin/loyalty-stars/:id/edit', name: 'admin.loyalty-stars.edit', component: AdminLoyaltyStarForm, meta: { title: 'Loyalty Stars Update', requiresAdminAuth: true } },
    { path: '/admin/stars/register', name: 'admin.stars.register', component: AdminStarForm, meta: { title: 'Total of Loyalty Stars', requiresAdminAuth: true } },
    { path: '/admin/loyalty-stars/:id/customer', name: 'admin.loyalty-stars.customer', component: AdminCustomerStars, meta: { title: 'Customer Loyalty Stars List', requiresAdminAuth: true } },
    { path: '/admin/activity-log/', name: 'admin.activity-log', component: AdminLogs, meta: { title: 'Activity Logs List', requiresAdminAuth: true } }
];

const routesMerchant = [
    { path: '/merchant/dashboard', name: 'merchant.dashboard', component: MerchantDashboard, meta: { title: 'Merchant Dashboard', requiresMerchantAuth: true } },
    { path: '/merchant/scanner', name: 'merchant.scanner', component: MerchantScanner, meta: { title: 'Merchant QR', requiresMerchantAuth: true } },
    { path: '/merchant/tripidkard/', name: 'merchant.tripidkard', component: MerchantTripidkard, meta: { title: 'Tripidkard List', requiresMerchantAuth: true } },
    { path: '/merchant/customer/', name: 'merchant.customer', component: MerchantCustomer, meta: { title: 'Customer List', requiresMerchantAuth: true } },
    { path: '/merchant/customer/register', name: 'merchant.customer.register', component: MerchantCustomerForm, meta: { title: 'Customer Register', requiresMerchantAuth: true } },
    { path: '/merchant/customer/:id/edit', name: 'merchant.customer.edit', component: MerchantCustomerForm, meta: { title: 'Customer Update', requiresMerchantAuth: true } },
    { path: '/merchant/loyalty-stars', name: 'merchant.loyalty-stars', component: MerchantLoyaltyPoint, meta: { title: 'Loyalty Stars List', requiresMerchantAuth: true } },
    { path: '/merchant/loyalty-stars/register', name: 'merchant.loyalty-stars.register', component: MerchantStarsPointForm, meta: { title: 'Loyalty Stars Register', requiresMerchantAuth: true } },
    { path: '/merchant/loyalty-stars/:id/edit', name: 'merchant.loyalty-stars.edit', component: MerchantStarsPointForm, meta: { title: 'Loyalty Stars Update', requiresMerchantAuth: true } },
    { path: '/merchant/activity-log/', name: 'merchant.activity-log', component: MerchantLogs, meta: { title: 'Activity Logs List', requiresMerchantAuth: true } },
    { path: '/merchant/profile/', name: 'merchant.profile', component: Profile, meta: { title: 'Merchant Profile Information', requiresMerchantAuth: true } }
];

const routesDefault = [
    { path: '/', name: 'home', component: Index, meta: { title: 'Home' } },
    { path: '/profile/', name: 'profile', component: Profile, meta: { title: 'Profile' } },
    { path: '/merchants/', name: 'merchants', component: MerchantDetails, meta: { title: 'Merchant' } },
    { path: '/merchants/:id/:name', name: 'merchants.name', component: MerchantWeb, meta: { title: 'Merchant Website' } },
    { path: '/join/', name: 'join', component: JoinForm, meta: { title: 'Join Us' } },
    { path: '/contact-us/', name: 'contact-us', component: ContactUs, meta: { title: 'Contact Us' } },
    { path: '/merchant/result/city', name: 'merchant-result-city', component: MerchantResultCity, meta: { title: 'Search Result City'} },
    { path: '/merchant/result/province', name: 'merchant-result-province', component: MerchantResultProvince, meta: { title: 'Search Result Province'} },
    { path: '/join-the-fun/raffle', name: 'raffle', component: Raffle, meta: { title: 'Join The Fun Raffle'} },
    { path: '/join-the-fun/points', name: 'points', component: Points, meta: { title: 'Join The Fun Points'} },
    { path: '/join-the-fun/events', name: 'events', component: Events, meta: { title: 'Join The Fun Events'} },

    { path: '/login/', name: 'login', component: Login, meta: { title: 'User Login', requiresGuest: true, } },
    { path: '/forgot-password/', name: 'forgot-password', component: ForgotPassword, meta: { title: 'Forgot Password', requiresGuest: true, } },
    { path: '/tripidkard/', name: 'tripidkard', component: TripidkardDetails, meta: { title: 'Tripidkard', requiresGuest: true, } },

    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound, meta: { title: 'Not Found' } }
];

export { routesAdmin, routesMerchant, routesDefault };
