<template>
    <section id="hero-banner" class="flex items-center justify-center mt-auto relative" style="top: 10px;">
      <div class="mx-auto relative">
        <img src="https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-5528.jpg?w=740&t=st=1712558738~exp=1712559338~hmac=b8207fcb7b3da83ec1a53dd42fafdc3534a0771d6c80ab07b5d4d4b32168741f" class="object-fill tranzinc-x-4 d-flex" width="" height="700" alt="launch application">
        <router-link to="/admin/dashboard" class="floating-button">Click Me</router-link>
      </div>
    </section>
  </template>
  
  <script setup>
  
  </script>
  
  <style scoped>
  /* Dito mo maaaring idagdag ang iyong mga estilo */
  .flex {
    display: flex;
  }
  
  .items-center {
    align-items: center;
  }
  
  .justify-center {
    justify-content: center;
  }
  
  .relative {
    position: relative;
  }
  
  .floating-button {
    position: absolute;
    bottom: 20px; /* Adjust this value to change the distance from the bottom */
    right: 20px; /* Adjust this value to change the distance from the right */
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  </style>
  