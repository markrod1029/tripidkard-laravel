<template>
    <div class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-5">
                                    <h3 class="text-dark font-weight-bold">Customer Information</h3>
                                </div>
                            </div>
                        </div>

                        <div class="information">
                            <div class="info-group">
                                <label><strong>Name:</strong></label>
                                <span>{{ fname }} {{ mname }} {{ lname }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Card Number:</strong></label>
                                <span>{{ cardNumber }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Email:</strong></label>
                                <span>{{ email }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Validity:</strong></label>
                                <span>{{ validity }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Loyalty Points:</strong></label>
                                <span>{{ loyaltyPoints }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

// Reactive variables for customer information
const fname = ref('');
const mname = ref('');
const lname = ref('');
const cardNumber = ref('');
const email = ref('');
const validity = ref('');
const loyaltyPoints = ref(0);

const route = useRoute();

const getCustomers = async () => {
    try {
        const response = await axios.get(`/api/home/customer/${route.params.card_number}/points`);

        // Assuming the response data contains customer information
        const customerData = response.data;

        // Set the values from the response to the reactive variables
        fname.value = customerData.fname; // Adjust according to your API response
        mname.value = customerData.mname; // Adjust according to your API response
        lname.value = customerData.lname; // Adjust according to your API response
        cardNumber.value = customerData.customer_card_num; // Adjust according to your API response
        email.value = customerData.email; // Adjust according to your API response
        validity.value = customerData.validity; // Adjust according to your API response
        loyaltyPoints.value = customerData.total_points; // Adjust according to your API response
    } catch (error) {
        console.error('Error fetching customers:', error);
    }
};

onMounted(() => {
    getCustomers();
});
</script>

<style scoped>
.info-group {
    margin-bottom: 15px;
}

.info-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.info-group span {
    display: block;
    padding: 10px 15px;
    border-radius: 4px;
    background-color: #e9ecef;
    font-size: 16px;
    color: #495057;
}
</style>
