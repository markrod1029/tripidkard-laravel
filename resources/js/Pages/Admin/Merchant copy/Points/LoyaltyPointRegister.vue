<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />


        <section class="content">

            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto  custom-container">

                    <img class="img-fluid mx-auto"
                        src="https://tripidkard.com/wp-content/uploads/2023/10/tripid-card-ver.-2-1.png" width="150"
                        height="100" />
                            <h3>Register Loyalty Points</h3>
                            <form method="POST" action="class/loyalty_points_crud.php">

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" id="card_code" name="card_code"
                                            placeholder="Card Number"
                                            value=""
                                            required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" id="product_code" name="product_code"
                                            value=""
                                            x placeholder="Product Code" required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>


                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" id="price" name="price"
                                            placeholder="Total Price"
                                            value=""
                                             required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" id="loyalty_points"
                                            name="loyalty_points" placeholder="Total Loyalty Points"
                                            value=""
                                            required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>


                                <input type="text" class="form-control" id="loyalty_id" name="loyalty_id"
                                    value="" placeholder="Total Loyalty Points" hidden>
                                <input type="text" class="form-control" id="merchant_id" name="enterprise_id"
                                    value="" placeholder="Total Loyalty Points" hidden>
                                <button type="submit"
                                    name="<"
                                    class="btn btn-primary">Submit</button>
                            </form>

                </div>
            </div>


        </section>


       
    </div>

    <Footer />
</template>

<script setup>
import { ref } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

</script>
