<template>
    <div class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <a href="#!">
                                        <h3 class="text-dark font-weight-bold">Merchant Information</h3>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded text-center mx-auto">
                            <div class="qr-code-form">
                                <form id="qrForm" @submit.prevent="handleSubmit" method="POST" class="form-horizontal">
                                    <label><b>SCAN QR CODE CARD NUMBER</b></label>
                                    <input type="text" v-model="cardNumber" name="card_number" id="card_number"
                                        placeholder="CARD NUMBER" class="form-control mx-auto text-center col-sm-6">
                                </form>
                            </div>

                            <div class="camera-controls mt-3">
                                <button @click="toggleCamera" class="btn btn-primary">{{ isFrontCamera ? 'Switch to Back Camera' : 'Switch to Front Camera' }}</button>
                            </div>

                            <div class="scanner-camera mt-3">
                                <div class="scanner-frame">
                                    <div id="my-qr-reader" class="scanner-overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import Quagga from 'quagga';

const cardNumber = ref('');
const isFrontCamera = ref(false);

onMounted(() => {
    nextTick(() => {
        startCamera();
    });
});

const startCamera = () => {
    Quagga.init({
        inputStream: {
            name: 'Live',
            type: 'LiveStream',
            target: document.querySelector('#my-qr-reader'),
            constraints: {
                width: 640,
                height: 480,
                facingMode: isFrontCamera.value ? 'user' : 'environment'
            },
        },
        decoder: {
            readers: ['qr_reader'] // Use 'qr_reader' for QR codes
        }
    }, (err) => {
        if (err) {
            console.error('Quagga initialization failed:', err);
            return;
        }
        console.log('Quagga initialization succeeded');
        Quagga.start();
    });

    Quagga.onDetected((data) => {
        console.log('QR code detected:', data.codeResult.code);
        cardNumber.value = data.codeResult.code;
    });
};

const toggleCamera = () => {
    isFrontCamera.value = !isFrontCamera.value;
    Quagga.stop();
    nextTick(() => {
        startCamera();
    });
};

const handleSubmit = () => {
    console.log('Submitting form with card number:', cardNumber.value);
};
</script>
