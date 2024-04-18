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
                            <h4 class="card-title text-white title" v-if="editCustomerTitle">Update New Customer</h4>
                            <h4 class="card-title text-white title" v-else>Add New Customer</h4>
                        </div>
                    </div>
                    <div v-if="error" class="alert alert-danger">{{ error }}</div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="handleSubmit" method="POST"
                                enctype="multipart/form-data">

                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Customer Information</h4><br>

                                <div v-show="currentStep === 1">
                                    <!-- Step 1: Personal Information -->
                                    <div class="input-group mb-3">
                                        <label for="Customer"
                                            class="col-sm-2 col-xs-2 text-right col-form-label text-muted">Customer
                                            Number
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-credit-card"></i></span></div>
                                            <input type="text" v-model="form.customer_card_num" class="form-control"
                                                id="customer_code" name="customer_code" value="" required="">

                                            </div>

                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="fname"
                                            class="col-sm-2 text-right  col-xs-2 col-form-label text-muted">First Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input type="text" v-model="form.fname" class="form-control" id="fname"
                                                name="fname" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="mname"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Middle
                                            Name</label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input type="text" v-model="form.mname" class="form-control" id="mname"
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
                                            <input type="text" v-model="form.lname" class="form-control" id="lname"
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
                                            <input type="text" v-model="form.contact" class="form-control" id="contact"
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
                                            <input type="email" v-model="form.email" class="form-control" id="email"
                                                name="email" value="" required="">
                                        </div>
                                    </div>
                                </div>

                                <div v-show="currentStep === 2" style="display: none;">
                                    <!-- Step 2: Business Information -->

                                    <div class="input-group mb-3">
                                        <label for="zip"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Birth
                                            Date
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-birthday-cake"></i></span></div>
                                            <input type="date" v-model="form.bdate" class="form-control" id="bdate"
                                                name="bdate" placeholder="Optional" value="">
                                        </div>
                                    </div>





                                    <div class="input-group mb-3">
                                        <label for="zip"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Address
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.zip" class="form-control" id="zip"
                                                name="zip" placeholder="Optional" value="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="street"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Street
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.street" class="form-control" id="street"
                                                name="street" placeholder="Optional" value="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="city"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">City
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.city" class="form-control" id="city"
                                                name="city" placeholder="Optional" value="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="province"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Province
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.province" class="form-control"
                                                id="province" name="province" placeholder="Optional" value="">
                                        </div>
                                    </div>

                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <button v-if="currentStep !== 1" @click="backStep"
                                        class="btn btn-dark waves-effect waves-light ml-5 ">Back</button>
                                    <button v-if="currentStep !== totalSteps" @click="nextStep"
                                        class="btn btn-primary  ml-1">Next</button>
                                    <button v-else type="submit" class="btn btn-primary ml-1" name="">Save</button>
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

import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useToastr } from '@/toastr.js';
// import { useRoute, useRouter } from 'vue-route';
import { useRouter, useRoute } from 'vue-router';



const currentStep = ref(1);
const totalSteps = 2;

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


const toastr = useToastr();
const router = useRouter();
const route = useRoute();

const customers = ref([]);

const form = reactive({
    customer_card_num: '',
    fname: '',
    mname: '',
    lname: '',
    contact: '',
    bdate: '',
    email: '',
    zip: '',
    street: '',
    province: '',

});

//Display Customer In Form

let getCustomers = () => {
    axios.get(`/api/customers/${route.params.id}/edit`)
        .then(({ data }) => {
            // Assign data to the form fields
            form.customer_card_num = data.customer_card_num;
            form.fname = data.fname;
            form.mname = data.mname;
            form.lname = data.lname;
            form.contact = data.contact;
            form.bdate = data.bdate;
            form.email = data.email;
            form.zip = data.zip;
            form.street = data.street;
            form.city = data.city;
            form.province = data.province;
        })
        .catch(err => {
            console.error(err);
        });
}


const error = ref(null); // Idagdag ang variable para sa error message

// Add New Customer
const createCustomer = (values, actions) => {
    axios.post('/api/customers/register', form)
        .then((response) => {
            router.push('/admin/customer');
            toastr.success('Customer Added Successfuly');
        })
        .catch((error) => {
            if (actions && actions.setErrors) {
                actions.setErrors(error.response.data.errors);
            }
            error.value = error.response.data.error;
            console.log(error.response.data);
        })
};

let updateCustomer = (values, actions) => {
    axios.post(`/api/customers/${route.params.id}/edit`, form)
        .then((response) => {
            router.push('/admin/customer');
            toastr.success('Customer Updated Successfuly');
        })
        .catch((error) => {
            if (actions && actions.setErrors) {
                actions.setErrors(error.response.data.errors);
            }
            error.value = error.response.data.error;
        })
}

const editCustomerTitle = ref(false);

onMounted(() => {
    if (route.name === 'admin.customer.edit') {
        editCustomerTitle.value = true;
        getCustomers();
    }
});

const handleSubmit = (values, actions) => {
    if (editCustomerTitle.value) {
        updateCustomer(values, actions);
    } else {
        createCustomer(values, actions);
    }
}

</script>
