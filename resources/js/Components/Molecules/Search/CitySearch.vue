<template>
    <div class="container">
      <div class="search-top text-center mb-5 mt-5">
        <h2 class="font-weight-bold" style="font-size: 40px;">Where Do you Want To Go?</h2>
        <p class="search-top__subtitle" style="font-size:18px;">Search for their Best Offer</p>
      </div>

      <form @submit.prevent="searchMerchants" class="search-form row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="form-group">
            <div class="directorist-input-box">
              <input type="text" v-model="category" class="form-control category-select py-4"
                placeholder="Select Category">
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="form-group">
            <div class="directorist-input-box">
              <input type="text" v-model="city" class="form-control city-select py-4"
                placeholder="Select City">
            </div>
          </div>
        </div>
        <div class="col-md-1 mb-3 d-flex justify-content-center align-items-center">
          <div class="form-group">
            <button type="submit" class="btn btn-lg btn-dark btn-search ">
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
        category: '',
        city: '',
      };
    },
    methods: {
      searchMerchants() {
        const currentRoute = this.$route;
        const province = currentRoute.query.province || ''; // Get the province from the current route's query, default to empty string if not present
        this.$router.push({
          name: 'MerchantResultCity',
          query: {
            province: province,
            category: this.category,
            city: this.city
          }
        });
      }
    }
  };
  </script>
