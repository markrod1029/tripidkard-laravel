<template>
    <div>
        <MenuBar />
        <Sidebar />

        <div class="content-wrapper">
            <Breadcrumb />

            <section class="container">
                <div class="container">
                    <div class="bg-white p-4 rounded text-center mx-auto">
                        <div class="qr-code-form">
                            <form id="qrForm" @submit.prevent="handleSubmit" method="POST" class="form-horizontal">
                                <label><b>SCAN QR CODE CARD NUMBER</b></label>
                                <input type="text" v-model="cardNumber" name="card_number" id="card_number"
                                    placeholder="CARD NUMBER" class="form-control mx-auto text-center col-sm-6">
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
import { ref, onMounted, nextTick } from 'vue';
import { Html5QrcodeScanner } from 'html5-qrcode';

const cardNumber = ref('');

onMounted(() => {
    startQrScanner();
});

const startQrScanner = () => {
    const html5QrCodeScanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 1000, qrbox: 650 }
    );

    html5QrCodeScanner.render(onScanSuccess);

    function onScanSuccess(decodedText, decodedResult) {
        // Handle the scanned QR code text
        console.log(`QR Code detected: ${decodedText}`);
        cardNumber.value = decodedText;

        // Redirect to a link with the scanned QR code
        const redirectUrl = `/customer/information/${decodedText}`;
        window.location.href = redirectUrl;

        // Stop scanning
        html5QrCodeScanner.clear();
    }
};
</script>
