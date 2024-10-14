<template>
    <div class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <h3 class="text-dark font-weight-bold">Customer Information</h3>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded text-center mx-auto">
                            <!-- Display error message -->
                            <div v-if="errorMessage" class="alert alert-danger mt-3 text-center">
                                {{ errorMessage }}
                            </div>
                            <div class="qr-code-form">
                                <form id="qrForm" @submit.prevent="handleSubmit" method="POST" class="form-horizontal">
                                    <label><b>SCAN QR CODE CARD NUMBER</b></label>
                                    <input type="text" v-model="cardNumber" name="card_number" id="card_number"
                                        placeholder="CARD NUMBER" class="form-control mx-auto text-center col-sm-6"
                                        @input="handleInput" @keyup.enter="handleInput" />
                                </form>
                            </div>

                            <div class="scanner-camera mt-3">
                                <div id="my-qr-reader" class="scanner-overlay"></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Html5QrcodeScanner } from 'html5-qrcode';
import axios from 'axios';
import { useRouter } from 'vue-router';

const cardNumber = ref('');
const errorMessage = ref(null); // Add an error message state
const router = useRouter();

onMounted(() => {
    startQrScanner();
});

const startQrScanner = () => {
    const html5QrCodeScanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 1000, qrbox: 650 }
    );

    html5QrCodeScanner.render(onScanSuccess);

    function onScanSuccess(decodedText) {
        console.log(`QR Code detected: ${decodedText}`);
        cardNumber.value = decodedText;

        // Automatically call handleInput() after scanning
        handleInput();
        // Stop scanning
        html5QrCodeScanner.clear();
    }
};

const handleInput = async () => {
    errorMessage.value = null; // Reset error message before making the request

    try {
        const response = await axios.post('/api/home/qrcode', {
            card_number: cardNumber.value // Send scanned card number to server
        });

        // Redirect based on server response
        if (response.data.card_exists) {
            router.push({
                name: 'customer.information',
                params: { card_number: response.data.card_number }, // Pass the card number in params
            });
        } else {
            throw new Error(response.data.error || 'Customer Card not found'); // Throw an error if the card does not exist
        }

        console.log('Server response:', response.data); // Log the server response
    } catch (error) {
        console.error('Error:', error);
        errorMessage.value = error.response?.data?.error || 'An unexpected error occurred'; // Show error message
    }
};
</script>

<style>
span#html5-qrcode-anchor-scan-type-change {
    display: none !important;
}
</style>
