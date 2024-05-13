<template>
    <!-- Boxes with images and text -->
    <div class="container mt-5">
        <h1 class="title text-dark font-weight-bold text-center"> Join The Fun</h1>
    </div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-md-4 mb-5">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img src="https://cdn.dribbble.com/users/1046956/screenshots/5931773/media/e508b573ca22aadcf77cff621adf9059.gif" alt="Box Image" class="img-fluid">
            <div class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
              <h2 class="mb-3">Box Title 1</h2>
              <a href="#" class="btn btn-primary align-self-center">Click Here</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img src="https://cdn.dribbble.com/users/1046956/screenshots/5931773/media/e508b573ca22aadcf77cff621adf9059.gif" alt="Box Image" class="img-fluid">
            <div class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
              <h2 class="mb-3">Box Title 2</h2>
              <a href="#" class="btn btn-primary align-self-center">Click Here</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="box position-relative">
            <div class="box-overlay"></div>
            <img src="https://cdn.dribbble.com/users/1046956/screenshots/5931773/media/e508b573ca22aadcf77cff621adf9059.gif" alt="Box Image" class="img-fluid">
            <div class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
              <h2 class="mb-3">Box Title 3</h2>
              <a href="#" class="btn btn-primary align-self-center">Click Here</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Your page content goes here -->
  </template>

  <style scoped>

  .container, .title {
    font-size:45px;
  }
  /* Overlay styles */
  .box-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
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

  <script>
  export default {
    data() {
      return {
        // You can remove the images data since they're not used anymore
      };
    },
  }
  </script>
