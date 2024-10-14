<template>
  <div class="container my-5 p-3">
    <div class="row">
      <!-- Feature Section -->
      <div class="col-md-6 text-center">
        <img :src="merchant.avatar ? `${merchant.avatar}` : 'https://via.placeholder.com/510x360'" alt="Feature Image" class="img-fluid rounded" width="400">
      </div>

      <!-- FAQ Section -->
      <div class="col-md-6">
        <h2 class="font-weight-bold mb-4 text-center">{{ merchant.business_name }}</h2>
        <div class="accordion">
          <p class="text-gray " style="font-size:18px;">
            {{ merchant.description }}
          </p>
          <ul class="list-unstyled mt-4 text-gray" style="font-size:18px;" >

            <li class="mb-1">
              <strong>Business:</strong> {{ merchant.business_category }} > {{ merchant.business_sub_category }}
            </li>

            <li class="mb-1">
              <strong>Discount:</strong> {{ merchant.discount }}%
            </li>
            <li class="mb-1">
              <strong>Email:</strong> <a :href="'mailto:' + merchant.email">{{ merchant.email }}</a>
            </li>
            <li class="mb-1">
              <strong>Contact:</strong> {{ merchant.contact }}
            </li>

            <li class="mb-1">
              <strong>Address:</strong> {{ merchant.zip }} {{ merchant.street }} {{ merchant.city }} {{ merchant.province }}
            </li>

          </ul>
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

    },
  },


}
</script>

<style scoped>
.text-gray {
  color: gray;
}

.btn-link {
  text-decoration: none;
  color: #007bff;
}

.btn-link:hover {
  text-decoration: underline;
}

.img-fluid {
  max-width: 100%;
  height: auto;
}

.lead {
  font-size: 1.25rem;
  font-weight: 300;
}

.rotate {
  transition: transform 0.3s;
}

.rotate {
  transform: rotate(180deg);
}

.card-header {
  cursor: pointer;
}
</style>
