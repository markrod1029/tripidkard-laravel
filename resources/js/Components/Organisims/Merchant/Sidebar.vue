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
        icon: "fa fa-home",
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
          { title: "Order Cards List", icon: "far fa-circle", route: "/merchant/orderlist/" },
          { title: "Order Cards", icon: "far fa-circle", route: "/merchant/order/cards" },
          { title: "Order Star Points", icon: "far fa-circle", route: "/merchant/order/points" },
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
            <img src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/399434519_122118450656079042_7601433698559540672_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFganLRFe4as7VGZgSGFL4uCAaG5sSOyxIIBobmxI7LEpL9o-leIwHBfb0dSo2CXZiUCtiVG_p7pmpGcYIQ4OZx&_nc_ohc=ciZu2eLfLtEQ7kNvgFULvi-&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=AmYW0fjwy3v3H-PJAlOVj5D&oh=00_AYDvnNWYNVKIzPTAMYFph7JeCjZIeVEyuXvVp1y_UoCU_g&oe=670D0EEC"
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
          <a href="#" class="d-block mt-1 mb-0 text-white text-center">{{ useAuthUserStore.users.fname }} {{ authUser.users.mname
            }} {{ authUser.users.lname }}</a>
          <a href="#" class="d-block text-white ml-2 text-center mb-2">{{ useAuthUserStore.users.role }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li v-for="(section, index) in menuItems" :key="index">
            <li class="header text-center brand-text text-white">{{ section.header }}</li>
            <li v-for="(item, idx) in section.items" :key="idx" :class="['nav-item', item.children ? 'has-treeview' : '']">
              <router-link :to="item.route || '#'" class="nav-link" :class="{ active: item.route === $route.path }">
                <i :class="['nav-icon', item.icon]" ></i>
                <p class="ms-2">
                  {{ item.title }}
                  <i v-if="item.children" class="right fas fa-angle-left"></i>
                </p>
              </router-link>
              <ul v-if="item.children" class="nav nav-treeview">
                <li v-for="(child, childIdx) in item.children" :key="childIdx" class="nav-item">
                  <router-link :to="child.route" :class="{ active: child.route === $route.path }" class="nav-link">
                    <i :class="['nav-icon', child.icon]" ></i>
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
    ;
}

.sidebar-mini .main-sidebar .nav-link,
.sidebar-mini-md .main-sidebar .nav-link,
.sidebar-mini-xs .main-sidebar .nav-link {
    width: calc(290px - 0.5rem* 2);
    transition: width ease-in-out 0.3s;
}


.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: #fff;
    background-color: #000000;
}

.layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
    background-color: #367fa9;

}

.layout-top-nav .wrapper .main-header .brand-image {
    margin-top: -1.5rem;
    margin-right: 1.2rem;
    height: 133px;
}


.main-header {
    -webkit-transition: width 0.3s ease-in-out;
    -o-transition: width 0.3s ease-in-out;
    transition: width 0.3s ease-in-out;
    height: 80px;
    font-size: 22px;
    line-height: 20px;
    text-align: center;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    padding: 0 15px;
    font-weight: 300;

}

.sidebar {
    height: calc(100% - (3.5rem + 1px));
    overflow-y: auto;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    padding-top: 0;
    background-color: #367fa9;
    height: 100vh;
    margin-bottom: 100px;
    font-size: large;
}

@media (min-width: 768px) {

    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
        transition: margin-left 0.3s ease-in-out;
        margin-left: 290px;
    }
}


.user-panel {
    background-image: url('https://tripidkard.com/wp-content/uploads/2023/11/bg.jpg');
    background-repeat: no-repeat;
    background-position: center;
    position: relative;
    /* background: url(../images/background.png) center no-repeat; */
    width: 100%;
    padding-top: 20px;
    padding-bottom: 20px;
    overflow: hidden;
    color: black;
    margin-top: 22px;

}


/* breadcrumb Title Page */



.content-header {
    position: relative;
    padding-top: 70px;
    padding-left: 0;
    padding-right: 0;
    padding-bottom: 10px;
    background-color: #F5F5F5;

}

.content-header>h1 {
    margin: 0;
    font-size: 15px;
}

.content-header>h1>small {
    display: inline-block;
    font-weight: 300;
    padding-left: 110px;

}

.content-header>.breadcrumb {
    padding-left: 10px;
    background: transparent;
    margin-top: 0;
    margin-bottom: 0;
    font-size: 12px;
    padding: 7px 5px;
    position: absolute;
    top: 15px;
    right: 10px;
    border-radius: 2px;
}

.breadcrumb {
    list-style: none;
    border-radius: 4px;
    background-color: white;
    padding-top: 0;
}


.add {
    position: absolute;
    top: 20px;
    right: 20px;
}

.dashboard {
    padding-left: 20px;
    font-size: 24px;
}

.content-header>.breadcrumb>li>a {
    text-decoration: none;
    display: inline-block;
}

.content-header>.breadcrumb>li>a>.fa,
.content-header>.breadcrumb>li>a>.glyphicon,
.content-header>.breadcrumb>li>a>.ion {
    margin-right: 5px;
}

.content-header>.breadcrumb>li+li:before {
    content: '>\00a0';
}

@media (max-width: 991px) {
    .content-header {
        position: relative;
        padding-top: 110px;
        padding-left: 0;
        padding-right: 0;

    }

    .content-header>.breadcrumb {
        position: relative;
        margin-top: 5px;
        top: 0;
        right: 0;
        float: none;
        background: #d2d6de;
        padding-left: 10px;
    }

    .content-header>.breadcrumb li:before {
        color: #97a0b3;
    }
}


/* sidebar Active */
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
.sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #000000;
    color: #fff;
}

.nav-link:hover {
    background-color: #FFFFFF;
    color: #fff;
}


[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus,
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
    background-color: #000000;
    color: #fff;
}
</style>

<!-- <style>
@media (max-width: 667px){
.input-group label {
    text-align: left;
    width: 100%;
    margin-bottom: 5px;
    text-align: left !important;
}
}










.user-panel .info {
  display: inline-block;
  padding:0;
}


.con{
  height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
  margin-top:20px;
}
.con::-webkit-scrollbar-track
{
	background-color:#367FA9;
  height:10px;

}
.con:hover::-webkit-scrollbar
{
  display: block;
  height:10px;

}
.con::-webkit-scrollbar
{
	width: 6px;
	background-color: #367FA9;
  display:none;
  height:10px;


}

.con::-webkit-scrollbar-thumb
{
	background-color: #C1C7AB;

}



    </style> -->
