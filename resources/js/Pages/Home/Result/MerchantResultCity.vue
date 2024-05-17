<!-- YourMainComponent.vue -->

<template>
    <div>
      <MenuBar/>
      <Banner/>
      <!-- <Search/> -->
      <Merchant/>
      <Footer/>

      <!-- Include the modal subscription component -->
    </div>
  </template>

  <script>
  import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
  import Banner from '@//Pages/Home/Result/Banner.vue';
  import Merchant from '@/Pages/Home/Merchant/Merchant.vue';
import Search from '@/Components/Molecules/Search/CitySearch.vue';

  import Footer from '@/Components/Organisims/Home/Footer.vue';


  export default {
    components: {
      MenuBar,
      Banner,
      Search,
      Merchant,
      Footer,
    },
  };
  </script>

  <style scoped>
  /* Add your component-specific styles here */
  </style>
