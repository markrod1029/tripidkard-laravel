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
                                                <th>Card Type</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="orders.length > 0">

                                            <tr v-for="(order, index) in orders " :key="order.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ order.cards }}</td>
                                                <td>{{ order.total }}</td>
                                                <td class="btn bg-info btn-sm d-flex justify-content-center align-items-center"
                                                    v-if="order.status == 0">Pending</td>
                                                <td class="bg bg-success bg-sm d-flex justify-content-center align-items-center"
                                                    v-else>Success</td>


                                            </tr>
                                        </tbody>
                                        <tbody v-else>

                                            <tr>
                                                <td colspan="7" class="text-center"> No Orders Found</td>
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
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';

import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { debounce } from 'lodash';

const toastr = useToastr();
const orders = ref([]);
const searchQuery = ref([]);

const getOrders = async () => {
    try {
        const response = await axios.get('/api/card/lists', {
            params: {
                query: searchQuery.value
            }
        });
        orders.value = response.data;
        console.log(orders.value)
    } catch (error) {
        console.error('Error fetching services:', error);
    }
}



watch(searchQuery, debounce(() => {
    getOrders();
}, 100));



onMounted(() => {
    getOrders();


});

</script>
