<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div
                            class="mb-1 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-2 btn-group col-12 col-md-2 mb-md-0">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Export
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" @click="exportToExcel" type="button">Excel</button>
                                    <button class="dropdown-item" @click="exportToCSV" type="button">CSV</button>
                                    <button class="dropdown-item" @click="printTable" type="button">Print</button>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                            </div>
                        </div>
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">

                                <div class="col-sm-12">
                                    <table id='merchantlist'
                                        class='display dataTable table-bordered table-hover d-none d-lg-table'>
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
                                        <tbody v-if="paginatedMerchants.length > 0">

                                            <tr v-for="(merchant, index) in paginatedMerchants" :key="merchant.id">
                                                <td>{{ (currentPage - 1) * merchantsPerPage + index + 1 }}</td>
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
                                                        <router-link
                                                            to="enterprise-merchant?enterprise_id=<?php echo $row['id']?>"
                                                            class="btn btn-success btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-eye"></i>
                                                        </router-link>

                                                        <router-link :to="`/admin/merchant/${merchant.id}/edit`"
                                                            class="btn btn-primary btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-edit"></i>
                                                        </router-link>

                                                        <router-link to="#" @click.prevent="confirmArchive(merchant.id)"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="fa fa-redo"></i>
                                                        </router-link>
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


                                    <!-- Card Layout for Smaller Screens -->
                                    <div class="responsive-table mt-4 d-block d-lg-none">
                                        <div v-if="paginatedMerchants.length > 0">
                                            <div v-for="merchant in paginatedMerchants" :key="merchant.id"
                                                class="data-card mb-3 p-3 border">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <strong>{{ merchant.card_code }}</strong>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Merchant Name:</span>
                                                            <span class="value">{{ merchant.fname }} {{
                                                                merchant.mname
                                                                }} {{ merchant.lname }}</span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Business Code:</span>
                                                            <span class="value">{{ merchant.business_code }}</span>
                                                        </div>
                                                    </div>


                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Business Name:</span>
                                                            <span class="value">{{ merchant.business_name }} </span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Business Category:</span>
                                                            <span class="value"> {{ merchant.business_category }}</span>
                                                        </div>
                                                    </div>


                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Email:</span>
                                                            <span class="value">{{ merchant.email }} </span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Contact:</span>
                                                            <span class="value"> {{ merchant.contact }} </span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Address:</span>
                                                            <span class="value"> {{ merchant.zip }} {{ merchant.street
                                                                }} {{ merchant.city }} {{
                                                                    merchant.province }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <div style="display: flex; justify-content: center;">
                                                                <router-link
                                                                    to="enterprise-merchant?enterprise_id=<?php echo $row['id']?>"
                                                                    class="btn btn-success btn-sm  "
                                                                    style="margin-right: 5px;"><i class="fa fa-eye"></i>
                                                                </router-link>

                                                                <router-link :to="`/admin/merchant/${merchant.id}/edit`"
                                                                    class="btn btn-primary btn-sm  "
                                                                    style="margin-right: 5px;"><i
                                                                        class="fa fa-edit"></i>
                                                                </router-link>

                                                                <router-link to="#"
                                                                    @click.prevent="confirmArchive(merchant.id)"
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-redo"></i>
                                                                </router-link>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 d-md-none border-top pt-2"></div>


                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="text-center mt-4">
                                            No Merchants Found
                                        </div>
                                    </div>



                                    <!-- Pagination Controls -->
                                    <nav>
                                        <ul class="pagination justify-content-left">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <button class="page-link"
                                                    @click="goToPage(currentPage - 1)">Previous</button>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page"
                                                :class="{ active: currentPage === page }">
                                                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <button class="page-link"
                                                    @click="goToPage(currentPage + 1)">Next</button>
                                            </li>
                                        </ul>
                                    </nav>
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
import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';
import Swal from 'sweetalert2'; // Import SweetAlert2

const toastr = useToastr();
const merchants = ref([]);
const searchQuery = ref([]);
const currentPage = ref(1);
const merchantsPerPage = 10;

// Fetch merchants from the API
const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants', {
            params: {
                query: searchQuery.value,
            }
        });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
    }
}

