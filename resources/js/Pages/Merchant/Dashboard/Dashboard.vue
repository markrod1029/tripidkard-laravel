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

            <!-- Bar Graph -->
            <div class="row mt-5">
                <div class="col-sm-12">
                    <h5>Monthly Analytics</h5>
                    <canvas id="analyticsChart"></canvas>
                </div>
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
                        marginwidth="0">
                    </iframe>
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

        const renderChart = () => {
            const ctx = document.getElementById('analyticsChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [
                        {
                            label: 'Customers',
                            data: [120, 150, 180, 210, customerCount.value, 250],
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        },
                        {
                            label: 'Tripidkards',
                            data: [90, 110, 140, 170, cardCount.value, 200],
                            backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        },
                        {
                            label: 'Loyalty Points',
                            data: [1500, 1800, 2000, 2500, loyaltyPoints.value, 3000],
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Monthly Analytics Overview',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
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
                    authStore.user?.province || 'Dagupan City Pangasinan';
            loyaltyPoints.value = authStore.user?.stars_points || 0;
            await fetchCounts();
            renderChart();
        });

        return {
            userAddress,
            customerCount,
            cardCount,
            loyaltyPoints,
        };
    },
};
</script>

<style scoped>
.mapouter {
    position: relative;
    text-align: center;
}

.info-box {
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 10px 0;
}

canvas {
    max-height: 400px;
    margin: auto;
}
</style>
