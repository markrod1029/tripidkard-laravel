<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="container">
            <div class="row">

                <div class="col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="far fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customer List</span>
                            <span class="info-box-number">{{ customerCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-coins"></i></span>
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
                        <iframe
                            width="100%"
                            height="400"
                            id="gmap_canvas"
                            :src="`https://maps.google.com/maps?q=${encodeURIComponent(userAddress)}&t=&z=15&ie=UTF8&iwloc=&output=embed`"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0">
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
import Sidebar from '@/Components/Organisims/Influencer/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted, ref } from 'vue';

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
        const customerCount = ref(0);
        const cardCount = ref(0);

        const fetchCounts = async () => {
            try {
                const customerResponse = await axios.get('/api/customers/count');
                customerCount.value = customerResponse.data.count;

                const cardResponse = await axios.get('/api/tripidkards/count');
                cardCount.value = cardResponse.data.count;
            } catch (error) {
                console.error('Error fetching counts:', error);
            }
        };

        onMounted(async () => {
            await authStore.getUser();
            // Assuming the user's address is available as `authStore.user.address`
            userAddress.value = authStore.user?.zip + ' ' + authStore.user?.street + ' ' + authStore.user?.city + ' ' + authStore.user?.province || 'Dagupan City Pangasinan';
            await fetchCounts();
        });

        return {
            userAddress,
            customerCount,
            cardCount,
        };
    },
};
</script>
