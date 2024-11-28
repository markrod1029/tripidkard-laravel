<template>
    <!-- Footer menu for mobile screens -->
    <footer class="mobile-footer d-flex d-md-none fixed-bottom bg-light">
      <button class="btn btn-light" aria-label="Search">
        <span class="fa fa-search text-primary"></span>
      </button>
      <button class="btn btn-light" @click="navigateToLogin" aria-label="Login">
        <span class="fa fa-user text-primary"></span>
      </button>
      <button class="btn btn-light" @click="toggleModal" aria-label="Menu">
        <span :class="showModal ? 'fa fa-times text-primary' : 'fa fa-bars text-primary'"></span>
      </button>
    </footer>

    <!-- Modal (Mobile Menu Style) -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <ul class="menu-list">
              <!-- List items as menu options -->
              <li class="menu-item" @click="closeModal"><router-link to="/">Home</router-link></li>
              <li class="menu-item" @click="closeModal"><router-link to="/tripidkard/details">Tripidkard</router-link></li>
              <li class="menu-item" @click="closeModal"><router-link to="/join">How To Join</router-link></li>
              <li class="menu-item" @click="closeModal"><router-link to="/scanner">Scanner</router-link></li>
              <li class="menu-item" @click="closeModal"><router-link to="/merchants">Merchants</router-link></li>
              <li class="menu-item" @click="closeModal"><router-link to="/contact-us">Contact</router-link></li>

              <!-- Conditional button for login or dashboard -->
              <li class="menu-item" @click="closeModal">
                <router-link :to="isLoggedIn ? '/login' : '/login'" class="btn btn-primary text-uppercase text-white">
                  {{ isLoggedIn ? 'Dashboard' : 'Merchant Login' }}
                </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const showModal = ref(false);

  const toggleModal = () => (showModal.value = !showModal.value);
  const closeModal = () => (showModal.value = false);
  const navigateToLogin = () => (window.location.href = '/login');



  const isLoggedIn = ref(false); // Set based on your authentication logic
  </script>

  <style scoped>
  .mobile-footer {
    border-top-left-radius: 25%;
    border-top-right-radius: 25%;
    justify-content: space-around;
    padding: 10px 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    border-top: 2px solid #ddd; /* Adjust thickness and color */
  }

  .modal-overlay {
    position: fixed;
    left: 0;
    width: 100%;
    height: 100%;
    height: calc(100% - 0px); /* Adjust to full height minus navbar height */
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    z-index: 1;
    transition: opacity 0.3s ease;
  }

  .modal-dialog {
    width: 100%;
    height: 100%;
    margin: 0;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }

  .modal-overlay .modal-dialog {
    transform: translateX(0);
  }

  .modal-content {
    width: 100%;
    height: 100%;
    background-color: white;
    padding: 0;
    overflow-y: auto;
  }

  .menu-list {
    list-style: none;
    margin: 0;
    padding: 20px;
  }

  .menu-item {
    padding: 15px;
    font-size: 20px;
    border-bottom: 1px solid #ddd;
  }

  .menu-item a {
    color: #333;
    text-decoration: none;
    display: block;
    padding: 10px;
    font-weight: bold;
  }

  .menu-item:hover {
    background-color: #f1f1f1;
  }
  </style>
