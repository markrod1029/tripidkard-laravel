<template>
    <!-- Header with Search Bar (Mobile View) -->
    <header class="mobile-header d-flex d-md-none fixed-top bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-10">
            <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
          </div>
          <div class="col-2 text-end">
            <button class="btn btn-light" aria-label="Search">
              <span class="fa fa-search text-primary"></span>
            </button>
          </div>
        </div>
      </div>
    </header>



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
  .mobile-header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;  /* Ensure it's on top of other elements */
    background-color: #fff;
    padding: 10px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  </style>
