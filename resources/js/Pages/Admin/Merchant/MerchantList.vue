<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />


        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex justify-content-between">

                            <div class=" mb-2 d-flex">

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" type="button">Copy</button>
                                        <button class="dropdown-item" type="button">Excel</button>
                                        <button class="dropdown-item" type="button">CSV</button>
                                        <button class="dropdown-item" type="button">Print</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-3">
                                <input type="text" name="" v-model="searchQuery" class="form-control"
                                    placeholder="Search..." id="">

                            </div>
                        </div>
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">

                                <div class="col-sm-12">
                                    <table id='enterpriselist' class='display dataTable table-bordered'
                                        style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Code</th>
                                                <th>Store Code</th>
                                                <th>Merchant Name</th>
                                                <th>Business Name</th>
                                                <th>Business Category</th>
                                                <th>Contact No.</th>
                                                <th>Email Address</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="merchants.length > 0">

                                            <tr v-for="(merchant, index) in merchants" :key="merchant.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ merchant.card_code }}</td>
                                            <td>{{ merchant.business_code  }}</td>
                                            <td>{{ merchant.fname }} {{ merchant.mname }} {{ merchant.lname }}</td>
                                            <td>{{ merchant.business_name }}</td>
                                            <td>{{ merchant.business_category }}</td>
                                            <td>{{ merchant.contact }}</td>
                                            <td>{{ merchant.email }}</td>
                                            <td>{{ merchant.zip }} {{ merchant.street }} {{ merchant.city }} {{ merchant.province }}</td>

                                            <td>
                                                <div style="display: flex; justify-content: center;">
                                                    <router-link to="enterprise-merchant?enterprise_id=<?php echo $row['id']?>" class="btn btn-success btn-sm  " style="margin-right: 5px;"><i class="fa fa-eye"></i>
                                                    </router-link>

                                                    <router-link :to="`/admin/merchant/${merchant.id}/edit`" class="btn btn-primary btn-sm  " style="margin-right: 5px;"><i class="fa fa-edit"></i>
                                                    </router-link>

                                                    <router-link to="class/enterprise_crud.php?action=archive&&enterprise_id=<?php echo $row['id']?>" onclick="return confirm('Are you sure you want to remove Archive this Enterprise Account?')" class="btn btn-danger btn-sm  "><i class="fa fa-redo"></i> </router-link>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>

                                            <tr>
                                                <td colspan="10" class="text-center"> No Merchants Found</td>
                                            </tr>

                                        </tbody>


                                    </table>
                                </div>
                            </div>
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

import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { debounce } from 'lodash';

const toastr = useToastr();
const merchants = ref([]);
const searchQuery = ref([]);

const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants',  {
            params: {
                query: searchQuery.value,
            }
        });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchant:', error);
    }
}



watch(searchQuery, debounce(() => {
    getMerchants();
}, 100));



onMounted(() => {
    getMerchants();


});

// let deleteCustomer = () => {
//   axios.post('/api/')
// }
</script>