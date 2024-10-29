<template>
    <div>
        <MenuBar />
        <Sidebar />

        <div class="content-wrapper">
            <Breadcrumb />

            <section class="container">
                <div class="container">
                    <div class="bg-white p-4 rounded text-center mx-auto">
                        <!-- Display "Card Not Available" message when applicable -->
                        <div v-if="cardNotAvailable" class="alert alert-danger mx-auto col-sm-6">
                            <strong>Card Not Available</strong>
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
            </section>
        </div>

        <Footer />
    </div>
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { ref, onMounted } from 'vue';
import { Html5QrcodeScanner } from 'html5-qrcode';
import axios from 'axios';
import { useRouter } from 'vue-router';

const cardNumber = ref('');
const cardNotAvailable = ref(false);
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
        // Handle the scanned QR code text
        console.log(`QR Code detected: ${decodedText}`);
        cardNumber.value = decodedText;

        // Redirect to a link with the scanned QR code
        handleInput();
        // Stop scanning
        html5QrCodeScanner.clear();
    }
};

const handleInput = async () => {
    cardNotAvailable.value = false; // Reset the card not available state

    try {
        const response = await axios.post('/api/influencer/qrcode', {
            card_number: cardNumber.value
        });

        if (response.data.card_exists === true) {
            // Redirect based on the route specified in the response
            router.push({
                name: response.data.redirect_route, // Redirect to the route provided by the server
                params: { card_number: response.data.card_number },
            });
        } else if (response.data.card_exists === false && response.data.message === 'Card not available') {
            // Show the alert message when the card is not available
            cardNotAvailable.value = true;
        }

        console.log('Server response:', response.data);
    } catch (error) {
        // Handle server or network error
        console.error('Error fetching QR Code information:', error);
        cardNotAvailable.value = true;
    }
};

</script>

<style>
span#html5-qrcode-anchor-scan-type-change {
    display: none !important;
}

.alert {
    margin-bottom: 15px;
}
</style>
