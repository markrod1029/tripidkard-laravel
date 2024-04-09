<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <!-- title -->
                    <div class="box-header with-border" style="background-color:#367FA9;">
                        <div class="card-header">
                            <h4 class="card-title text-white title">Add New Merchant</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                action="class/customer_crud.php">

                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Merchant Information</h4><br>





                                <div class="input-group mb-3">
                                    <label for="fname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Enterprise</label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-credit-card"></i></span></div>
                                        <select class="form-control" id="enterprise_dropdown" name="enterprise_code"
                                            required="">
                                            <option value="" disabled selected>Select Enterprise Name</option>
                                            <option value="0">None</option>

                                            <option value="">
                                            </option>
                                        </select>
                                    </div>
                                    <span class="text-danger">*</span>
                                </div>

                                <div class="input-group mb-3 d-none" id="merchant_dropdown">
                                    <label for="fname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Merchant</label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-credit-card"></i></span></div>
                                        <select class="form-control" name="merchant_code">
                                            <option value="" disabled selected>Select Merchant Name</option>

                                            <option value="">

                                            </option>
                                        </select>
                                    </div>
                                    <span class="text-danger">*</span>
                                </div>







                                <div class="input-group mb-3">
                                    <label for="lname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">total Of
                                        Card</label>

                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa  fa-sort-numeric-asc"></i></span></div>
                                        <input type="number" class="form-control" id="number" name="number" required="">
                                    </div>
                                    <span class="text-danger">*</span>
                                </div>

                                <div class=" box-footer text-right">
                                    <button type="submit" class="btn btn-primary" name="tripidkard_number ">Save</button>
                                    <button type="reset" class="btn btn-dark waves-effect waves-light ml-1">Reset</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<script setup>
import { ref } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

</script>
