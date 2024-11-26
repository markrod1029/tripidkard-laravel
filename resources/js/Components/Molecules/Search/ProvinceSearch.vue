<template>
    <div class="container">
      <div class="search-top text-center mb-5 mt-5">
        <h2 class="font-weight-bold province-title-search" >Where Do you Want To Go?</h2>
        <p class="search-top__subtitle province-subtitle-search" >Search for their Best Offer</p>
      </div>

      <form @submit.prevent="searchByProvince" class="search-form row justify-content-center">
        <div class="col-md-3 mb-3">
          <div class="form-group">
            <select v-model="province" class="form-control province-select" required>
              <option value="" disabled selected style>Select Province</option>
              <option v-for="province in region1Provinces" :value="province">{{ province }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-1 mb-3 d-flex justify-content-center align-items-center">
          <div class="form-group">
            <button type="submit" class="btn btn-block btn-lg d-block btn-dark btn-search">
              <i class="icon-search"></i> Search
            </button>
          </div>
        </div>
      </form>
    </div>
  </template>

<script>
export default {
  data() {
    return {
      province: '',
      region1Provinces: ['Ilocos Norte', 'Ilocos Sur', 'La Union', 'Pangasinan'] // Provinces in Region 1
    };
  },
  methods: {
    searchByProvince() {
      if (this.province) {
        // Pass selected province to citySearch component
        this.$router.push({
          name: 'merchant-result-province',
          query: {
            province: this.province
          }
        });
      } else {
        // Handle no province selected
      }
    }
  }
};
</script>


  <style>
  .province-select {
    color: black !important;
    height: 3rem;
  }
  .province-title-search{
    font-size: 40px;
  }
  .province-subtitle-search{
    font-size: 18px;

  }


/* Mobile and Tablet View */
@media (max-width: 1024px) {
    .h1-title {
        text-align:center;
    }
    .tagline {
    position: absolute;
    top: 30%;
    width: 90%;
  }

}

/* Mobile View (For smaller screens) */
@media (max-width: 768px) {
    .province-title-search{
        font-size: 29px; /* Adjust for smaller mobile screens */
    }
    .tagline {
    position: absolute;
    top: 45%;
    width: 90%;

  }
}
  </style>
