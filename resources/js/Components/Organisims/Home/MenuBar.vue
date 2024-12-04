<template>
    <div>
      <!-- Mobile search component -->

      <!-- Navigation bar for larger screens -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top d-none d-md-flex">
        <div class="container">
          <!-- Logo aligned to the left -->

          <router-link class="navbar-brand" to="/">
            <img class="img-fluid" src="/storage/img/logo.jpg" alt="Tripidkard" width="100" />
          </router-link>

             <!-- Toggle button aligned to the right -->
             <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Bootstrap classes for hiding text on smaller screens -->
            <!-- Font Awesome icon for the toggle button -->
            <span class="fa fa-bars" style="color: black;"></span>
          </button>

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
              <NavItem
                v-if="isLoggedIn"
                to="/dashboard"
                label="Dashboard"
                textClass="btn btn-primary font-weight-bold text-uppercase bg-primary"
              />
              <NavItem
                v-else
                to="/login"
                label="Merchant Login"
                textClass="btn btn-primary font-weight-bold text-uppercase bg-primary"
              />
            </ul>
          </div>
        </div>
      </nav>

      <!-- Mobile footer -->
      <MobileFooter />
    </div>
  </template>

  <script setup>
  import { ref, defineComponent } from 'vue';
  import MobileFooter from '@/components/Organisims/Home/MobileFooter.vue';
  import { useAuthStore } from '@/stores/auth';

  // Access the auth store to check if the user is logged in
  const authStore = useAuthStore();
  const isLoggedIn = ref(authStore.isAuthenticated);

  // Define the NavItem component
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

<style scoped>
@media (min-width: 768px) and (max-width: 991px) {
    /* Your styles for tablet devices here */
}
</style>
