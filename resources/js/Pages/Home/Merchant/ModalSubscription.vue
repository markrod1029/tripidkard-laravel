<!-- ModalSubscription.vue -->

<template>
    <div>
      <!-- Button to trigger the modal -->
      <button type="button" class="btn btn-primary" @click="showModal">Subscribe Now</button>

      <!-- Modal -->
      <div class="modal" id="subscribeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Subscribe to Our Newsletter</h5>
              <button type="button" class="close" @click="hideModal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="subscribe">
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" v-model="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Subscribe</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        email: '',
      };
    },
    methods: {
      showModal() {
        $('#subscribeModal').modal('show'); // Show the modal
      },
      hideModal() {
        $('#subscribeModal').modal('hide'); // Hide the modal
      },
      subscribe() {
        // Here you can implement your subscription logic
        console.log('Subscribing with email:', this.email);
        // Clear the email field after subscribing
        this.email = '';
        // Close the modal
        $('#subscribeModal').modal('hide');
      },
    },
  };
  </script>

  <style scoped>
  /* Add your modal styles here */
  </style>
