<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />


        <section class="container">

            <div class="container">
            <div class="bg-white p-4 rounded shadow text-center mx-auto">


                <div class="qr-code-form">
                    <form id="qrForm" action="business/QrcodeScanner.php" method="POST" class="form-horizontal">
                        <label><b>SCAN QR CODE CARD NUMBER</b></label>
                        <input type="text" name="card_number" id="card_number" placeholder="CARD NUMBER"
                            class="form-control mx-auto text-center col-sm-6">
                    </form>
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

</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';


// $(document).ready(function () {
//         var myqr = $('#you-qr-result');
//         var cardNumberInput = $('#card_number');
//         var lastResult, countResults = 0;
//         var htmlScanner; // Declare htmlScanner globally

//         // Event listener for camera switch
//         $('input[name="options"]').change(function () {
//             switchCamera($(this).val());
//         });

//         function onScanSuccess(decodeText, decodeResult) {
//             console.log('QR code scanned:', decodeText);

//             if (decodeText !== lastResult) {
//                 ++countResults;
//                 lastResult = decodeText;

//                 // Update the input field with the scanned QR code value
//                 cardNumberInput.val(decodeText);

//                 // Add text to your QR code
//                 myqr.html(`You scanned ${countResults} times: ${decodeText}`);

//                 // Submit the form immediately
//                 console.log('Submitting form...');
//                 document.getElementById('qrForm').submit();
//             }
//         }

//         function switchCamera(camera) {
//             if (htmlScanner) {
//                 // Stop the existing scanner
//                 htmlScanner.stop();
//             }

//             // Initialize the scanner with the selected camera
//             htmlScanner = new Html5QrcodeScanner("my-qr-reader", { fps: 50, qrbox: 500, aspectRatio: 1.0 });
//             htmlScanner.render(onScanSuccess, { facingMode: camera === "1" ? "user" : "environment" });
//         }

//         // Initialize the scanner on page load with the default camera
//         switchCamera("1");
//     });
</script>

