// Import components
import AdminDashboard from './Pages/Admin/Dashboard/Dashboard.vue';

import AdminMerchant from './Pages/Admin/Merchant/MerchantList.vue';
import AdminMerchantPending from './Pages/Admin/Merchant/MerchantPending.vue';
import AdminMerchantForm from './Pages/Admin/Merchant/MerchantRegister.vue';
import AdminMerchantArchive from './Pages/Admin/Merchant/MerchantArchive.vue';

import AdminInfluencer from './Pages/Admin/Influencer/InfluencerList.vue';
import AdminInfluencerPending from './Pages/Admin/Influencer/InfluencerPending.vue';
import AdminInfluencerForm from './Pages/Admin/Influencer/InfluencerRegister.vue';
import AdminInfluencerArchive from './Pages/Admin/Influencer/InfluencerArchive.vue';


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
import Ordes from './Pages/Merchant/Orders/orders.vue';
import OrdeLists from './Pages/Merchant/Orders/list.vue';

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
import Scanner from './Pages/Home/Scanner/index.vue';
import ScannerResult from './Pages/Home/ScannerResult/index.vue';

import Raffle from './Pages/Home/JoinTheFun/Raffle.vue';
import Points from './Pages/Home/JoinTheFun/Points.vue';
import Events from './Pages/Home/JoinTheFun/Events.vue';

const routesAdmin = [
    { path: '/admin/login/', name: 'admin.login', component: Login, meta: { title: 'Admin Login', requiresAdminAuth: true } },
    { path: '/admin/dashboard/', name: 'admin.dashboard', component: AdminDashboard, meta: { title: 'Admin Dashboard', requiresAdminAuth: false } },
    { path: '/admin/merchant/', name: 'admin.merchant', component: AdminMerchant, meta: { title: 'Merchant Listing', requiresAdminAuth: false } },
    { path: '/admin/merchant-pending/', name: 'admin.merchant-pending', component: AdminMerchantPending, meta: { title: 'Merchant Pending', requiresAdminAuth: false } },
    { path: '/admin/merchant/register', name: 'admin.merchant.register', component: AdminMerchantForm, meta: { title: 'Merchant Register', requiresAdminAuth: false } },
    { path: '/admin/merchant/:id/edit', name: 'admin.merchant.edit', component: AdminMerchantForm, meta: { title: 'Merchant Update', requiresAdminAuth: false } },
    { path: '/admin/merchant/archive', name: 'admin.merchant.archive', component: AdminMerchantArchive, meta: { title: 'Merchant Archive', requiresAdminAuth: false } },
    

    { path: '/admin/influencer/', name: 'admin.influencer', component: AdminInfluencer, meta: { title: 'Influencer List', requiresAdminAuth: false } },
    { path: '/admin/influencer-pending/', name: 'admin.influencer-pending', component: AdminInfluencerPending, meta: { title: 'Influencer Pending', requiresAdminAuth: false } },
    { path: '/admin/influencer/register', name: 'admin.influencer.register', component: AdminInfluencerForm, meta: { title: 'Influencer Register', requiresAdminAuth: false } },
    { path: '/admin/influencer/:id/edit', name: 'admin.influencer.edit', component: AdminInfluencerForm, meta: { title: 'Influencer Update', requiresAdminAuth: false } },
    { path: '/admin/influencer/archive', name: 'admin.influencer.archive', component: AdminInfluencerArchive, meta: { title: 'Influencer Archive', requiresAdminAuth: false } },
    
    { path: '/admin/tripidkard/', name: 'admin.tripidkard', component: AdminTripidkard, meta: { title: 'Tripidkard List', requiresAdminAuth: false } },
    { path: '/admin/tripidkard/register', name: 'admin.tripidkard.register', component: AdminTripidkardForm, meta: { title: 'Tripidkard Register', requiresAdminAuth: false } },
    { path: '/admin/customer/', name: 'admin.customer', component: AdminCustomer, meta: { title: 'Customer List', requiresAdminAuth: false } },
    { path: '/admin/customer/register', name: 'admin.customer.register', component: AdminCustomerForm, meta: { title: 'Customer Register', requiresAdminAuth: false } },
    { path: '/admin/customer/:id/edit', name: 'admin.customer.edit', component: AdminCustomerForm, meta: { title: 'Customer Update', requiresAdminAuth: false } },
    { path: '/admin/loyalty-stars', name: 'admin.loyalty-stars', component: AdminLoyaltyPoint, meta: { title: 'Loyalty Stars List', requiresAdminAuth: false } },
    { path: '/admin/loyalty-stars/register', name: 'admin.loyalty-stars.register', component: AdminLoyaltyStarForm, meta: { title: 'Loyalty Stars Register', requiresAdminAuth: false } },
    { path: '/admin/loyalty-stars/:id/edit', name: 'admin.loyalty-stars.edit', component: AdminLoyaltyStarForm, meta: { title: 'Loyalty Stars Update', requiresAdminAuth: false } },
    { path: '/admin/stars/register', name: 'admin.stars.register', component: AdminStarForm, meta: { title: 'Total of Loyalty Stars', requiresAdminAuth: false } },
    { path: '/admin/loyalty-stars/:id/customer', name: 'admin.loyalty-stars.customer', component: AdminCustomerStars, meta: { title: 'Customer Loyalty Stars List', requiresAdminAuth: false } },
    { path: '/admin/activity-log/', name: 'admin.activity-log', component: AdminLogs, meta: { title: 'Activity Logs List', requiresAdminAuth: false } }
];

