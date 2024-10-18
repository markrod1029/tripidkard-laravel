<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />

        <div class="content">
            <div class="row profile">
                <div class="col-lg-4 col-xlg-3">
                    <!--  Profile Details -->
                    <Profile />
                </div>

                <div class="col-lg-8 col-xlg-3">
                    <div class="small-box bg-default" style="background-color:white;">
                        <ul class="nav nav-pills custom-pills" style="font-size:17px;">

                            <li class="nav-item">
                                <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill"
                                    href="#pills-timeline" role="tab" aria-controls="pills-timeline"
                                    aria-selected="true">Profile</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-business-tab" data-toggle="pill" href="#pills-business"
                                    role="tab" aria-controls="pills-business" aria-selected="false">Business</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-business-discount-tab" data-toggle="pill"
                                    href="#pills-business-discount" role="tab" aria-controls="pills-business-discount"
                                    aria-selected="false">Business Description</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#pills-setting"
                                    role="tab" aria-controls="pills-setting" aria-selected="false">Security Setting</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-images-tab" data-toggle="pill" href="#pills-images"
                                    role="tab" aria-controls="pills-images" aria-selected="false">Images</a>
                            </li>


                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <!-- Start Profile -->
                                <FormProfile />
                            <!-- End Profile -->


                            <!-- Start Business -->
                            <FormBusiness />
                            <!-- End Business -->


                            <!-- Start Business Discount-->
                            <FormDesciption />

                            <!-- End Business -->

                            <!-- Start Change Password -->

                            <FormSecurity />

                            <!-- End Change Password -->


                            <!-- Start Change Images -->
                            <FormImages />

                            <!-- End Change Images -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <Footer />

</template>

<script setup>
// Component Organisitation
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Influencer/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

// Profile Pages
import Profile from '@/Pages/Profiles/ProfileDetails.vue';
import FormProfile from '@/Pages/Profiles/FormProfile.vue';
import FormBusiness from '@/Pages/Profiles/FormBusiness.vue';
import FormDesciption from '@/Pages/Profiles/FormDesciption.vue';
import FormSecurity from '@/Pages/Profiles/FormSecurity.vue';
import FormImages from '@/Pages/Profiles/FormImages.vue';

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
