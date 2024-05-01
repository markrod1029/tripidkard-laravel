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
                            <h4 class="card-title text-white title">Add New Tripidkard</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="createMerchants" method="POST"
                                enctype="multipart/form-data">


                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">TripidKard Information</h4><br>

                                <div class="input-group mb-3">
                                    <label for="fname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Enterprise
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-credit-card"></i></span></div>
                                        <select class="form-control" id="enterprise_dropdown" name="enterprise_code"
                                            v-model="form.enterprise_id">
                                            <option value="" disabled selected>Select Enterprise Name</option>
                                            <option v-for="enterprise in enterprises" :value="enterprise.id"
                                                :key="enterprise.id"> {{ enterprise.business_name }}</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="input-group mb-3" id="merchant_dropdown"
                                    v-if="form.enterprise_id !== '' && form.enterprise_id === 'None'">
                                    <label for="fname"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Merchant
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-credit-card"></i></span></div>
                                        <select class="form-control" name="merchant_code" v-model="form.merchant_id">
                                            <option value="" disabled selected>Select Merchant Name</option>
                                            <option v-for="merchant in merchants" :value="merchant.id"
                                                :key="merchant.id"> {{ merchant.business_name }}</option>
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
                                                    class="fa fa-list-ol"></i></span></div>
                                        <input v-model="form.tripidkard_number" type="number" class="form-control"
                                            id="number" name="number" required="">
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
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useToastr } from '@/toastr.js';
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';


const router = useRouter();
const toastr = useToastr();

const enterprises = ref([]);
const merchants = ref([]);

const form = reactive({
    enterprise_id: '',
    merchant_id: '',
    tripidkard_number: '',


});

const createMerchants = async (values, actions) => {
    try {
        await axios.post('/api/tripidkards/create', form);
        router.push('/admin/tripidkard');
        toastr.success('Tripidkard Added Successfully');
    } catch (error) {
        actions.setErrors(error.response.data.errors);
    }
}


const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants');
        merchants.value = response.data; // Assuming your API response contains an array of merchants
    } catch (error) {
        console.error('Error fetching Merchants:', error);
    }
}


const getEnterprises = async () => {
    try {
        const response = await axios.get('/api/enterprises');
        enterprises.value = response.data; // Assuming your API response contains an array of merchants
    } catch (error) {
        console.error('Error fetching Enterprises:', error);
    }
}

onMounted(() => {
    getMerchants();
    getEnterprises();
});
</script>
