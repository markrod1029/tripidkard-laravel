<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto custom-container">
                    <img class="img-fluid mx-auto"
                        src="https://tripidkard.com/wp-content/uploads/2023/10/tripid-card-ver.-2-1.png" width="150"
                        height="100" />
                    <h3 v-if="updatestarts">Update Merchant Loyalty Stars</h3>
                    <h3 v-else>Register Merchant Loyalty Stars</h3>
                    <form method="POST" @submit.prevent="createStars">

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <select class="form-control" name="merchants" v-model="form.merchant" id="merchants">
                                    <option value="" disabled selected>Select Merchant Name</option>
                                    <option v-for="merchant in merchants" :key="merchant.id"
                                        :value="merchant.merchant_id">{{
                        merchant.business_name }}</option>
                                </select>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <select v-if="!showOtherInput && updatestarts == false " class="form-control" name="starsPoints"
                                    v-model="form.starsPoints" id="starsPoints" @change="handleSelectChange">
                                    <option value="" disabled selected>Select Loyalty Stars</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input v-else type="number" class="form-control" id="loyalty_points"
                                    name="loyalty_points" placeholder="Total Loyalty Stars"
                                    v-model="form.otherStarsPoints" @blur="handleOtherInputBlur">
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <button type="submit" name="save" class="btn btn-primary px-5 ">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';

import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr';
const merchants = ref([]);
const showOtherInput = ref(false);
const router = useRouter();
const route = useRoute();
const toastr = useToastr();

const updatestarts = ref(false);
const form = reactive({
    merchant: '',
    starsPoints: '',
    otherStarsPoints: ''
});

const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants');
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
    }
}


const handleSelectChange = () => {
    if (form.starsPoints === 'Other') {
        showOtherInput.value = true;
        form.starsPoints = null; // Reset starsPoints value
    } else {
        showOtherInput.value = false;
        form.otherStarsPoints = form.starsPoints; // Set otherStarsPoints equal to starsPoints
    }
}

const handleOtherInputBlur = () => {
    if (!form.otherStarsPoints.trim()) {
        form.starsPoints = null; // Reset starsPoints value if otherStarsPoints is empty
    }
}

const createStars = async () => {
    try {
        const response = await axios.post('/api/stars/crete', form);
        router.push('/admin/loyalty-stars');
        toastr.success(response.data.message);
    } catch (error) {

    }
}


const getPoints = async () => {
    try {
        const response = await axios.get(`/api/stars/${route.params.id}/edit`);
        const data = response.data;
        form.merchant = data.id;
        form.starsPoints = data.stars_points;
        form.otherStarsPoints = data.stars_points;
    } catch (error) {

    }
}


onMounted(() => {
    if(route.name === 'admin.loyalty-stars.edit') {
        updatestarts.value = true;
    getPoints();

    }
    getMerchants();
    console.log(updatestarts.value)

})
</script>
