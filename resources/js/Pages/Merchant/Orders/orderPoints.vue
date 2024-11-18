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
                    <h3>Order Loyalty Points</h3>
                    <form method="POST" @submit.prevent="submitForm">

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="form-control" :value="(authUser.users.stars_points || 0) + ' Loyalty Points'" readonly>
                                <input class="form-control" v-model="form.id" hidden>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <select v-if="!showOtherInput && !isSubmitting" class="form-control"
                                    name="starsPoints" v-model="form.starsPoints" id="starsPoints"
                                    @change="handleSelectChange">
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
                                    v-model="form.starsPoints" @blur="handleOtherInputBlur">
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <button type="submit" :disabled="isSubmitting" class="btn btn-primary px-5">
                            <span v-if="isSubmitting">Processing...</span>
                            <span v-else>Request</span>
                        </button>
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
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';
import { useAuthUserStore } from '../../../Stores/AuthUser';

import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2'; // Import Swal for alerts

const showOtherInput = ref(false);
const isSubmitting = ref(false); // For loading state
const router = useRouter();
const route = useRoute();
const authUser = useAuthUserStore();

const form = reactive({
    id: '',
    starsPoints: ''
});

const handleSelectChange = () => {
    if (form.starsPoints === 'Other') {
        showOtherInput.value = true;
        form.starsPoints = null;
    } else {
        showOtherInput.value = false;
    }
}

const handleOtherInputBlur = () => {
    if (!form.starsPoints.trim()) {
        form.starsPoints = null;
    }
}

const submitForm = async () => {
    if (isSubmitting.value) return; // Prevent multiple submissions

    isSubmitting.value = true; // Set the loading state to true

    try {
        const response = await axios.post('/api/merchant/stars', form);
        // SweetAlert2 success
        Swal.fire({
            title: 'Success',
            text: response.data.message,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            router.push('/merchant/dashboard'); // Redirect after success
        });
    } catch (error) {
        console.error('Error creating stars:', error);
        Swal.fire({
            title: 'Error',
            text: error.response ? error.response.data.message : 'An error occurred while updating stars',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    } finally {
        isSubmitting.value = false; // Reset the loading state
    }
}

onMounted(() => {
    const savedAuthUser = localStorage.getItem('authUser');
    if (savedAuthUser) {
        authUser.users = JSON.parse(savedAuthUser); // Load the saved user data
    }
});
</script>

