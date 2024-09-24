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
              src="https://tripidkard.com/wp-content/uploads/2023/10/cropped-tripid-card-ver.-2-1.png"
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
