<template>
    <div>
      <MenuBar />
      <Sidebar />

      <div class="content-wrapper">
        <Breadcrumb />

        <section class="container">
          <div class="container">
            <div class="bg-white p-4 rounded shadow text-center mx-auto">
              <div class="qr-code-form">
                <form id="qrForm" @submit.prevent="handlesubmit" method="POST" class="form-horizontal">
                  <label><b>SCAN QR CODE CARD NUMBER</b></label>
                  <!-- lalagay dito yung qr code value -->
                  <input type="text" v-model="cardNumber" name="card_number" id="card_number" placeholder="CARD NUMBER" class="form-control mx-auto text-center col-sm-6">
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
        </section>
      </div>

      <Footer />
    </div>
  </template>

<script setup>
  import { ref, onMounted } from 'vue';
  import Quagga from 'quagga';
  import MenuBar from '@/Components/Organisims/MenuBar.vue';
  import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
  import Footer from '@/Components/Organisims/Footer.vue';
  import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

  const cardNumber = ref('');
  const isFrontCamera = ref(false);

  onMounted(() => {
    startCamera();
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
        readers: ['code_128_reader']
      }
    }, function(err) {
      if (err) {
        console.error(err);
        return;
      }
      console.log('Quagga initialization succeeded');
      Quagga.start();
    });

    Quagga.onDetected(data => {
      console.log('QR code detected:', data.codeResult.code);
      cardNumber.value = data.codeResult.code;
    });
  };

  const toggleCamera = () => {
    isFrontCamera.value = !isFrontCamera.value;
    Quagga.stop();
    startCamera();
  };

  const handleSubmit = () => {
    console.log('Submitting form with card number:', cardNumber.value);
  };
</script>
