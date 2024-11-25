<template>
    <!-- Footer section -->
    <footer class="bg-light text-dark py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- First column -->
                <div class="col-md-5 text-center">
                    <!-- Content for the first column -->
                    <a href="/"><img
                            src="/storage/img/logo.jpg"
                            alt="" width="200"></a>
                    <h5 class="">Unlock Savings Everywhere with Tripid Kard.</h5>
                </div>

                <!-- Second column -->
                <div class="col-md-4 quick-link  " >
                    <h5 class="font-weight-bold links">Quick Links</h5>
                    <!-- Listahan ng quick links -->

                    <div class="row  quick-link">

                        <div class="col-md-5">

                            <ul class="list-unstyled">
                                <li><a href="/tripidkard/details" class="text-dark">About Tripidkard</a></li>
                                <li><a href="/merchants" class="text-dark">Merchant </a></li>
                                <li><a href="/join" class="text-dark">How to Join</a></li>
                                <li><a href="/scanner" class="text-dark">Customer Scanner</a></li>
                                <li><a href="/contact-us" class="text-dark">Contact Us</a></li>
                            </ul>
                        </div>

                        <div class="col-md-6">

                            <ul class="list-unstyled">
                                <li><a href="#" class="text-dark">Join The Raffle</a></li>
                                <li><a href="#" class="text-dark">Loyalty Stars </a></li>
                                <li><a href="#" class="text-dark">Upcoming Events</a></li>
                                <li><a href="#" class="text-dark">Merchant Login</a></li>
                            </ul>
                        </div>
                    </div>


                </div>

                <!-- Third column -->
                <div class="col-md-3  quick-link ">
                    <h5 class="font-weight-bold links">Follow Us</h5>
                    <!-- Social media platform links -->
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/TripidKard.Pangasinan">Tripidkard Pangasinan</a></li>
                        <li><a href="https://www.facebook.com/tripidkard">Tripidkard Phillipines</a></li>
                        <!-- Dagdagan ng mga social media links kung kinakailangan -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Border line -->
        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.1); margin-top: 20px;">

        <div class="container-fluid">
            <div class="row">
                <!-- Text sa ibaba sa kaliwang column -->
                <div class="col-md-6">
                    <p>Copyright © 2023 Tripid Kard. Powered by AeonSprint Solutions Incorporated.</p>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>

@media (max-width: 768px) {

    .links {
    border-top: solid black 0.3px; /* Reduced the border size */
    padding: 10px;
    margin-top: 10px;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}
.quick-link {
    text-align:center;
}

}

</style>
