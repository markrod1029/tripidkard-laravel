<template>
    <!-- Desktop View -->
        <MenuBar class="content-components"/>
        <Banner />
        <Search />
        <Raffle />
        <Footer />


    <div class="mobile-only">
        <!-- Content Section for Mobile (MenuBar, Banner, Search, Raffle, Footer) -->

        <div class="content-container">
            <div class="overlay-wrapper">
                <div class="top-section">
                    <div class="text-center mt-3">
                        <img class="img-fluid" src="/storage/img/logo.jpg" alt="TripidKard Logo" width="120"
                            height="120" />
                    </div>
                    <div class="content-mobile text-center">
                        <h1 class="my-3 text-primary fw-bold title">
                            Discover Exclusive Deals, Amazing Discounts, and More with TripidKard
                        </h1>
                        <p class="text-muted sub-title">
                            Whether you're shopping for great deals or a business seeking new customers, TripidKard has you covered.
                        </p>
                    </div>
                </div>

                <!-- Bottom Section (Buttons with 50% Opacity) -->
                <div class="bottom-section mx-3">
                    <div class="mobile-buttons text-center">
                        <router-link to="/merchants" class="btn btn-primary btn-lg mb-3 w-100 button-transparent">
                            View Offers from Our Merchants
                        </router-link>
                        <router-link to="/join" class="btn btn-outline-primary btn-lg w-100 button-transparent">
                            Join TripidKard as a Merchant
                        </router-link>
                    </div>
                    <div class="text-center mt-4">
                        <router-link to="/tripidkard/details" class="text-decoration-none text-secondary fw-bold">
                            Learn How TripidKard Works
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Dashboard/Banner.vue';
import Search from '@/Components/Molecules/Search/ProvinceSearch.vue';
import Raffle from '@//Pages/Home/Dashboard/Raffle.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
import Merchant from '@/Pages/Home/Merchant/Merchant.vue';

import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {
    components: {
        MenuBar,
        Banner,
        Search,
        Raffle,
        Merchant,
        Footer,
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
/* Desktop-Only Styles */
/* .desktop-only {
    display: block;
} */

/* Mobile & Tablet Styles */
.mobile-only {
    display: none;
    text-align: center;
    position: relative;
    height: 100vh;
    overflow: hidden;
}



.content-container {
    position: fixed;
    text-align: center;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
    /* Higher z-index to make sure it's on top */
    background: linear-gradient(to bottom,
            rgba(255, 255, 255, 1) 80%,
            /* Solid white for the top 80% */
            rgba(255, 255, 255, 0.1) 120%,
            /* Faded white at 10% opacity between 80% and 90% */
            rgba(255, 255, 255, 0) 100%
            /* Fully transparent at the bottom */
        );
    display: flex;
    justify-content: center;
    /* align-items: center;  */
    overflow: hidden;
    /* Prevent scrolling within the container */
}

.overlay-wrapper {
    position: relative;
    z-index: 10;
}

/* Desktop View */
@media (min-width: 1025px) {
    /* .desktop-only {
        display: block;
    } */

    .mobile-only {
        display: none;
    }
}

/* Mobile and Tablet View */
@media (max-width: 1024px) {

    .title{
        font-size:35px;
    }

    .mobile-only {
        display: block;
    }
    .content-components {
    /* Content section styles */
    position: relative;
    z-index: 1;
    /* Lower z-index to make sure the overlay sits on top */
}
}
</style>
