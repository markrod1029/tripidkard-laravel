<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto custom-container">
                    <img class="img-fluid mx-auto"
                         src="/storage/img/logo.jpg"
                         width="150" height="100" />

                    <h3>Register Merchant Loyalty Stars</h3>
                    <form method="POST" @submit.prevent="orderPoint">

                        <!-- Display stars -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="form-control" v-for="star in stars" :key="star.id"
                                       :value="star.stars + ' ' + star.newProperty" readonly>
                                <input class="form-control" v-model="form.id" value="2" hidden>
                            </div>
                        </div>

                        <!-- Input for Business Name -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="form-control" v-model="form.merchant" placeholder="Enter Business Name" readonly/>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>


                        <!-- Loyalty Points Selection -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">

                                <input  type="text" class="form-control" id="loyalty_points"
                                       name="loyalty_points" placeholder="Total Loyalty Stars"
                                       v-model="form.starsPoints" @blur="handleOtherInputBlur">
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
import { onMounted, reactive, ref, computed } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr';

const showOtherInput = ref(false);
const router = useRouter();
const route = useRoute();
const toastr = useToastr();

const stars = ref([]);

const updatestarts = ref(false);
const form = reactive({
    order_id: route.params.id,
    id: '',
    merchant: '',  // This will hold the business name directly
    starsPoints: '',
});



const getStars = async () => {
    try {
        const response = await axios.get('/api/stars');
        const modifiedStars = response.data.map(star => {
            return {
                ...star,
                newProperty: 'Star Points',
            };
        });
        stars.value = modifiedStars;
        form.id = stars.value[0].id; // Set the form id to the first star id
    } catch (error) {
        console.error('Error fetching stars:', error);
    }
}


const orderPoint = async () => {
    try {
        const response = await axios.put('/api/loyalty-stars/order/create', form);
        router.push('/admin/loyalty-stars');
        toastr.success(response.data.message);
    } catch (error) {
        console.error('Error creating stars:', error);
        if (error.response && error.response.status === 422) {
            toastr.error(error.response.data.message);
        } else {
            toastr.error('An error occurred while updating stars');
        }
    }
}

const getPoints = async () => {
    try {
        const response = await axios.get(`/api/loyalty-stars/order/${route.params.id}/edit`);
        const data = response.data;
        form.merchant = data.business_name; // Now using business name directly
        form.starsPoints = data.order.total;
        console.log(data.id)
    } catch (error) {
        console.error(error);
    }
}

onMounted(() => {
    getPoints();
    getStars();
})
</script>
