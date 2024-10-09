<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />

        <section class="container">

            <div class="row">
                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Merchant List</span>
                            <span class="info-box-number">{{ merchantCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customer List</span>
                            <span class="info-box-number">{{ customerCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Influencer List</span>
                            <span class="info-box-number">{{ influencerCount }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-credit-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tripidkard List</span>
                            <span class="info-box-number">{{ cardCount }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="100%" height="400" id="gmap_canvas"
                            :src="`https://maps.google.com/maps?q=${encodeURIComponent(userAddress)}&t=&z=15&ie=UTF8&iwloc=&output=embed`"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                        </iframe>
                    </div>
                </div>
            </div>

        </section>

    </div>
    <Footer />
</template>

<script>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted, ref } from 'vue';
import axios from 'axios';

export default {
    components: {
        MenuBar,
        Sidebar,
        Footer,
        Breadcrumb,
    },

    setup() {
        const authStore = useAuthStore();
        const userAddress = ref('');
        const merchantCount = ref(0);
        const customerCount = ref(0);
        const cardCount = ref(0);
        const influencerCount= ref(0);


        // Function to fetch counts for merchants, customers, and cards
        const fetchCounts = async () => {
            try {
                // const merchantResponse = await axios.get('/api/merchants/count');
                // merchantCount.value = merchantResponse.data.count;

                const merrchantResponse = await axios.get('/api/merchants/count');
                merchantCount.value = merrchantResponse.data.count;

                const customerResponse = await axios.get('/api/customers/count');
                customerCount.value = customerResponse.data.count;

                const influencerResponse = await axios.get('/api/customers/count');
                influencerCount.value = influencerResponse.data.count;

                const cardResponse = await axios.get('/api/tripidkards/count');
                cardCount.value = cardResponse.data.count;
            } catch (error) {
                console.error('Error fetching counts:', error);
            }
        };

        // Fetch user details and address
        onMounted(async () => {
            await authStore.getUser();
            userAddress.value = authStore.user?.zip + ' ' + authStore.user?.street + ' ' + authStore.user?.city + ' ' + authStore.user?.province || 'Dagupan City Pangasinan';
            fetchCounts();
        });
        return {
            userAddress,
            merchantCount,
            customerCount,
            influencerCount,
            cardCount,
        };
    },
};
</script>
