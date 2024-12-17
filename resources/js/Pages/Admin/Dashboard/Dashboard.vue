<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="container">

            <!-- Existing Info Boxes -->
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

            <!-- Analytics Chart -->
            <div class="container my-5">
                <h3>Monthly Analytics</h3>
                <canvas ref="chartCanvas" height="150"></canvas>
            </div>

            <!-- Map Container -->
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
import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

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
        const influencerCount = ref(0);
        const cardCount = ref(0);
        const chartCanvas = ref(null); // Chart reference

        // Fetch data and populate counts
        const fetchCounts = async () => {
            try {
                const merchantResponse = await axios.get('/api/merchants/count');
                merchantCount.value = merchantResponse.data.count;

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

        const initChart = () => {
            new Chart(chartCanvas.value, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Dummy months
                    datasets: [
                        {
                            label: 'Merchants',
                            data: [10, 12, 15, 20, 25, 30], // Dummy data
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        },
                        {
                            label: 'Customers',
                            data: [5, 8, 12, 15, 22, 28],
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        },
                        {
                            label: 'Influencers',
                            data: [3, 5, 7, 10, 12, 15],
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
        };

        onMounted(async () => {
            await authStore.getUser();
            userAddress.value = authStore.user?.zip + ' ' + authStore.user?.street + ' ' + authStore.user?.city + ' ' + authStore.user?.province || 'Dagupan City Pangasinan';
            fetchCounts();
            initChart();
        });

        return {
            userAddress,
            merchantCount,
            customerCount,
            influencerCount,
            cardCount,
            chartCanvas, // Chart reference
        };
    },
};
</script>
