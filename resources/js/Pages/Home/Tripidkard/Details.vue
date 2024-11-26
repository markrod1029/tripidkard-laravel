<template>
    <div>
      <section class="container mt-5">
        <div class="row align-items-center">
          <!-- Left Column -->
          <div class="col-md-6">
            <div class="animated fadeInLeft text-center">
              <h2 class="font-weight-bold title-details"  >Tripidkard</h2>
              <p class="text-gray decrip-details"  >Welcome to Tripidkard, an innovative platform reshaping the dynamics of online commerce. Serving as a vibrant hub for affiliate merchants, Tripidkard connects businesses with influencers and marketers to expand their reach and drive sales. On the customer front, Tripidkard takes loyalty to new heights by rewarding every purchase with valuable points that can be redeemed for exciting perks. The synergy within Tripidkard creates a unique ecosystem where merchants thrive through affiliation, customers enjoy exclusive benefits, and both parties are immersed in a rewarding and engaging experience. Join us on this journey where success meets partnership, and loyalty is celebrated.</p>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <div class="animated fadeInRight text-center">
              <img src="https://i0.wp.com/tripidkard.com/wp-content/uploads/2023/10/tripidkard-picture-1.png?fit=750%2C750&amp;ssl=1" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>

  <script>
  export default {
    name: 'ElementorToBootstrap',
  }
  </script>

  <style scoped>
  .title-details {
    font-size: 35px;
  }
  .decrip-details {
    font-size: 23px;
  }



/* Mobile and Tablet View */
@media (max-width: 1024px) {

}


/* Mobile View (For smaller screens) */
@media (max-width: 768px) {
    .title-details {
        font-size: 30px;
        /* Adjust for smaller mobile screens */

    }

    .decrip-details {
    font-size: 20px;
  }
}
  </style>
