<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="container-fluid">
            <div class="row">
                <!-- Customer List -->
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customer List</span>
                            <span class="info-box-number">{{ customerCount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tripidkard List -->
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-credit-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tripidkard List</span>
                            <span class="info-box-number">{{ cardCount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Loyalty Points -->
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Loyalty Points</span>
                            <span class="info-box-number">{{ loyaltyPoints }} Points</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Chart -->
            <div class="container my-5">
                <h3>Monthly Analytics</h3>
                <canvas ref="chartCanvas" height="150"></canvas>
            </div>

            <!-- Google Map -->
            <div class="mapouter mt-4">
                <div class="gmap_canvas">
                    <iframe
                        width="100%"
                        height="400"
                        id="gmap_canvas"
                        :src="`https://maps.google.com/maps?q=${encodeURIComponent(userAddress)}&t=&z=15&ie=UTF8&iwloc=&output=embed`"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                    ></iframe>
                </div>
            </div>
        </section>
    </div>
    <Footer />
</template>

<script>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Chart from 'chart.js/auto';

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
        const loyaltyPoints = ref(0);
        const chartCanvas = ref(null);  // Reference for chart canvas

        const fetchCounts = async () => {
            try {
                // Fetch customer count
                const customerResponse = await axios.get('/api/customers/count');
                customerCount.value = customerResponse.data.count;

                // Fetch Tripidkard count
                const cardResponse = await axios.get('/api/tripidkards/count');
                cardCount.value = cardResponse.data.count;
            } catch (error) {
                console.error('Error fetching counts:', error);
            }
        };

        const initChart = () => {
            if (chartCanvas.value) {
                new Chart(chartCanvas.value, {
                    type: 'bar',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Dummy months
                        datasets: [
                            {
                                label: 'Merchants',
                                data: [10, 12, 15, 20, 25, 30], // Replace with real data if needed
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            },
                            {
                                label: 'Customers',
                                data: [customerCount.value, customerCount.value, customerCount.value, customerCount.value, customerCount.value, customerCount.value],
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            },
                            {
                                label: 'Tripidkards',
                                data: [cardCount.value, cardCount.value, cardCount.value, cardCount.value, cardCount.value, cardCount.value],
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Monthly Data Analytics' },
                        },
                    },
                });
            }
        };

        onMounted(async () => {
            await authStore.getUser();
            userAddress.value =
                authStore.user?.zip +
                    ' ' +
                    authStore.user?.street +
                    ' ' +
                    authStore.user?.city +
                    ' ' +
                    authStore.user?.province || 'Unknown Address';

            loyaltyPoints.value = authStore.user?.stars_points || 0;
            await fetchCounts();
            initChart();
        });

        return {
            userAddress,
            customerCount,
            cardCount,
            loyaltyPoints,
            chartCanvas,  // Include the reference to the canvas element
        };
    },
};
</script>

<style scoped>
/* Optional styling to adjust the canvas size */
canvas {
    max-width: 100%;
    height: auto;
}
</style>
