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
            // Merchant Route
            {
                title: 'Merchant Account',
                icon: 'fas fa-coins',
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
                icon: 'fas fa-coins',
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

const route = useRoute();

const isRouteActive = (item) => {
    return item.route === route.path || item.children?.some(child => child.route === route.path);
}
</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary">
        <a href="home" class="brand-link" style="border-style:none; height:70px;">
            <img src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/399434519_122118450656079042_7601433698559540672_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFganLRFe4as7VGZgSGFL4uCAaG5sSOyxIIBobmxI7LEpL9o-leIwHBfb0dSo2CXZiUCtiVG_p7pmpGcYIQ4OZx&_nc_ohc=fIS2l5CxTpwQ7kNvgH9L8SL&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=AUjxSbhVWXS-o7UA-ODF9u2&oh=00_AYASz3J_BFL74bIZIoz4YhnNKxkZDcSMkj_D-5XtefAskQ&oe=6702BB2C"
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
