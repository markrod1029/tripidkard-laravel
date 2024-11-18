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
                            <h4 class="card-title text-white title" v-if="influencertitle">Update Influencer</h4>
                            <h4 class="card-title text-white title" v-else>Add New Influencer</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="handleSubmit" method="POST"
                                enctype="multipart/form-data">


                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Influencer Information</h4><br>

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
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Blog
                                            Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-store"></i></span></div>
                                            <input v-model="form.blog_name" type="text" class="form-control"
                                                id="business_name" name="business_name" value="" required="">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3">
                                        <label for="business_category"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">BLog
                                            Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-store"></i></span></div>
                                            <input v-model="form.blog_category" type="text" class="form-control"
                                                id="business_category" name="business_category" value="" required="">
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
import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useToastr } from '@/toastr.js';
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

const currentStep = ref(1);
const totalSteps = 3;

function nextStep() {
    let isValid = true;

    if (currentStep.value === 1) {
        isValid = form.fname && form.lname && form.contact && form.email;
        if (!isValid) {
            toastr.error('Please fill all required fields in Step 1.');
        }
    } else if (currentStep.value === 2) {
        isValid = form.blog_name && form.blog_category;
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
}
function backStep() {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
}

const route = useRoute();
const router = useRouter();
const toastr = useToastr();

const influencertitle = ref(false);


const form = reactive({
    fname: '',
    mname: '',
    lname: '',
    contact: '',
    email: '',
    blog_name: '',
    blog_category: '',
    zip: '',
    street: '',
    city: '',
    province: '',

});





const getInfluencers = async () => {
    try {
        const response = await axios.get(`/api/influencers/${route.params.id}/edit`);
        const data = response.data; // makuha mo ang data mula sa response
        form.fname = data.user.fname;
        form.mname = data.user.mname;
        form.lname = data.user.lname;
        form.contact = data.user.contact;
        form.email = data.user.email;
        form.blog_name = data.blog_name;
        form.blog_category = data.blog_category;
        form.zip = data.zip;
        form.street = data.street;
        form.city = data.city;
        form.province = data.province;
        console.log(form.business_name);
    } catch (error) {
        actions.setErrors(error.response.data.errors);
    }

}

const updateInfluencers = async () => {
    try {
        const response = await axios.post(`/api/influencers/${route.params.id}/edit`, form);
        toastr.success('Influencers Updated Successfully');
        router.push('/admin/influencer');
    } catch (error) {
        console.log(error);
        toastr.error('Failed to update merchant', error);
    }
}


const createInfluencers = async (values, actions) => {
    try {
        await axios.post('/api/influencers/create', form);
        router.push('/admin/influencer');
        toastr.success('Influencers Added Successfully');
    } catch (error) {
        actions.setErrors(error.response.data.errors);
    }
}

const handleSubmit = (values, actions) => {
    if(influencertitle.value) {
        updateInfluencers(values, actions);
    } else {
        createInfluencers(values, actions);
    }
}

onMounted(() => {
    if (route.name === 'admin.influencer.edit') {
        influencertitle.value = true;
        getInfluencers();
    }

});
</script>