// Watch for searchQuery changes and debounce the API calls
watch(searchQuery, debounce(() => {
    currentPage.value = 1; // Reset to the first page on search
    getMerchants();
}, 100));

// On component mount, fetch the merchants
onMounted(() => {
    getMerchants();
});

// Computed property for paginated Merch
const paginatedMerchants = computed(() => {
    const start = (currentPage.value - 1) * merchantsPerPage;
    return merchants.value.slice(start, start + merchantsPerPage);
});

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(merchants.value.length / merchantsPerPage);
});

// Function to navigate to a specific page
const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
};

// Format rows for export excluding the "Action" column
const formatRows = (rows) => {
    return rows.map((merchant, index) => [
        index + 1,
        merchant.card_code,
        merchant.business_code,
        `${merchant.fname} ${merchant.mname} ${merchant.lname}`,
        merchant.business_name,
        merchant.business_category,
        merchant.contact,
        merchant.email,
        `${merchant.zip} ${merchant.street} ${merchant.city} ${merchant.province}`,
    ]);
};

// Export to Excel
const exportToExcel = () => {
    try {
        if (merchants.value.length === 0) {
            return;
        }
        const title = ['Merchant List'];
        const headers = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
        const formattedRows = formatRows(merchants.value);

        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Merchants');
        XLSX.writeFile(workbook, 'Merchants.xlsx');
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        toastr.error('Failed to export to Excel.');
    }
};

// Export to CSV
const exportToCSV = () => {
    try {
        if (merchants.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }
        const title = ['Merchant List'];
        const columnHeaders = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
        const formattedRows = formatRows(merchants.value);

        const worksheet = XLSX.utils.aoa_to_sheet([[], title, columnHeaders, ...formattedRows]);
        const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvOutput], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'Merchants.csv');
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } catch (error) {
        console.error('Error exporting to CSV:', error);
        toastr.error('Failed to export to CSV.');
    }
};

// Print Table with a styled design excluding the "Action" column
const printTable = () => {
    try {
        const tableClone = document.getElementById('merchantlist').cloneNode(true);
        tableClone.querySelectorAll('th:nth-child(10), td:nth-child(10)').forEach(el => el.remove());

        const printContents = tableClone.outerHTML;
        if (!printContents) {
            toastr.info('No data to print.');
            return;
        }

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
          <head>
            <title>Print Merchant List</title>
            <style>
              body {
                font-family: Arial, sans-serif;
              }
              h2 {
                text-align: center;
                margin-bottom: 20px;
              }
              table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
              }
              th, td {
                padding: 8px;
                text-align: left;
                border: 1px solid #ddd;
              }
              th {
                background-color: #f2f2f2;
              }
              tr:nth-child(even) {
                background-color: #f9f9f9;
              }
            </style>
          </head>
          <body>
            <h2>Merchant List</h2>
            ${printContents}
          </body>
        </html>
      `);
        printWindow.document.close();
        printWindow.print();
    } catch (error) {
        console.error('Error printing table:', error);
        toastr.error('Failed to print.');
    }
};

// Confirm archive action with SweetAlert2
const confirmArchive = async (merchantId) => {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to archive this merchant!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, archive it!',
        cancelButtonText: 'Cancel'
    });

    if (result.isConfirmed) {
        // Call the function to archive the merchant
        await archiveMerchant(merchantId, 5);
    }
};

// Archive merchant
const archiveMerchant = async (merchantId, status) => {
    try {
        // Make your API call to archive the merchant
        await axios.patch(`/api/merchant/${merchantId}/status/archive`, { status }); // Adjust the API endpoint as necessary
        toastr.success('Merchant archived successfully.');
        // Refresh the merchants list after archiving
        getMerchants();
    } catch (error) {
        console.error('Error archiving merchant:', error);
        toastr.error('Failed to archive merchant.');
    }
};
</script>


<style scoped>
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
}

@media (max-width: 767px) {
    .responsive-table {
        display: block;
    }

    .data-card {
        border: 1px solid #ddd;
        margin-bottom: 15px;
        padding: 15px;
    }

    .label {
        font-weight: bold;
    }

    .value {
        display: inline-block;
        margin-left: 5px;
    }

    .pagination {
        display: flex;
        width: 100%;
    }
}
</style>
