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
                            <div class="mb-2 d-flex">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" type="button"
                                            @click="exportData('copy')">Copy</button>
                                        <button class="dropdown-item" type="button"
                                            @click="exportData('excel')">Excel</button>
                                        <button class="dropdown-item" type="button"
                                            @click="exportData('csv')">CSV</button>
                                        <button class="dropdown-item" type="button"
                                            @click="exportData('print')">Print</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
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
                                                <td>{{ merchant.business_code }}</td>
                                                <td>{{ merchant.fname }} {{ merchant.mname }} {{ merchant.lname }}</td>
                                                <td>{{ merchant.business_name }}</td>
                                                <td>{{ merchant.business_category }}</td>
                                                <td>{{ merchant.contact }}</td>
                                                <td>{{ merchant.email }}</td>
                                                <td>{{ merchant.zip }} {{ merchant.street }} {{ merchant.city }} {{
                                                merchant.province }}</td>
                                                <td>
                                                    <div style="display: flex; justify-content: center;">

                                                        <button @click="statusMerchant(merchant.user_id, 1)" onclick="return confirm('Are you sure you want to Confirm this Merchant Account?')"
                                                            class="btn btn-success btn-sm"  style="margin-right: 5px;" >
                                                            <i class="fa fa-check"></i>
                                                        </button>

                                                        <button @click="statusMerchant(merchant.user_id, 3)" onclick="return confirm('Are you sure you want to Confirm this Merchant Account?')"
                                                            class="btn btn-danger btn-sm"  style="margin-right: 5px;" >
                                                            <i class="fa fa-trashcheck"></i>
                                                        </button>



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
import * as XLSX from 'xlsx';

const toastr = useToastr();
const merchants = ref([]);
const searchQuery = ref('');

const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants-pending', {
            params: {
                query: searchQuery.value,
            }
        });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
    }
};



const statusMerchant = async (userId, status) => {
    try {
        const response = await axios.put(`/api/merchants/${userId}`, null, {
            params: { status }
        });
        toastr.success(response.data.message);
        // Refresh the merchant list after successful operation
        getMerchants();
    } catch (error) {
        console.error('Error updating merchant status:', error);
        toastr.error('Failed to update merchant status.');
    }
};





watch(searchQuery, debounce(() => {
    getMerchants();
}, 100));

onMounted(() => {
    getMerchants();
});

const exportData = (type) => {
    if (type === 'copy') {
        // Copy to clipboard logic can be added here
    } else if (type === 'excel' || type === 'csv') {
        const tableClone = document.getElementById('enterpriselist').cloneNode(true);
        const actionColumnIndex = Array.from(tableClone.querySelectorAll('th')).findIndex(th => th.textContent === 'Action');
        if (actionColumnIndex !== -1) {
            Array.from(tableClone.querySelectorAll('tr')).forEach(row => {
                row.removeChild(row.children[actionColumnIndex]);
            });
        }
        const wb = XLSX.utils.table_to_book(tableClone, { sheet: "Sheet JS" });
        const extension = type === 'excel' ? 'xlsx' : 'csv';
        XLSX.writeFile(wb, `merchants.${extension}`);
    } else if (type === 'print') {
        const tableClone = document.getElementById('enterpriselist').cloneNode(true);
        const actionColumn = tableClone.querySelector('th:last-child');
        const actionDataColumn = tableClone.querySelector('td:last-child');
        actionColumn.style.display = 'none';
        actionDataColumn.style.display = 'none';
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; } th { background-color: #f2f2f2; }</style>');
        printWindow.document.write('<h1>Merchants</h1>');
        printWindow.document.write(tableClone.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.print();
    }
};
</script>
