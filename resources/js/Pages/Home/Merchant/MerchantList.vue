<!-- YourMainComponent.vue -->

<template>
    <div>
      <MenuBar/>
      <Banner/>
      <Merchant/>
      <Footer/>

      <!-- Include the modal subscription component -->
      <ModalSubscription/>
    </div>
  </template>

  <script>
  import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
  import Banner from '@//Pages/Home/Merchant/Banner.vue';
  import Merchant from '@/Pages/Home/Merchant/Merchant.vue';
  import Footer from '@/Components/Organisims/Home/Footer.vue';

  // Import the modal subscription component
  import ModalSubscription from '@/Pages/Home/Merchant/ModalSubscription.vue';

  export default {
    components: {
      MenuBar,
      Banner,
      Merchant,
      Footer,
      // Register the modal subscription component
      ModalSubscription,
    },
  };
  </script>

  <style scoped>
  /* Add your component-specific styles here */
  </style>
