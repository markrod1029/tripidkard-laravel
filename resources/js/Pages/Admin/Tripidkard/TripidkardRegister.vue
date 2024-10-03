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
                            <form class="form-horizontal" @submit.prevent="createMerchants" method="POST" enctype="multipart/form-data">

                                <!-- TripidKard Information -->
                                <h4 class="card-title text-dark mb-3">TripidKard Information</h4><br>

                                <!-- Role Selection: Merchant or Influencer -->
                                <div class="input-group mb-3">
                                    <label for="role"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Role
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <select class="form-control" name="role" v-model="form.role">
                                            <option value="" disabled selected>Select Role</option>
                                            <option value="merchant">Merchant</option>
                                            <option value="influencer">Influencer</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Merchant Input Field (Shown only if 'Merchant' is selected) -->
                                <div class="input-group mb-3" v-if="form.role === 'merchant'">
                                    <label for="merchant"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Merchant Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                        <select class="form-control" name="merchant_code" v-model="form.merchant_id">
                                            <option value="" disabled selected>Select Merchant Name</option>
                                            <option v-for="merchant in merchants" :value="merchant.id" :key="merchant.id">
                                                {{ merchant.business_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Influencer Input Field (Shown only if 'Influencer' is selected) -->
                                <div class="input-group mb-3" v-if="form.role === 'influencer'">
                                    <label for="influencer"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Influencer Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                        <select class="form-control" name="merchant_code" v-model="form.merchant_id">
                                            <option value="" disabled selected>Select Influencer Name</option>
                                            <option v-for="influencer in influencers" :value="influencer.id" :key="influencer.id">
                                                {{ influencer.business_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Total Cards -->
                                <div class="input-group mb-3">
                                    <label for="tripidkard_number"
                                        class="col-sm-2 text-right control-label col-form-label text-muted">Total Of
                                        Card</label>

                                    <div class="input-group col-sm-8 col-xs-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list-ol"></i></span>
                                        </div>
                                        <input v-model="form.tripidkard_number" type="number" class="form-control"
                                            id="tripidkard_number" name="number" required="">
                                    </div>
                                    <span class="text-danger">*</span>
                                </div>

                                <!-- Navigation buttons -->
                                <div class="box-footer text-right">
                                    <button type="reset"
                                        class="btn btn-dark waves-effect waves-light ml- text-white">Reset</button>

                                    <button type="submit" class="btn btn-primary ml-1" name="">Save</button>
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
import { useRouter } from 'vue-router';

const router = useRouter();
const toastr = useToastr();

const merchants = ref([]);
const influencers = ref([]); // Separate list for influencers

const form = reactive({
    merchant_id: '',
    role: '', // Field for role (Merchant or Influencer)
    tripidkard_number: '',
});

// Get merchants and influencers separately
const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants');
        console.log(response.data); // Debugging: Check if the data is coming in correctly
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching Merchants:', error);
    }
};

const createMerchants = async () => {
    try {
        await axios.post('/api/tripidkards/create', form);
        router.push('/admin/tripidkard');
        toastr.success('Tripidkard Added Successfully');
    } catch (error) {
        console.error('Error:', error.response.data.errors);
    }
}

onMounted(() => {
    getMerchants();
});
</script>
