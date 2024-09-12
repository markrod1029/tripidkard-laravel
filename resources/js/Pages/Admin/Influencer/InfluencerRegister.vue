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
                            <h4 class="card-title text-white title" v-if="merchanttitle">Update Merchant</h4>
                            <h4 class="card-title text-white title" v-else>Add New Merchant</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="handleSubmit" method="POST"
                                enctype="multipart/form-data">


                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Merchant Information</h4><br>

                                <div v-show="currentStep === 1">
                                    <!-- Step 1: Personal Information -->
                                    <div class="input-group mb-3">
                                        <label for="fname"
                                            class="col-sm-2 text-right  col-xs-2 col-form-label text-muted">First Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input v-model="form.fname" type="text" class="form-control" id="fname"
                                                name="fname" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="mname"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Middle
                                            Name</label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input v-model="form.mname" type="text" class="form-control" id="mname"
                                                name="mname" value="" placeholder="Optional">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="lname"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Last
                                            Name
                                            <span class="text-danger">*</span>

                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input v-model="form.lname" type="text" class="form-control" id="lname"
                                                name="lname" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="contact"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Phone
                                            Number
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-phone"></i></span></div>
                                            <input v-model="form.contact" type="text" class="form-control" id="contact"
                                                name="contact" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="email"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Email
                                            Address
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-envelope"></i></span></div>
                                            <input v-model="form.email" type="email" class="form-control" id="email"
                                                name="email" value="" required="">
                                        </div>
                                    </div>
                                </div>


                                <div v-show="currentStep === 2">
                                    <!-- Step 2 : Business Information -->

                                    <div class="input-group mb-3">
                                        <label for="business_name"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Busine
                                            Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-store"></i></span></div>
                                            <input v-model="form.business_name" type="text" class="form-control"
                                                id="business_name" name="business_name" value="" required="">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3">
                                        <label for="business_category"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Business
                                            Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-store"></i></span></div>
                                            <input v-model="form.business_category" type="text" class="form-control"
                                                id="business_category" name="business_category" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="business_sub_category"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Business
                                            Sub Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-store"></i></span></div>
                                            <input v-model="form.business_sub_category" type="text" class="form-control"
                                                id="business_sub_category" name="business_sub_category" value=""
                                                required="">
                                        </div>
                                    </div>



                                    <!-- <div class="input-group mb-3">
                                        <label for="cono1"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Enterprise</label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-home"></i></span></div>
                                            <select class="form-control form-control-line size " name="enterprise"  required>
                                                <option value="0" selected>Select Enterprise</option>

                                            </select>
                                        </div>
                                        <span class="text-danger">*</span>

                                    </div> -->


                                </div>

                                <div v-show="currentStep === 3" style="display: none;">
                                    <!-- Step 3: Address Information -->

                                    <div class="input-group mb-3">
                                        <label for="zip"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Address
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input v-model="form.zip" type="text" class="form-control" id="zip"
                                                name="zip" placeholder="ZIP Code" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="street"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input v-model="form.street" type="text" class="form-control" id="street"
                                                name="street" placeholder="Street" value="" required>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="city"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input v-model="form.city" type="text" class="form-control" id="city"
                                                name="city" placeholder="City" value="" required>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="province"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input v-model="form.province" type="text" class="form-control"
                                                id="province" name="province" placeholder="Province" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <a v-if="currentStep !== 1" @click="backStep"
                                        class="btn btn-dark waves-effect waves-light ml- text-white ">Back</a>

                                    <a v-if="currentStep !== totalSteps" @click="nextStep"
                                        class="btn btn-primary  ml-1 text-white">Next</a>

                                    <button v-else type="submit" class="btn btn-primary  ml-1" name="">Save</button>
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

const currentStep = ref(1);
const totalSteps = 3;

function nextStep() {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
    }
}
function backStep() {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
}

const route = useRoute();
const router = useRouter();
const toastr = useToastr();

const merchanttitle = ref(false);


const form = reactive({
    fname: '',
    mname: '',
    lname: '',
    contact: '',
    email: '',
    business_name: '',
    business_category: '',
    business_sub_category: '',
    zip: '',
    street: '',
    city: '',
    province: '',

});





const getMerchants = async () => {
    try {
        const response = await axios.get(`/api/merchants/${route.params.id}/edit`);
        const data = response.data; // makuha mo ang data mula sa response
        form.fname = data.user.fname;
        form.mname = data.user.mname;
        form.lname = data.user.lname;
        form.contact = data.user.contact;
        form.email = data.user.email;
        form.business_name = data.business_name;
        form.business_name = data.business_name;
        form.business_category = data.business_category;
        form.business_sub_category = data.business_sub_category;
        form.zip = data.zip;
        form.street = data.street;
        form.city = data.city;
        form.province = data.province;
        console.log(form.business_name);
    } catch (error) {
        actions.setErrors(error.response.data.errors);
    }

}

const updateMerchants = async () => {
    try {
        const response = await axios.post(`/api/merchants/${route.params.id}/edit`, form);
        toastr.success('Merchant Updated Successfully');
        router.push('/admin/merchant');
    } catch (error) {
        console.log(error);
        toastr.error('Failed to update merchant', error);
    }
}


const createMerchants = async (values, actions) => {
    try {
        await axios.post('/api/merchants/create', form);
        router.push('/admin/merchant');
        toastr.success('Merchant Added Successfully');
    } catch (error) {
        actions.setErrors(error.response.data.errors);
    }
}

const handleSubmit = (values, actions) => {
    if(merchanttitle.value) {
        updateMerchants(values, actions);
    } else {
        createMerchants(values, actions);
    }
}

onMounted(() => {
    if (route.name === 'admin.merchant.edit') {
        merchanttitle.value = true;
        getMerchants();
    }

});
</script>
