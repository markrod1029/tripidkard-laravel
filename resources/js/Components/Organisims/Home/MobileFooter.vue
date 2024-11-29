<template>
    <!-- Footer menu for mobile screens -->
    <footer :class="['mobile-footer', showModal || showSearch ? 'no-radius' : '' ]" class="d-flex d-md-none fixed-bottom bg-light">
      <button class="btn btn-light" @click="toggleSearch" aria-label="Search">
        <span :class="showSearch ? 'fa fa-times text-primary' : 'fa fa-search text-primary'"></span>
      </button>
      <button class="btn btn-light" @click="navigateToLogin" aria-label="Login">
        <span class="fa fa-user text-primary"></span>
      </button>
      <button class="btn btn-light" @click="toggleModal" aria-label="Menu">
        <span :class="showModal ? 'fa fa-times text-primary' : 'fa fa-bars text-primary'"></span>
      </button>
    </footer>

    <!-- Search Modal -->
    <div v-if="showSearch" class="modal-overlay">
      <div class="modal-dialog-search">
        <div class="modal-content-search">
          <div class="modal-body">
            <h5 class="text-primary mb-3 mx-5">Search Merchant</h5>

            <!-- Filter Dropdown -->
            <div class="mb-3">
              <select v-model="filterOption" class="form-select">
                <option value="">All</option>
                <option value="merchants">Merchants</option>
                <option value="tripidkard">Tripidkard</option>
              </select>
            </div>

            <!-- Search Input with Icon -->
            <div class="input-group mb-3">
              <input
                type="text"
                v-model="searchQuery"
                placeholder="Search..."
                class="form-control"
              />
              <button class="btn btn-primary" @click="applySearch">
                <span class="fa fa-search"></span>
              </button>
            </div>

            <!-- Search Button -->
            <button class="btn btn-primary w-100 mt-3" @click="applySearch">
              Search
            </button>
          </div>
        </div>
      </div>
    </div>

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
  import { ref } from "vue";

  const showModal = ref(false);
  const showSearch = ref(false);

  // Search and filter states
  const searchQuery = ref("");
  const filterOption = ref("");

  // Toggle modals and close the other when one is opened
  const toggleModal = () => {
    showModal.value = !showModal.value;
    if (showModal.value) showSearch.value = false;  // Close search modal when menu modal opens
  };

  const closeModal = () => {
    showModal.value = false;
    showSearch.value = false;
  };

  const toggleSearch = () => {
    showSearch.value = !showSearch.value;
    if (showSearch.value) showModal.value = false;  // Close menu modal when search modal opens
  };

  const navigateToLogin = () => (window.location.href = "/login");

  // Dummy methods
  const applySearch = () => {
    console.log("Search Query:", searchQuery.value);
    console.log("Filter Option:", filterOption.value);
    showSearch.value = false;
  };

  const isLoggedIn = ref(false); // Set based on your authentication logic
  </script>

  <style scoped>
  /* Debugging Outline */

  /* Updated Mobile Footer Styles */
  .mobile-footer {
    border-radius: 25px; /* Properly rounded corners */
    justify-content: space-around;
    padding: 10px 0;
    margin: 10px auto; /* Center it */
    width: calc(100% - 20px); /* Ensure spacing from screen edges */
    background-color: #fff; /* Background color */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), /* Shadow at bottom */
                0 -4px 6px rgba(0, 0, 0, 0.1), /* Shadow at top */
                4px 0 6px rgba(0, 0, 0, 0.1),  /* Shadow at right */
               -4px 0 6px rgba(0, 0, 0, 0.1);  /* Shadow at left */
    border-top: 2px solid #ddd; /* Optional for a slight border effect */
  }

  /* Remove border-radius when modal is open */
  .no-radius {
    border-radius: 0 !important; /* Override border-radius */
    width: calc(100% - 0px); /* Ensure spacing from screen edges */
    margin: auto; /* Center it */

  }

  /* Modal Overlay */
  .modal-overlay {
    position: fixed;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    transition: opacity 0.3s ease;
  }

  /* search Modal */
  .modal-dialog-search {
    width: 90%;
    max-width: 400px;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
  }

  .modal-content-search {
    padding: 20px;
  }

  .input-group {
    display: flex;
    align-items: stretch;
  }

  .input-group .form-control {
    border-right: none;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  /* Menubar Modal */
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
