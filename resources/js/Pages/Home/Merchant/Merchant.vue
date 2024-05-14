<template>
    <div class="container">
      <h2 class="text-center mt-5 mb-4 font-weight-bold" style="font-size: 2.3rem; font-family: 'Arial', sans-serif;">Affiliate Merchants</h2>
      <div id="merchantCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="border rounded p-3 mb-3">
              <div class="d-flex justify-content-between">
                <div class=" mb-2 d-flex text-gray">
                  <h5>{{ merchants.length }} Affiliate Merchants</h5>
                </div>
                <div class="col-4">
                  <input type="text" name="" v-model="searchQuery" class="form-control"
                    placeholder="Search Merchant..." id="">
                </div>
              </div>
            </div>

            <div class="row">
              <!-- Merchants cards here -->
              <div class="col-md-4 mb-4" style="overflow: hidden;" v-for="(merchant) in merchants" :key="merchant.id">
                <div class="card float-left">
                  <img src="https://via.placeholder.com/640x360" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title mb-3 font-weight-bold">{{ merchant.business_name }}</h5>
                    <div>
                      <p class="card-text my-2"> <i class=" fas fa-percent text-gray"
                          style="font-size:12px;"></i> &nbsp; 10% Discount</p>
                    </div>
                    <div>
                      <p class="card-text my-2"> <i class=" fas fa-envelope text-gray"
                          style="font-size:12px;"></i> &nbsp; {{ merchant.email }}</p>
                    </div>
                    <div>
                      <p class="card-text mt-2 mb-3"> <i class="fa fa-map-marker text-gray"
                          style="font-size:12px;"></i> &nbsp; {{ merchant.zip }} {{ merchant.street }} {{ merchant.city }} {{
                        merchant.province }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top  pt-2">
                      <span>{{ merchant.business_category }} > {{ merchant.business_sub_category }}</span>
                      <i class="text-gray fas fa-eye" style="font-size:15px;"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of merchants cards -->
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

  <script setup>
  import axios from "axios";
  import { onMounted, ref, watch } from "vue";
  import { debounce } from 'lodash';

  const searchQuery = ref('');
  const merchants = ref([]);

  const getMerchants = async () => {
    try {
      const response = await axios.get('/api/merchants', {
        params: {
          query: searchQuery.value,
        }
      });
      merchants.value = response.data;
    } catch (error) {
      console.error('Error fetching merchant:', error);
    }
  }

  watch(searchQuery, debounce(() => {
    getMerchants();
  }, 100));

  onMounted(() => {
    getMerchants();
  });
  </script>

  <style scoped>
    .text-gray {
      color: gray;
    }
  </style>
