<template>
    <div class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-5">
                                    <a href="#!">
                                        <h3 class="text-dark font-weight-bold">Merchant Information</h3>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Error and Success Messages -->
                        <div class='alert alert-danger alert-dismissible' v-if="errorMessage">
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'
                                @click="errorMessage = ''">&times;</button>
                            {{ errorMessage }}
                        </div>
                        <div class='alert alert-success alert-dismissible' v-if="successMessage">
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'
                                @click="successMessage = ''">&times;</button>
                            {{ successMessage }}
                        </div>

                        <!-- Merchant Information Form -->
                        <form @submit.prevent="createMerchants">
                            <div class="row gy-3">
                                <!-- First Name -->
                                <div class="col-12 mb-3">
                                    <label for="firstName" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="firstName" id="firstName"
                                            v-model="form.fname" required>
                                    </div>
                                </div>
                                <!-- Middle Name -->
                                <div class="col-12 mb-3">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="middleName" id="middleName"
                                            v-model="form.mname" placeholder="Optional">
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="col-12 mb-3">
                                    <label for="lastName" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="lastName" id="lastName"
                                            v-model="form.lname" required>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" id="email"
                                            v-model="form.email" required>
                                    </div>
                                </div>
                                <!-- Phone Number -->
                                <div class="col-12 mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber"
                                            v-model="form.contact" required>
                                    </div>
                                </div>

                                <!-- DTI No -->
                                <div class="col-12 mb-3">
                                    <label for="dtiNo" class="form-label">DTI Registration No. <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="dtiNo" id="dtiNo"
                                            v-model="form.dtiNo" required>
                                    </div>
                                </div>

                                <!-- Business Name -->
                                <div class="col-12 mb-3">
                                    <label for="businessName" class="form-label">Business Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="businessName" id="businessName"
                                            v-model="form.business_name" required>
                                    </div>
                                </div>
                                <!-- Business Category Dropdown -->
                                <div class="col-12 mb-3">
                                    <label for="businessCategory" class="form-label">Business Category <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" id="businessCategory"
                                            v-model="form.business_category" @change="updateSubCategories" required>
                                            <option value="">Select Business Category</option>
                                            <option v-for="(subcategories, category) in categories" :key="category"
                                                :value="category">{{ category }}</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Business Sub Category -->
                                <div class="col-12 mb-3">
                                    <label for="businessSubCategory" class="form-label">Business Sub Category <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <template v-if="form.business_category === 'Other'">
                                            <input type="text" class="form-control" id="businessSubCategory"
                                                v-model="form.business_sub_category" required>
                                        </template>

                                        <template v-else>
                                            <select class="form-control" id="businessSubCategory"
                                                v-model="form.business_sub_category" required>
                                                <option value="">Select Business Sub Category</option>
                                                <option v-for="subCategory in subCategories" :key="subCategory"
                                                    :value="subCategory">{{ subCategory }}</option>
                                            </select>
                                        </template>
                                    </div>
                                </div>
                                <!-- Street -->
                                <div class="col-12 mb-3">
                                    <label for="street" class="form-label">Street <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="street" id="street"
                                            v-model="form.street" required>
                                    </div>
                                </div>
                                <!-- City -->
                                <div class="col-12 mb-3">
                                    <label for="city" class="form-label">City/Town <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="city" id="city"
                                            v-model="form.city" required>
                                    </div>
                                </div>
                                <!-- Province -->
                                <div class="col-12 mb-3">
                                    <label for="province" class="form-label">Province <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="province" id="province"
                                            v-model="form.province" required>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="col-12 mt-2 d-flex justify-content-center">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg btn-block px-5"
                                            type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2'; // Import SweetAlert2

const router = useRouter();

const form = ref({
    fname: '',
    mname: '',
    lname: '',
    contact: '',
    email: '',
    dtiNo: '',
    business_name: '',
    business_category: '',
    business_sub_category: '',
    street: '',
    city: '',
    province: '',
});

const categories = ref({
    'Retail': ['Clothing', 'Electronics', 'Groceries', 'Furniture', 'Books'],
    'Food and Beverage': ['Restaurants', 'Cafes', 'Bars', 'Fast Food', 'Bakeries'],
    'Health and Wellness': ['Gyms', 'Yoga Studios', 'Spas', 'Nutritionists', 'Health Clinics'],
    'Beauty and Personal Care': ['Hair Salons', 'Nail Salons', 'Skincare', 'Cosmetics', 'Barber Shops'],
    'Travel and Leisure': ['Hotels', 'Travel Agencies', 'Tour Operators', 'Cruise Lines', 'Adventure Sports'],
    'Entertainment': ['Movie Theaters', 'Music Venues', 'Amusement Parks', 'Casinos', 'Art Galleries'],
    'Automotive': ['Car Dealerships', 'Auto Repair', 'Car Rentals', 'Car Wash', 'Auto Parts'],
    'Home and Garden': ['Home Decor', 'Gardening Supplies', 'Construction', 'Landscaping', 'Furniture'],
});

const subCategories = ref([]);

const successMessage = ref('');
const errorMessage = ref('');

const updateSubCategories = () => {
    if (form.value.business_category && categories.value[form.value.business_category]) {
        subCategories.value = categories.value[form.value.business_category];
    } else {
        subCategories.value = [];
    }
};

const createMerchants = async () => {
    try {
        const response = await axios.post('/api/merchants/create', form.value);
        router.push('/merchants');
        successMessage.value = response.data.message;

        // SweetAlert2 Success Message
        Swal.fire({
            title: 'Success!',
            text: 'Your merchant request is under review. You will be notified once it is approved.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } catch (error) {
        if (error.response && error.response.data.error) {
            errorMessage.value = error.response.data.error;
        } else {
            errorMessage.value = 'An error occurred while processing your request.';
        }
    }
};
</script>

<style scoped>
.text-gray {
    color: gray;
}
</style>
