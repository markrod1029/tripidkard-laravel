<template>
    <div class="container">
      <h2 class="text-center mb-4 font-weight-bold">Affiliate Merchants</h2>
      <div id="merchantCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
              <div class="col-md-4 mb-4" style="overflow: hidden;">
                <div class="card float-left">
                  <img src="https://via.placeholder.com/640x360" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Ambro Shawarma and Grill</h5>
                    <p class="card-text">10% Discount</p>
                    <p class="card-text">Dagupan City, Pangasinan</p>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                      <span>Restaurant</span>
                      <i class="fas fa-eye"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4" style="overflow: hidden;">
                <div class="card float-left">
                  <img src="https://via.placeholder.com/640x360" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Ambro Shawarma and Grill</h5>
                    <p class="card-text">10% Discount</p>
                    <p class="card-text">Dagupan City, Pangasinan</p>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                      <span>Restaurant</span>
                      <i class="fas fa-eye"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4" style="overflow: hidden;">
                <div class="card float-left">
                  <img src="https://via.placeholder.com/640x360" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Ambro Shawarma and Grill</h5>
                    <p class="card-text">10% Discount</p>
                    <p class="card-text">Dagupan City, Pangasinan</p>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                      <span>Restaurant</span>
                      <i class="fas fa-eye"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4" style="overflow: hidden;">
                <div class="card float-left">
                  <img src="https://via.placeholder.com/640x360" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Ambro Shawarma and Grill</h5>
                    <p class="card-text">10% Discount</p>
                    <p class="card-text">Dagupan City, Pangasinan</p>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                      <span>Restaurant</span>
                      <i class="fas fa-eye"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Add more carousel items as needed -->
        </div>
        <a class="carousel-control-prev" href="#merchantCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#merchantCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'MerchantCarousel',
  }
  </script>

  <style scoped>
  #merchantCarousel {
    margin-right: 0;
  }

  .carousel-inner {
    margin-left: auto;
    margin-right: auto;
  }

  .carousel-item-next,
  .carousel-item-prev,
  .carousel-item.active {
    display: flex;
  }

  .card-title {
    font-size: 1.25rem;
  }

  .card-text {
    font-size: 1rem;
  }

  .fa-eye {
    font-size: 1.2rem;
    color: #333; /* Change the color as needed */
  }
  </style>
