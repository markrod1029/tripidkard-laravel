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
                            <h4 class="card-title text-white title">{{ merchanttitle ? 'Update Merchant' : 'Add New Merchant' }}</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="handleSubmit" method="POST" enctype="multipart/form-data">

                                <!-- Merchant Information -->
                                <h4 class="card-title text-dark mb-3">Merchant Information</h4><br>

                                <div v-show="currentStep === 1">
                                    <!-- Step 1: Personal Information -->
                                    <div class="input-group mb-3">
                                        <label for="fname" class="col-sm-2 text-right col-xs-2 col-form-label text-muted">First Name <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                            <input v-model="form.fname" type="text" class="form-control" id="fname" name="fname" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="mname" class="col-sm-2 text-right col-xs-2 col-form-label text-muted">Middle Name</label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                            <input v-model="form.mname" type="text" class="form-control" placeholder="Optional" id="mname" name="mname">
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="lname" class="col-sm-2 text-right col-xs-2 col-form-label text-muted">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                            <input v-model="form.lname" type="text" class="form-control" id="lname" name="lname" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="contact" class="col-sm-2 text-right col-xs-2 col-form-label text-muted">Contact <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                                            <input v-model="form.contact" type="text" class="form-control" id="contact" name="contact" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="email" class="col-sm-2 text-right col-xs-2 col-form-label text-muted">Email <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                            <input v-model="form.email" type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>

                                <div v-show="currentStep === 2">
                                    <!-- Step 2: Business Information -->
                                    <div class="input-group mb-3">
                                        <label for="business_name" class="col-sm-2 text-right control-label col-form-label text-muted">Business Name <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-store"></i></span></div>
                                            <input v-model="form.business_name" type="text" class="form-control" id="business_name" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="business_category" class="col-sm-2 text-right control-label col-form-label text-muted">Business Category <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tags"></i></span></div>
                                            <input v-model="form.business_category" type="text" class="form-control" id="business_category" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="business_sub_category" class="col-sm-2 text-right control-label col-form-label text-muted">Business Sub-Category</label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tags"></i></span></div>
                                            <input v-model="form.business_sub_category" type="text" class="form-control" id="business_sub_category">
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="dtiNo" class="col-sm-2 text-right control-label col-form-label text-muted">DTI No.</label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-file-alt"></i></span></div>
                                            <input v-model="form.dtiNo" type="text" class="form-control" id="dtiNo">
                                        </div>
                                    </div>
                                </div>

                                <div v-show="currentStep === 3">
                                    <!-- Step 3: Address Information -->
                                    <div class="input-group mb-3">
                                        <label for="zip" class="col-sm-2 text-right control-label col-form-label text-muted">ZIP Code <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-home"></i></span></div>
                                            <input v-model="form.zip" type="text" class="form-control" id="zip" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="street" class="col-sm-2 text-right control-label col-form-label text-muted">Street <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-road"></i></span></div>
                                            <input v-model="form.street" type="text" class="form-control" id="street" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="city" class="col-sm-2 text-right control-label col-form-label text-muted">City <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-city"></i></span></div>
                                            <input v-model="form.city" type="text" class="form-control" id="city" required>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="province" class="col-sm-2 text-right control-label col-form-label text-muted">Province <span class="text-danger">*</span></label>
                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map"></i></span></div>
                                            <input v-model="form.province" type="text" class="form-control" id="province" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <a v-if="currentStep !== 1" @click="backStep" class="btn btn-default ">Back</a>
                                    <button v-if="currentStep < totalSteps" type="button" class="btn btn-primary ml-2" @click="nextStep">Next</button>
                                    <button v-if="currentStep === totalSteps" type="submit" class="btn btn-success ml-2">Submit</button>
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

const form = reactive({
    fname: '',
    mname: '',
    lname: '',
    contact: '',
    email: '',
    business_name: '',
    business_category: '',
    business_sub_category: '',
    dtiNo: '',
    zip: '',
    street: '',
    city: '',
    province: '',
});

const toastr = useToastr();
const route = useRoute();
const router = useRouter();
const merchanttitle = ref(false);

const nextStep = () => {
    // Validate fields based on the current step
    let isValid = true;

    if (currentStep.value === 1) {
        isValid = form.fname && form.lname && form.contact && form.email;
        if (!isValid) {
            toastr.error('Please fill all required fields in Step 1.');
        }
    } else if (currentStep.value === 2) {
        isValid = form.business_name && form.business_category;
        if (!isValid) {
            toastr.error('Please fill all required fields in Step 2.');
        }
    } else if (currentStep.value === 3) {
        isValid = form.zip && form.street && form.city && form.province;
        if (!isValid) {
            toastr.error('Please fill all required fields in Step 3.');
        }
    }

    if (isValid) {
        currentStep.value++;
    }
};

const backStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const getMerchants = async () => {
    try {
        const response = await axios.get(`/api/merchants/${route.params.id}/edit`);
        Object.assign(form, response.data.user, {
            business_name: response.data.business_name,
            business_category: response.data.business_category,
            business_sub_category: response.data.business_sub_category,
            dtiNo: response.data.dti,
            zip: response.data.zip,
            street: response.data.street,
            city: response.data.city,
            province: response.data.province,
        });
    } catch (error) {
        toastr.error('Failed to load merchant data');
    }
};

const updateMerchants = async () => {
    try {
        await axios.put(`/api/merchants/${route.params.id}/update`, form);
        toastr.success('Merchant Updated Successfully');
        router.push('/admin/merchant');
    } catch (error) {
        toastr.error('Failed to update merchant', error.response.data.message || 'Unknown error');
    }
};

const createMerchants = async () => {
    try {
        await axios.post('/api/merchants/create', form);
        toastr.success('Merchant Added Successfully');
        router.push('/admin/merchant');
    } catch (error) {
        toastr.error('Failed to add merchant', error.response.data.message || 'Unknown error');
    }
};

const handleSubmit = () => {
    if (merchanttitle.value) {
        updateMerchants();
    } else {
        createMerchants();
    }
};

onMounted(() => {
    if (route.name === 'admin.merchant.edit') {
        merchanttitle.value = true;
        getMerchants();
    }
});
</script>
