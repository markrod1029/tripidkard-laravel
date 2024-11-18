<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="btn-group">
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

                            <div class="col-3">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                            </div>
                        </div>

                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="merchantlist" class="display dataTable table-bordered"
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
                                                <td>{{ formatAddress(merchant) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <button @click="showApprovalModal(merchant.user_id)"
                                                            class="btn btn-success btn-sm mr-2">Approve</button>
                                                        <button @click="showArchiveModal(merchant.user_id)"
                                                            class="btn btn-danger btn-sm">Archive</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="10" class="text-center">No Merchants Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                      <!-- Pagination Controls -->
                                      <nav>
                                        <ul class="pagination justify-content-left">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <button class="page-link" @click="goToPage(currentPage - 1)">Previous</button>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                                                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <button class="page-link" @click="goToPage(currentPage + 1)">Next</button>
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
import Swal from 'sweetalert2';

const toastr = useToastr();
const merchants = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const merchantsPerPage = 10;
// Fetch merchants from API
const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants-pending', { params: { query: searchQuery.value } });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
        toastr.error('Failed to fetch merchants.');
    }
};

// Watch search query and debounce search requests
watch(searchQuery, debounce(() => {
    currentPage.value = 1; // Reset to the first page on search
    getMerchants();
}, 100));

// Fetch merchants on component mount
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

// Show approval modal
const showApprovalModal = (merchantId) => {
    Swal.fire({
        title: 'Approve Merchant',
        text: `Are you sure you want to approve this merchant?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await updateMerchantStatus(merchantId, 'approve');
        }
    });
};

// Show archive modal
const showArchiveModal = (merchantId) => {
    Swal.fire({
        title: 'Archive Merchant',
        text: 'Are you sure you want to archive this merchant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Archive',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await updateMerchantStatus(merchantId, 'archive');
        }
    });
};

// Update merchant status
const updateMerchantStatus = async (merchantId, action) => {
    const endpoint = action === 'approve' ? `/api/merchant/${merchantId}/status/approve` : `/api/merchant/${merchantId}/status/archive`;
    const status = action === 'approve' ? 1 : 5;

    try {
        await axios.patch(endpoint, { status });
        toastr.success(`Merchant ${action === 'approve' ? 'approved' : 'archived'} successfully.`);
        getMerchants(); // Refresh the list
    } catch (error) {
        console.error(`Error updating merchant status:`, error);
        toastr.error(`Failed to ${action} merchant.`);
    }
};

// Format address for display
const formatAddress = (merchant) => {
    return `${merchant.zip} ${merchant.street} ${merchant.city}, ${merchant.province}`;
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
        formatAddress(merchant),
    ]);
};

// Export to Excel
const exportToExcel = () => {
    if (merchants.value.length === 0) {
        toastr.info('No data to export.');
        return;
    }

    const headers = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
    const formattedRows = formatRows(merchants.value);

    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...formattedRows]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Merchants');
    XLSX.writeFile(workbook, 'Merchants.xlsx');
};

// Export to CSV
const exportToCSV = () => {
    if (merchants.value.length === 0) {
        toastr.info('No data to export.');
        return;
    }

    const headers = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
    const formattedRows = formatRows(merchants.value);

    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...formattedRows]);
    const csvOutput = XLSX.utils.sheet_to_csv(worksheet);

    const blob = new Blob([csvOutput], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'Merchants.csv';
    a.click();
};

// Print Table excluding the "Action" column
const printTable = () => {
    if (merchants.value.length === 0) {
        toastr.info('No data to print.');
        return;
    }

    const tableClone = document.getElementById('merchantlist').cloneNode(true);
    tableClone.querySelectorAll('th:nth-child(10), td:nth-child(10)').forEach(cell => cell.remove()); // Remove Action column
    const newWindow = window.open('', '_blank');
    newWindow.document.write(`<html><head><title>Merchant List</title></head><body>${tableClone.outerHTML}</body></html>`);
    newWindow.document.close();
    newWindow.print();
};
</script>

