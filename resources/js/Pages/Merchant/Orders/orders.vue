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
                            <h4 class="card-title text-white title">Order Cards</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="createMerchants" method="POST"
                                enctype="multipart/form-data">


                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Order Cards Information</h4><br>


                                <div class="input-group mb-3">
                                    <label for="influencer"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Influencer Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                        <select class="form-control" name="influencer_code" v-model="form.card_types">
                                            <option value="" disabled selected>Select Card Types</option>
                                            <option value="VIP">VIP</option>
                                            <option value="Common">Common</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="lname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">total Of
                                        Card</label>

                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-list-ol"></i></span></div>
                                        <input type="number" class="form-control" id="number" name="number" required="">
                                    </div>
                                    <span class="text-danger">*</span>
                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <button type="reset"
                                        class="btn btn-dark waves-effect waves-light ml- text-white ">Reset</button>

                                    <button type="submit" class="btn btn-primary  ml-1" name="">Save</button>
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
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';

import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { debounce } from 'lodash';

const toastr = useToastr();
const customers = ref([]);
const searchQuery = ref([]);

const getCustomers = async () => {
    try {
        const response = await axios.get('/api/customers', {
            params: {
                query: searchQuery.value
            }
        });
        customers.value = response.data;
    } catch (error) {
        console.error('Error fetching services:', error);
    }
}



watch(searchQuery, debounce(() => {
    getCustomers();
}, 100));



onMounted(() => {
    getCustomers();


});

// let deleteCustomer = () => {
//   axios.post('/api/')
// }
</script>