const routesMerchant = [
    { path: '/merchant/dashboard', name: 'merchant.dashboard', component: MerchantDashboard, meta: { title: 'Merchant Dashboard', requiresMerchantAuth: false } },
    { path: '/merchant/scanner', name: 'merchant.scanner', component: MerchantScanner, meta: { title: 'Merchant QR', requiresMerchantAuth: false } },
    { path: '/merchant/tripidkard/', name: 'merchant.tripidkard', component: MerchantTripidkard, meta: { title: 'Tripidkard List', requiresMerchantAuth: false } },
    { path: '/merchant/customer/', name: 'merchant.customer', component: MerchantCustomer, meta: { title: 'Customer List', requiresMerchantAuth: false } },
    { path: '/merchant/customer/register', name: 'merchant.customer.register', component: MerchantCustomerForm, meta: { title: 'Customer Register', requiresMerchantAuth: false } },
    { path: '/merchant/customer/:id/edit', name: 'merchant.customer.edit', component: MerchantCustomerForm, meta: { title: 'Customer Update', requiresMerchantAuth: false } },
    { path: '/merchant/customer/:card_number/scan', name: 'merchant.customer.scan', component: MerchantCustomerForm, meta: { title: 'Customer Register', requiresMerchantAuth: false } },
    { path: '/merchant/loyalty-stars', name: 'merchant.loyalty-stars', component: MerchantLoyaltyPoint, meta: { title: 'Loyalty Stars List', requiresMerchantAuth: false } },
    { path: '/merchant/loyalty-stars/register', name: 'merchant.loyalty-stars.register', component: MerchantStarsPointForm, meta: { title: 'Loyalty Stars Register', requiresMerchantAuth: false } },
    { path: '/merchant/loyalty-stars/:card_number/register', name: 'merchant.loyalty-stars.scan', component: MerchantStarsPointForm, meta: { title: 'Loyalty Stars Register', requiresMerchantAuth: false } },
    { path: '/merchant/loyalty-stars/:id/edit', name: 'merchant.loyalty-stars.edit', component: MerchantStarsPointForm, meta: { title: 'Loyalty Stars Update', requiresMerchantAuth: false } },
    { path: '/merchant/activity-log/', name: 'merchant.activity-log', component: MerchantLogs, meta: { title: 'Activity Logs List', requiresMerchantAuth: false } },
    { path: '/merchant/profile/', name: 'merchant.profile', component: Profile, meta: { title: 'Merchant Profile Information', requiresMerchantAuth: false } },
    { path: '/merchant/orders/', name: 'merchant.order', component: Ordes, meta: { title: 'Merchant Orders', requiresMerchantAuth: false } },
    { path: '/merchant/orderlist/', name: 'merchant.orderlist', component: OrdeLists, meta: { title: 'Merchant Orders List', requiresMerchantAuth: false } }
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
    { path: '/scanner/', name: 'scanner', component: Scanner, meta: { title: 'Card Scanner' } },
    { path: '/customer/information/:cardNumber', name: 'customer.information', component: ScannerResult, meta: { title: 'Customer Information' } },

    { path: '/login/', name: 'login', component: Login, meta: { title: 'User Login', requiresGuest: true, } },
    { path: '/forgot-password/', name: 'forgot-password', component: ForgotPassword, meta: { title: 'Forgot Password', requiresGuest: true, } },
    { path: '/tripidkard/', name: 'tripidkard', component: TripidkardDetails, meta: { title: 'Tripidkard', requiresGuest: true, } },

    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound, meta: { title: 'Not Found' } }
];

export { routesAdmin, routesMerchant, routesDefault };
