<script setup>
import { useAuthUserStore } from '../../../Stores/AuthUser';
import { ref } from 'vue';
import { useRoute } from 'vue-router'; // Import useRoute
import '@css/sidebar.css';


// Fetching auth user data
const authUser = useAuthUserStore();

// Sidebar menu items
const menuItems = ref([
    {
        header: 'PERSONAL',
        items: [
            {
                title: 'Dashboard',
                icon: 'fa fa-home',
                route: '/admin/dashboard',
            },
            {
                title: 'QR Code Scanner',
                icon: 'fa fa-qrcode',
                route: '/admin/scanner',
            },

              // Order Route
              {
                title: 'Orders',
                icon: 'fas fa-shopping-cart',
                children: [
                    { title: 'Order Point List', icon: 'far fa-circle', route: '/admin/order-point/list' },
                ],
            },

            // Merchant Route
            {
                title: 'Merchant Account',
                icon: 'fas fa-users',
                children: [
                    { title: 'Merchant Pending', icon: 'far fa-circle', route: '/admin/merchant-pending' },
                    { title: 'Merchant Listing', icon: 'far fa-circle', route: '/admin/merchant' },
                    { title: 'Merchant Archive', icon: 'far fa-circle', route: '/admin/merchant/archive' },
                    { title: 'Merchant Register', icon: 'far fa-circle', route: '/admin/merchant/register' },
                ],
            },


            // Influencer Route
            {
                title: 'Influencer Account',
                icon: 'fas fa-users',
                children: [
                    { title: 'Influencer Pending', icon: 'far fa-circle', route: '/admin/influencer-pending' },
                    { title: 'Influencer Listing', icon: 'far fa-circle', route: '/admin/influencer' },
                    { title: 'Influencer Archive', icon: 'far fa-circle', route: '/admin/influencer/archive' },
                    { title: 'Influencer Register', icon: 'far fa-circle', route: '/admin/influencer/register' },
                ],
            },
            // TripidKard Route
            {
                title: 'TripidKard Code',
                icon: 'fas fa-credit-card',
                children: [
                    { title: 'TripidKard List', icon: 'far fa-circle', route: '/admin/tripidkard' },
                    { title: 'TripidKard Register', icon: 'far fa-circle', route: '/admin/tripidkard/register' },
                ],
            },
            // Customer Route
            {
                title: 'Customer Account',
                icon: 'fas fa-users',
                children: [
                    { title: 'Customer List', icon: 'far fa-circle', route: '/admin/customer' },
                    { title: 'Customer Register', icon: 'far fa-circle', route: '/admin/customer/register' },
                ],
            },
            // Loyalty Route
            {
                title: 'Loyalty Stars ',
                icon: 'fas fa-coins',
                children: [
                    { title: 'Loyalty Stars List', icon: 'far fa-circle', route: '/admin/loyalty-stars' },
                    { title: 'Total of Loyalty Stars', icon: 'far fa-circle', route: '/admin/stars/register' },
                    { title: 'Register Loyalty Stars', icon: 'far fa-circle', route: '/admin/loyalty-stars/register' },
                ],
            },
            {
                title: 'Activity Logs',
                icon: 'fa fa-coins',
                route: '/admin/activity-log',
            },
        ],
    },
]);

const fetchCounts = async () => {
    try {
        const merchantResponse = await axios.get('/api/merchants/count');
        merchantCount.value = merchantResponse.data.count;

        const influencerResponse = await axios.get('/api/influencers/count');
        influencerCount.value = influencerResponse.data.count;
    } catch (error) {
        console.error('Error fetching counts:', error);
    }
};

const route = useRoute();

const isRouteActive = (item) => {
    return item.route === route.path || item.children?.some(child => child.route === route.path);
}
</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary">
        <a href="home" class="brand-link" style="border-style:none; height:70px;">
            <img src="/storage/img/logo.jpg"
                alt="Logo" class="img-circle" style="height:50px;">
            <span class="brand-text font-weight-light text-center">Tripidkard</span>
        </a>
        <div class="sidebar">
            <div class="user-panel d-flex">
                <div class="image" style="position:relative; right:10px;">
                    <img :src="authUser.users.avatar || '/storage/img/logo.jpg'" class="img-circle elevation-2"
                        alt="User Image" style="height:55px; width:55px; margin-top:10px" />
                </div>
                <div class="info">
                    <a href="#" class="d-block mt-1 mb-0 text-white text-center">{{ authUser.users.fname }} {{
                        authUser.users.mname
                    }} {{ authUser.users.lname }}</a>
                    <a href="#" class="d-block text-white ml-2 text-center mb-2">{{ authUser.users.role }}</a>
                </div>
            </div>

            <nav class="mt-2 mb-2 ">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li v-for="(section, index) in menuItems" :key="index">
                    <li class="header text-center brand-text text-white">{{ section.header }}</li>
                    <li v-for="(item, idx) in section.items" :key="idx"
                        :class="['nav-item', item.children ? 'has-treeview' : '', isRouteActive(item) ? 'menu-is-opening menu-open' : '']">
                        <router-link :to="item.route || '#'" class="nav-link" :class="{ active: isRouteActive(item) }">
                            <i :class="['nav-icon', item.icon]"></i>
                            <p class="ms-2">
                                {{ item.title }}

                                <i v-if="item.children" class="right fas fa-angle-left"></i>
                            </p>
                        </router-link>
                        <ul v-if="item.children" class="nav nav-treeview">
                            <li v-for="(child, childIdx) in item.children" :key="childIdx" class="nav-item">
                                <router-link :to="child.route" :class="{ active: child.route === route.path }"
                                    class="nav-link">
                                    <i :class="['nav-icon', child.icon]"></i>
                                    <p class="ms-2">{{ child.title }}</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
