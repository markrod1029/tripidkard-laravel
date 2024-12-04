<!-- YourMainComponent.vue -->

<template>
    <div>
        <MenuBar />
        <Banner />
        <Search  class="mobile-search"/>
        <Merchant />
        <Footer />

        <!-- Include the modal subscription component -->
        <!-- <ModalSubscription /> -->
    </div>
</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Merchant/Banner.vue';
import Search from '@/Components/Molecules/Search/ProvinceSearch.vue';
import Merchant from '@/Pages/Home/Merchant/Merchant.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';

// Import the modal subscription component
import ModalSubscription from '@/Pages/Home/Merchant/ModalSubscription.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {
    components: {
        MenuBar,
        Banner,
        Search,
        Merchant,
        Footer,
        // Register the modal subscription component
        ModalSubscription,
    },

    setup() {
        const authStore = useAuthStore();
        onMounted(async () => {
            await authStore.getUser();
        });
    },
};



</script>

<style scoped>
/* Mobile View (For smaller screens) */
@media (max-width: 768px) {
    .mobile-search {
       display:none;

    }

}



</style>
