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
                            <h4 class="card-title text-white title">Add New Customer</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="card-body">
                            <form class="form-horizontal" @submmit="createCustomer" method="POST" enctype="multipart/form-data">

                                <!-- Customer Information -->
                                <h4 class="card-title text-dark mb-3">Customer Information</h4><br>

                                <div v-show="currentStep === 1">
                                    <!-- Step 1: Personal Information -->
                                    <div class="input-group mb-3">
                                        <label for="fname"
                                            class="col-sm-2 col-xs-2 text-right col-form-label text-muted">Customer Number
                                            <span class="text-danger">*</span>
                                            </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-credit-card"></i></span></div>
                                            <input type="text" v-model="form.customer_code" class="form-control" id="fname" name="customer_code"
                                                value="" required="">
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
                                            <input type="text" v-model="form.fname" class="form-control" id="fname" name="fname" value=""
                                                required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="mname"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Middle
                                            Name</label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-user"></i></span></div>
                                            <input type="text" v-model="form.mname" class="form-control" id="mname" name="mname" value=""
                                                placeholder="Optional">
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
                                            <input type="text" v-model="form.lname" class="form-control" id="lname" name="lname" value=""
                                                required="">
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
                                            <input type="text" v-model="form.contact" class="form-control" id="contact" name="contact" value=""
                                                required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="email"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Email Address
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-envelope"></i></span></div>
                                            <input type="email" v-model="form.email" class="form-control" id="email" name="email" value=""
                                                required="">
                                        </div>
                                        <span class="text-danger">*</span>
                                    </div>
                                </div>

                                <div v-show="currentStep === 2" style="display: none;">
                                    <!-- Step 2: Business Information -->

                                    <div class="input-group mb-3">
                                        <label for="zip"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Birth Date
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-birthday-cake"></i></span></div>
                                            <input type="date" v-model="form.bdate"  class="form-control" id="bdate" name="bdate"
                                                placeholder="ZIP Code" value="" required="">
                                        </div>
                                    </div>





                                    <div class="input-group mb-3">
                                        <label for="zip"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Address
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.zip"  class="form-control" id="zip" name="zip"
                                                placeholder="ZIP Code" value="" required="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="street"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Street
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.street"  class="form-control" id="street" name="street"
                                                placeholder="Street" value="" required>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="city"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">City
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.city"  class="form-control" id="city" name="city"
                                                placeholder="City" value="" required>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="province"
                                            class="col-sm-2 text-right control-label col-form-label text-muted">Province
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group col-sm-8 col-xs-11">
                                            <div class="input-group-prepend"><span class="input-group-text">
                                                    <i class="fa fa-home"></i></span></div>
                                            <input type="text" v-model="form.province" class="form-control" id="province" name="province"
                                                placeholder="Province" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <button v-if="currentStep !== 1" @click="backStep" class="btn btn-dark waves-effect waves-light ml-5 ">Back</button>
                                    <button v-if="currentStep !== totalSteps" @click="nextStep" class="btn btn-primary  ml-1">Next</button>
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
import { ref, reactive } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

const currentStep = ref(1);
const totalSteps = 2;
const customers = ref([]);
const form = reactive({
    customer_code: '',
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

const createCustomer = (values, actions) => {

    axios.post('/api/customers/create', form)
    .then((ressponse) => {
        console.log(ressponse)
    })
    .catch(err => {
        console.error(ressponse); 
    })

}


const handleSubmit = () => {

}
</script>
