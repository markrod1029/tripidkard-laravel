<template>
    <div class="container">
        <h2 class="text-center mt-5 mb-4 font-weight-bold" style="font-size: 2.3rem; font-family: 'Arial', sans-serif;">
            {{ route.query.province }} Affiliate Merchants
        </h2>

        <div id="merchantCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="border rounded p-3 mb-3 search-merchant">
                        <div class="d-flex justify-content-between ">
                            <div class="mb-2 d-flex text-gray title-affiliate">
                                <h5>{{ merchants.length }} {{ route.query.province }} Affiliate Merchants</h5>
                            </div>
                            <div class="col-4 ">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search Merchant..." id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Check if there are filtered merchants or show default image -->
                        <div v-if="filteredMerchants.length === 0" class="col-12 mx-auto text-center">
                            <div class="card shadow-sm" style="max-width: 400px; margin: 0 auto;">
                                <!-- Make image responsive and adjust height -->
                                <img src="/storage/img/not-found.png" class="card-img-top" alt="No Results" style="max-height: 300px; width: auto; margin: 0 auto;">
                                <div class="card-body">
                                    <!-- Updated "No merchants found" message -->
                                    <h5 class="card-title">Hmmm, we didn’t find any merchants in your search.</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Merchants cards here -->
                        <div class="col-md-4 mb-4 d-flex align-items-stretch" v-for="merchant in filteredMerchants" :key="merchant.id">
                            <div class="card float-left shadow-sm" style="width: 100%;">
                                <!-- Directly set src to use either avatar or default -->
                                <img :src="merchant.avatar ? `/storage/${merchant.avatar}` : '/storage/img/logo.jpg'" height="310" class="card-img-top" alt="Merchant Avatar">

                                <div class="card-body">
                                    <router-link :to="`/merchants/${merchant.merchant_id}/${merchant.business_name}`" class="text-dark">
                                        <h5 class="card-title mb-3 font-weight-bold">{{ merchant.business_name }}</h5>
                                    </router-link>
                                    <div>
                                        <p class="card-text my-2"><i class="fas fa-percent text-gray" style="font-size:12px;"></i> &nbsp; {{ merchant.discount }}% Discount</p>
                                    </div>
                                    <div>
                                        <p class="card-text my-2"><i class="fas fa-envelope text-gray" style="font-size:12px;"></i> &nbsp; {{ merchant.email }}</p>
                                    </div>
                                    <div>
                                        <p class="card-text mt-2 mb-3"><i class="fa fa-map-marker text-gray" style="font-size:12px;"></i> &nbsp; {{ merchant.zip }} {{ merchant.street }} {{ merchant.city }} {{ merchant.province }}</p>
                                    </div>
                                    <router-link :to="`/merchants/${merchant.merchant_id}/${merchant.business_name}`" class="text-dark">
                                        <div class="d-flex justify-content-between align-items-center border-top pt-2 text-dark">
                                            <span>{{ merchant.business_category }} > {{ merchant.business_sub_category }}</span>
                                            <i class="text-gray fas fa-eye" style="font-size:15px;"></i>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <!-- End of merchants cards -->
                    </div>
                </div>
                <!-- Add more carousel items as needed -->
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch, computed } from "vue";
import { useRoute } from "vue-router";
import { debounce } from 'lodash';

// Getting query parameters from the route
const route = useRoute();
const searchQuery = ref('');
const merchants = ref([]);

// Method to fetch merchants based on category and location
const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants', {
            params: {
                category: route.query.category,
                province: route.query.province,
                city: route.query.city,
                query: searchQuery.value,
            },
        });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
    }
};

// Watch for changes in searchQuery and perform debounced search
watch(searchQuery, debounce(() => {
    getMerchants();
}, 100));

// Fetch merchants on component mount
onMounted(() => {
    getMerchants();
});

// Computed property to filter merchants based on search query
const filteredMerchants = computed(() => {
    return merchants.value.filter(merchant =>
        merchant.business_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>

<style scoped>
.text-gray {
    color: gray;
}
.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.card-body {
    padding: 15px;
}

.card-img-top {
    object-fit: cover; /* Ensure the images fit nicely */
}

@media (max-width: 768px) {
    .card-img-top {
        height: auto; /* Ensure image adjusts properly */
    }

    .carousel-item {
        padding-left: 10px;
        padding-right: 10px;
    }

    .search-merchant{
        display:none;
    }


}


</style>
