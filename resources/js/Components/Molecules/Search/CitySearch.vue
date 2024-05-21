<template>
    <div class="container">
      <div class="search-top text-center mb-5 mt-5">
        <h2 class="font-weight-bold" style="font-size: 40px;">Select City</h2>
        <p class="search-top__subtitle" style="font-size:18px;">Search for cities in {{ province }}</p>
      </div>

      <form @submit.prevent="searchByCity" class="search-form row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="form-group">
            <select v-model="city" class="form-control city-select">
              <option disabled selected>Select City</option>
              <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
            </select>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="form-group">
            <select v-model="category" class="form-control category-select">
              <option disabled selected>Select Category</option>
              <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
            </select>
          </div>
        </div>



        <div class="col-md-1 mb-3 d-flex justify-content-center align-items-center">
          <div class="form-group">
            <button type="submit" class="btn btn-lg btn-dark btn-search">
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
        province: this.$route.query.province || '',
        city: '',
        category: '',
        cities: [],
        region1Provinces: ['Ilocos Norte', 'Ilocos Sur', 'La Union', 'Pangasinan'], // Provinces in Region 1
        region1Cities: {
          'Ilocos Norte': [
            'Adams', 'Bacarra', 'Badoc', 'Bangui', 'Banna', 'Burgos', 'Carasi', 'Currimao', 'Dingras', 'Dumalneg',
            'Marcos', 'Nueva Era', 'Pagudpud', 'Paoay', 'Pasuquin', 'Piddig', 'Pinili', 'San Nicolas', 'Sarrat', 'Solsona',
            'Vintar'
          ],
          'Ilocos Sur': [
            'Alilem', 'Banayoyo', 'Bantay', 'Burgos', 'Cabugao', 'Caoayan', 'Cervantes', 'Galimuyod', 'Gregorio del Pilar',
            'Lidlidda', 'Magsingal', 'Nagbukel', 'Narvacan', 'Quirino', 'Salcedo', 'San Emilio', 'San Esteban', 'San Ildefonso',
            'San Juan', 'San Vicente', 'Santa', 'Santa Catalina', 'Santa Cruz', 'Santa Lucia', 'Santa Maria', 'Santiago', 'Santo Domingo',
            'Sigay', 'Sinait', 'Sugpon', 'Suyo', 'Tagudin', 'Vigan'
          ],
          'La Union': [
            'Agoo', 'Aringay', 'Bacnotan', 'Bagulin', 'Balaoan', 'Bangar', 'Bauang', 'Burgos', 'Caba', 'Luna', 'Naguilian',
            'Pugo', 'Rosario', 'San Fernando', 'San Gabriel', 'San Juan', 'Santo Tomas', 'Santol', 'Sudipen', 'Tubao'
          ],
          'Pangasinan': [
            'Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Asingan', 'Balungao', 'Bani', 'Basista', 'Bautista', 'Bayambang',
            'Binalonan', 'Binmaley', 'Bolinao', 'Bugallon', 'Burgos', 'Calasiao', 'Dagupan', 'Dasol', 'Infanta', 'Labrador',
            'Laoac', 'Lingayen', 'Mabini', 'Malasiqui', 'Manaoag', 'Mangaldan', 'Mangatarem', 'Mapandan', 'Natividad', 'Pozorrubio',
            'Rosales', 'San Carlos', 'San Fabian', 'San Jacinto', 'San Manuel', 'San Nicolas', 'San Quintin', 'Santa Barbara',
            'Santa Maria', 'Santo Tomas', 'Sison', 'Sual', 'Tayug', 'Umingan', 'Urbiztondo', 'Urdaneta', 'Villasis'
          ]
        },

        categories: [
          'Retail', 'Food and Beverage', 'Health and Wellness', 'Beauty and Personal Care',
          'Travel and Leisure', 'Entertainment', 'Automotive', 'Home and Garden',
          'Electronics and Gadgets', 'Fashion and Apparel', 'Financial Services',
          'Professional Services', 'Education and Training', 'Technology',
          'Real Estate', 'Hospitality', 'Sports and Recreation', 'Pet Services',
          'Media and Advertising', 'Non-Profit and Community Services'
        ]

      };
    },
    watch: {
      province(newProvince) {
        this.updateCities(newProvince);
      }
    },
    created() {
      this.updateCities(this.province);
    },
    methods: {
      updateCities(selectedProvince) {
        if (selectedProvince) {
          this.cities = this.region1Cities[selectedProvince];
        } else {
          this.cities = [];
        }
      },
      searchByCity() {
          // Redirect to the search result page with selected city
          this.$router.push({
            name: 'MerchantResultCity',
            query: {
              province: this.province,
              city: this.city,
              category: this.category,
            }
          });
      }
    }
  };
  </script>

  <style>
  .category-select, .city-select {
    color: black !important;
    height: 3rem;
  }
  </style>
