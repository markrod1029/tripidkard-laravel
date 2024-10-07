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
                                        <button class="dropdown-item" @click="exportToExcel"
                                            type="button">Excel</button>
                                        <button class="dropdown-item" @click="exportToCSV" type="button">CSV</button>
                                        <button class="dropdown-item" @click="printTable" type="button">Print</button>
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
                                    <table id='tripidkardlist' class='display dataTable table-bordered'
                                        style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Name/Blog Name</th> <!-- Updated heading -->
                                                <th>Card Code</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="tripidkards.length > 0">

                                            <tr v-for="(tripidkard, index) in tripidkards" :key="tripidkard.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ tripidkard.business_or_blog_name }}</td> <!-- Updated field -->
                                                <td>{{ tripidkard.card_number }}</td>
                                            </tr>
                                        </tbody>

                                        <tbody v-else>

                                            <tr>
                                                <td colspan="5" class="text-center"> No Tripidkards Found</td>
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
import * as XLSX from 'xlsx';

const tripidkards = ref([]);
const searchQuery = ref([]);

const toastr = useToastr();
const gettripidkards = async () => {
    try {
        const response = await axios.get('/api/tripidkards', {
            params: {
                query: searchQuery.value,
            }
        });
        tripidkards.value = response.data;
    } catch (error) {
        console.error('Error fetching Tripidkards:', error);
    }
}

watch(searchQuery, debounce(() => {
    gettripidkards();
}, 100));

onMounted(() => {
    gettripidkards();
});
</script>
