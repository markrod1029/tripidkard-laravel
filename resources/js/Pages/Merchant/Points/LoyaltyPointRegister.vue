<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid mt-5">
                <!-- Custom container with responsive width handling -->
                <div class="bg-white p-4 rounded shadow text-center mx-auto custom-container" :class="{'w-75': !isMobile, 'w-95': isMobile}">
                    <img class="img-fluid mx-auto" src="/storage/img/logo.jpg" width="150" height="100" />
                    <h3 v-if="editPointsTitle">Update Loyalty Stars</h3>
                    <h3 v-else>Register Loyalty Stars</h3>
                    <form method="POST" @submit.prevent="handleSubmit">

                        <!-- Card Number (Readonly if QR code scanned) -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input
                                    type="text"
                                    v-model="form.card_number"
                                    class="form-control"
                                    id="card_number"
                                    name="card_number"
                                    placeholder="Card Number"
                                    :readonly="scanQrCOde || editMode"
                                    required
                                />
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <!-- Type (Dropdown for Discount or Points) -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <select v-model="form.type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="discount">Discount</option>
                                    <option value="points">Points</option>
                                </select>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input
                                    type="text"
                                    v-model="form.price"
                                    class="form-control"
                                    id="price"
                                    name="price"
                                    placeholder="Total Price"
                                    :readonly="editMode"
                                    required
                                />
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <!-- Total Loyalty Points (Visible only when Points is selected) -->
                        <div class="form-group mt-3" v-if="form.type === 'points'">
                            <div class="col-md-12 d-flex align-items-center">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="loyalty_points"
                                    name="points"
                                    v-model="form.points"
                                    placeholder="Total Loyalty Points"
                                    min="1"
                                    required
                                />
                                <span class="ml-2 text-danger">*</span>
                            </div>
                            <p v-if="form.points && form.points < 1" class="text-danger">Points must be at least 1.</p>
                            <p v-if="form.points && form.points > availableStars" class="text-danger">
                                You do not have enough stars for this transaction.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button :disabled="isSubmitting || !isValidForm" type="submit" class="custom-button btn btn-primary btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted, computed } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr.js';

export default {
    components: {
        MenuBar,
        Sidebar,
        Footer,
        Breadcrumb
    },
    setup() {
        const router = useRouter();
        const toastr = useToastr();
        const route = useRoute();

        const form = reactive({
            card_number: '',
            price: '',
            points: '',
            type: '', // 'discount' or 'points'
        });

        const errorMessage = ref('');
        const editPointsTitle = ref(false);
        const editMode = ref(false);
        const isSubmitting = ref(false);
        const scanQrCOde = ref(false);

        // Simulated available stars for merchant (this should come from your backend)
        const availableStars = ref(50); // You would normally fetch this dynamically from your backend

        const isMobile = ref(false);

        // Check the window size on mount and on resize to determine mobile vs desktop view
        const checkIfMobile = () => {
            isMobile.value = window.innerWidth <= 768; // 768px is commonly considered a mobile breakpoint
        };

        // Listen for window resize
        window.addEventListener('resize', checkIfMobile);

        // Call the function when the component is mounted to check initial screen size
        onMounted(() => {
            checkIfMobile();
            if (route.name === 'merchant.loyalty-points.edit') {
                getPoints();
                editPointsTitle.value = true;
            } else if (route.name === 'merchant.loyalty-stars.scan') {
                form.card_number = route.params.card_number;
                scanQrCOde.value = true;
            } else {
                editPointsTitle.value = false;
            }
        });

        // Computed property to validate the form
        const isValidForm = computed(() => {
            if (form.type === 'points') {
                return form.points >= 1 && form.points <= availableStars.value;
            }
            return true; // No validation for 'discount' type
        });

        const createPoints = async () => {
            try {
                const response = await axios.post('/api/merchant/points/register', form);
                router.push('/merchant/loyalty-stars');
                toastr.success(response.data.message);
            } catch (error) {
                console.error('Error creating stars:', error);
                toastr.error('An error occurred while Adding stars');
            }
        };

        const getPoints = async () => {
            try {
                const response = await axios.get(`/api/merchant/points/${route.params.id}/edit`);
                const data = response.data;
                form.card_number = data.card_number;
                form.price = data.product_price;
                form.points = data.points;
                form.type = data.type;
                editMode.value = true;
                editPointsTitle.value = true;
            } catch (error) {
                toastr.error('Error retrieving points data');
            }
        };

        const updatePoints = async () => {
            try {
                const response = await axios.post(`/api/merchant/points/${route.params.id}/edit`, form);
                router.push('/merchant/loyalty-stars');
                toastr.success('Points Updated Successfully');
            } catch (error) {
                toastr.error('Error updating points');
            }
        };

        const handleSubmit = async () => {
            isSubmitting.value = true;
            if (editPointsTitle.value) {
                await updatePoints();
            } else {
                await createPoints();
            }
            isSubmitting.value = false;
        };

        return {
            form,
            handleSubmit,
            editPointsTitle,
            editMode,
            scanQrCOde,
            isSubmitting,
            availableStars,
            isValidForm,
            isMobile
        };
    }
};
</script>

<style scoped>
.custom-button {
    font-size: 1.2rem;
    max-width: 200px;
    margin: 1rem auto 0;
}

.custom-container {
    transition: width 0.3s ease;
}
</style>
