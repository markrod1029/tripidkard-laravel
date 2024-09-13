<script setup>
import { useAuthUserStore } from '../../../Stores/AuthUser';
import { ref } from 'vue';

// Fetching auth user data
const authUser = useAuthUserStore();

// Sidebar menu items
const menuItems = ref([
  {
    header: "PERSONAL",
    items: [
      {
        title: "Dashboard",
        icon: "fa fa-tachometer",
        route: "/merchant/dashboard",
      },
      {
        title: "QR Code Scanner",
        icon: "fa fa-qrcode",
        route: "/merchant/scanner",
      },
      {
        title: "Order Card",
        icon: "fas fa-coins",
        children: [
          { title: "Order Cards List", icon: "far fa-circle", route: "/merchant/loyalty-stars" },
          { title: "Order cards", icon: "far fa-circle", route: "/merchant/orders" },
        ],
      },
      {
        title: "TripidKard Code",
        icon: "fas fa-credit-card",
        children: [
          { title: "TripidKard List", icon: "far fa-circle", route: "/merchant/tripidkard" },
        ],
      },
      {
        title: "Customer Account",
        icon: "fas fa-users",
        children: [
          { title: "Customer List", icon: "far fa-circle", route: "/merchant/customer" },
          { title: "Customer Register", icon: "far fa-circle", route: "/merchant/customer/register" },
        ],
      },
      {
        title: "Loyalty Stars",
        icon: "fas fa-coins",
        children: [
          { title: "Loyalty Stars List", icon: "far fa-circle", route: "/merchant/loyalty-stars" },
          { title: "Register Loyalty Stars", icon: "far fa-circle", route: "/merchant/loyalty-stars/register" },
        ],
      },
      {
        title: "Activity Logs",
        icon: "fa fa-coins",
        route: "/merchant/activity-log",
      },
    ],
  },
]);
</script>

<template>
  <aside class="main-sidebar sidebar-dark-primary">
    <a href="home" class="brand-link" style="border-style:none; height:70px;">
      <img src="https://tripidkard.com/wp-content/uploads/2023/10/cropped-tripid-card-ver.-2-1.png" alt="Logo"
        class="img-circle" style="height:50px;">
      <span class="brand-text font-weight-light text-center">Tripidkard</span>
    </a>
    <div class="sidebar">
      <div class="user-panel d-flex">
        <div class="image" style="position:relative; right:10px;">
          <img :src="authUser.users.avatar || 'https://via.placeholder.com/640x360'" class="img-circle elevation-2"
            alt="User Image" style="height:55px; width:55px; margin-top:10px">
        </div>
        <div class="info">
          <a href="#" class="d-block mt-1 mb-0 text-white text-center">{{ authUser.users.fname }} {{ authUser.users.mname
            }} {{ authUser.users.lname }}</a>
          <a href="#" class="d-block text-white ml-2 text-center mb-2">{{ authUser.users.role }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li v-for="(section, index) in menuItems" :key="index">
            <li class="header text-center brand-text text-white">{{ section.header }}</li>
            <li v-for="(item, idx) in section.items" :key="idx" :class="['nav-item', item.children ? 'has-treeview' : '']">
              <router-link :to="item.route || '#'" class="nav-link" :class="{ active: item.route === $route.path }">
                <i :class="['nav-icon', item.icon]"></i>
                <p>
                  {{ item.title }}
                  <i v-if="item.children" class="right fas fa-angle-left"></i>
                </p>
              </router-link>
              <ul v-if="item.children" class="nav nav-treeview">
                <li v-for="(child, childIdx) in item.children" :key="childIdx" class="nav-item">
                  <router-link :to="child.route" :class="{ active: child.route === $route.path }" class="nav-link">
                    <i :class="['nav-icon', child.icon]"></i>
                    <p>{{ child.title }}</p>
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

<style>
.main-sidebar {
  background-color: #367fa9;
  height: 100vh !important;
  margin-bottom: 100px;
}

.main-sidebar,
.main-sidebar::before {
  transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
  width: 290px;
  position: fixed !important;
}

.sidebar {
  height: calc(100% - (3.5rem + 1px));
  overflow-y: auto;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  padding-top: 0;
  background-color: #367fa9;
  font-size: large;
}

.user-panel {
  background-image: url('https://tripidkard.com/wp-content/uploads/2023/11/bg.jpg');
  background-repeat: no-repeat;
  background-position: center;
  width: 100%;
  padding-top: 20px;
  padding-bottom: 20px;
  color: black;
  margin-top: 22px;
}

.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
  background-color: #222D32;
  color: #fff;
}

[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active {
  background-color: #222D32;
  color: #fff;
}
</style>
