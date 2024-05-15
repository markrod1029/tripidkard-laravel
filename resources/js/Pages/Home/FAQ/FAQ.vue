<template>
    <div class="container my-5">
      <div class="row">
        <!-- FAQ Section -->
        <div class="col-md-6">
          <h2 class="font-weight-bold mb-4">Frequently Asked Questions</h2>
          <div class="accordion" id="faqAccordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    What is Tripid Kard?
                  </button>
                </h5>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                <div class="card-body">
                  Tripid Kard is a loyalty card that allows you to unlock savings at various merchants.
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How do I join?
                  </button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                <div class="card-body">
                  You can join by signing up on our website and purchasing a Tripid Kard.
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Where can I use Tripid Kard?
                  </button>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                <div class="card-body">
                  Tripid Kard can be used at all participating merchants listed on our website.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Feature Section -->
        <div class="col-md-6 text-center">
          <img src="https://via.placeholder.com/500x300" alt="Feature Image" class="img-fluid rounded">
          <h3 class="mt-4">Unlock Savings Everywhere</h3>
          <p class="lead">With Tripid Kard, you can enjoy discounts and exclusive offers from various merchants.</p>
        </div>
      </div>
    </div>
  </template>

  <script setup>
    // No specific JavaScript is needed for this layout, but you can add your custom logic if required
  </script>

  <style scoped>
    .accordion .card-header {
      background-color: #f8f9fa;
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
  </style>
