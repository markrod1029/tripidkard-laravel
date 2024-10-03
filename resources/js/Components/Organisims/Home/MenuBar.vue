<template>
    <div>
      <!-- Navigation bar -->
      <nav
        class="navbar navbar-expand-lg navbar-dark bg-light fixed-top"
        style="height: 12vh; font-family: Poppins, sans-serif; font-size: 15px; font-weight: bold; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);"
      >
        <div class="container">
          <!-- Logo aligned to the left -->
          <router-link class="navbar-brand" to="/">
            <img
            src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/399434519_122118450656079042_7601433698559540672_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFganLRFe4as7VGZgSGFL4uCAaG5sSOyxIIBobmxI7LEpL9o-leIwHBfb0dSo2CXZiUCtiVG_p7pmpGcYIQ4OZx&_nc_ohc=fIS2l5CxTpwQ7kNvgH9L8SL&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=AUjxSbhVWXS-o7UA-ODF9u2&oh=00_AYASz3J_BFL74bIZIoz4YhnNKxkZDcSMkj_D-5XtefAskQ&oe=6702BB2C"
              alt="Tripidkard"
              width="100"
            />
          </router-link>

          <!-- Toggle button aligned to the right -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navigation links aligned to the right -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <NavItem to="/" label="Home" />
              <NavItem to="/tripidkard" label="Tripidkard" />
              <NavItem to="/join" label="How To Join" />
              <NavItem to="/scanner" label="Scanner" />
              <NavItem to="/merchants" label="Merchants" />
              <NavItem to="/contact-us" label="Contact" />
              <NavItem
                to="/login"
                label="Merchant Login"
                textClass="btn btn-primary font-weight-bold text-uppercase bg-primary"
              />
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </template>

  <script setup>
  // Define a reusable NavItem component within the same file
  import { defineComponent, defineProps } from 'vue';

  // Local NavItem component definition
  const NavItem = defineComponent({
    props: {
      to: {
        type: String,
        required: true,
      },
      label: {
        type: String,
        required: true,
      },
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
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
  }

  .navbar-nav .nav-item {
    margin-left: 10px;
  }
  </style>
