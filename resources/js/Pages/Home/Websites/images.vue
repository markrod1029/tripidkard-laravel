<template>
    <!-- Boxes with images and text -->
    <div class="container mt-5">
      <h2 class="font-weight-bold mb-4 text-center">{{ merchant.business_name }} Images</h2>
    </div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-md-4 mb-5">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img :src="merchant.photo1 ? `/storage/${merchant.photo1}` : '/storage/img/raffle.jpg'" alt="Box Image" class="img-fluid">
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img :src="merchant.photo2 ? `/storage/${merchant.photo2}` : '/storage/img/points.jpg'" alt="Box Image" class="img-fluid">
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img :src="merchant.photo3 ? `/storage/${merchant.photo3}` : '/storage/img/event.jpg'" alt="Box Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      merchant: {
        type: Object,
        required: true
      }
    }
  }
  </script>

  <style scoped>
  .container,
  .title {
    font-size: 45px;
  }

  /* Overlay styles */
  .box-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    transition: background-color 0.3s ease; /* Smooth transition */
  }

  /* Remove overlay on hover */
  .box:hover .box-overlay {
    background-color: rgba(0, 0, 0, 0); /* Fully transparent */
  }

  /* Box styles */
  .box {
    overflow: hidden;
    position: relative;
    height: 500px; /* Adjust height as needed */
  }

  .box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .box-content {
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
  }
  </style>
