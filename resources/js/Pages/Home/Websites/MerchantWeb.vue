<template>
    <MenuBar />
    <Banner :merchant="merchants" />
    <Description :merchant="merchants"  />
    <Map :merchant="merchants" class="mb-5" />

    
    <Footer />
  </template>
  
  <script>
  import { reactive, onMounted } from 'vue';
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
  import Banner from '@/Pages/Home/Websites/Banner.vue';
  import Description from '@/Pages/Home/Websites/Description.vue';
  import Map from '@/Pages/Home/Websites/Map.vue';
  import Footer from '@/Components/Organisims/Home/Footer.vue';
  
  export default {
    components: {
      MenuBar,
      Banner,
      Description,
      Map,
      Footer,
    },
    setup() {
      const merchants = reactive({
        fname: '',
        mname: '',
        lname: '',
        contact: '',
        email: '',
        business_name: '',
        business_category: '',
        business_sub_category: '',
        discount: '',
        zip: '',
        street: '',
        city: '',
        province: '',
        description: '',
        img1: '',
        img2: '',
        img3: '',
      });
  
      const route = useRoute(); // Get the current route
  
      const getMerchants = async () => {
        try {
          const response = await axios.get(`/api/merchants/${route.params.id}/edit`);
          const data = response.data; // Extract data from the response
          merchants.fname = data.user.fname;
          merchants.mname = data.user.mname;
          merchants.lname = data.user.lname;
          merchants.contact = data.user.contact;
          merchants.email = data.user.email;
          merchants.business_name = data.business_name;
          merchants.business_category = data.business_category;
          merchants.business_sub_category = data.business_sub_category;
          merchants.discount = data.discount;
          merchants.zip = data.zip;
          merchants.street = data.street;
          merchants.city = data.city;
          merchants.province = data.province;
          merchants.description = data.description;
          merchants.img1 = data.img1;
          merchants.img2 = data.img2;
          merchants.img3 = data.img3;
        } catch (error) {
          console.error('Error fetching merchant data:', error);
          // Handle the error appropriately
        }
      };
  
      // Fetch merchant data when the component is mounted
      onMounted(() => {
        getMerchants();
      });
  
      return {
        merchants,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Add your component-specific styles here */
  </style>
  