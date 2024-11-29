<template>
    <div>
      <MobileSearch />

      <!-- Navigation bar for larger screens -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top d-none d-md-flex">
        <div class="container">
          <!-- Logo aligned to the left -->
          <router-link class="navbar-brand" to="/">
            <img class="img-fluid" src="/storage/img/logo.jpg" alt="Tripidkard" width="100" />
          </router-link>

          <!-- Navigation links aligned to the right -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <NavItem to="/" label="Home" />
              <NavItem to="/tripidkard/details" label="Tripidkard" />
              <NavItem to="/join" label="How To Join" />
              <NavItem to="/scanner" label="Scanner" />
              <NavItem to="/merchants" label="Merchants" />
              <NavItem to="/contact-us" label="Contact" />

              <!-- Conditional button for login or dashboard -->
              <NavItem v-if="isLoggedIn" to="/login" label="Dashboard" textClass="btn btn-primary font-weight-bold text-uppercase bg-primary" />
              <NavItem v-else to="/login" label="Merchant Login" textClass="btn btn-primary font-weight-bold text-uppercase bg-primary" />
            </ul>
          </div>
        </div>
      </nav>

      <!-- Use the mobile footer -->
      <MobileFooter />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import MobileFooter from '@/components/MobileFooter.vue';
  import MobileSearch from '@/components/MobileSearch.vue';
  import { useAuthStore } from '@/stores/auth';

  const authStore = useAuthStore();
  const isLoggedIn = ref(authStore.isAuthenticated);


    // Component for navigation items
    const NavItem = defineComponent({
    props: {
      to: String,
      label: String,
      textClass: {
        type: String,
        default: 'text-dark text-uppercase',
      },
    },
    template: `
      <li class="nav-item">
        <router-link :class="['nav-link', textClass]" :to="to">{{ label }}</router-link>
      </li>
    `,
  });
  </script>
