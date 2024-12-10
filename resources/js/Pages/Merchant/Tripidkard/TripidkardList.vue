<template>
    <div>
        <MenuBar />
        <Sidebar />

        <div class="content-wrapper">
            <Breadcrumb />

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <!-- Search Input and Export Options -->
                            <div
                                class=" mb-1   d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div class=" mb-2     btn-group col-12 col-md-2 mb-md-0">
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

                                <div class="col-12 col-md-3">
                                    <input type="text" v-model="searchQuery" class="form-control"
                                        placeholder="Search..." />
                                </div>
                            </div>

                            <!-- Table Layout for Larger Screens -->
                            <table id="tripidkardlist"
                                class="display dataTable table-bordered table-hover d-none d-lg-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Card Types</th>
                                        <th>Card Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tripidkard, index) in paginatedTripidkards" :key="tripidkard.id">
                                        <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                                        <td>{{ tripidkard.card_types }}</td>
                                        <td>{{ tripidkard.card_number }}</td>
                                    </tr>
                                    <tr v-if="paginatedTripidkards.length === 0">
                                        <td colspan="3" class="text-center">No Tripidkards Found</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Card Layout for Smaller Screens -->
                            <div class="responsive-table mt-4 d-block d-lg-none">
                                <div v-if="paginatedTripidkards.length > 0">
                                    <div v-for="(tripidkard, index) in paginatedTripidkards" :key="tripidkard.id"
                                        class="data-card mb-3 p-3 border">
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <strong>#{{ (currentPage - 1) * itemsPerPage + index + 1 }}</strong>
                                            </div>

                                            <div class="mt-3 d-md-none border-top pt-2"></div>

                                            <div class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                <span class="label">Card Types:</span>
                                                <span class="value">{{ tripidkard.card_types }}</span>
                                            </div>
                                            <div class="mt-3 d-md-none border-top pt-2"></div>
                                            <div class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                <span class="label">Card Code:</span>
                                                <span class="value">{{ tripidkard.card_number }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                    </div>
                                </div>


                                <div v-else class="text-center mt-4">
                                    No Tripidkards Found
                                </div>
                            </div>

                            <!-- Pagination Controls -->
                            <nav aria-label="Page navigation" class="mt-3">
                                <ul class="pagination justify-content-start">
                                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                        <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
                                    </li>
                                    <li v-for="page in visiblePages" :key="page" class="page-item"
                                        :class="{ active: currentPage === page }">
                                        <a class="page-link" @click="changePage(page)">{{ page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                        <a class="page-link" @click="changePage(currentPage + 1)">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';

const tripidkards = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);
const maxVisiblePages = ref(10);

const toastr = useToastr();

// Fetch Tripidkards
const getTripidkards = async () => {
    try {
        const response = await axios.get('/api/merchant/tripidkards', {
            params: { query: searchQuery.value },
        });
        tripidkards.value = response.data;
    } catch (error) {
        console.error('Error fetching Tripidkards:', error);
        toastr.error('Error fetching data.');
    }
};

// Debounce search
watch(searchQuery, debounce(() => getTripidkards(), 300));

// Fetch data on mount
onMounted(() => getTripidkards());

// Pagination
const paginatedTripidkards = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return tripidkards.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(tripidkards.value.length / itemsPerPage.value));
const visiblePages = computed(() => {
    const startPage = Math.max(currentPage.value - Math.floor(maxVisiblePages.value / 2), 1);
    const endPage = Math.min(startPage + maxVisiblePages.value - 1, totalPages.value);
    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) currentPage.value = page;
};

// Export to Excel
const exportToExcel = () => {
    if (!tripidkards.value.length) {
        toastr.info('No data to export.');
        return;
    }
    const headers = ['#', 'Card Types', 'Card Code'];
    const data = tripidkards.value.map((item, index) => [
        index + 1,
        item.card_types,
        item.card_number,
    ]);
    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Tripidkards');
    XLSX.writeFile(workbook, 'Tripidkards.xlsx');
};

// Export to CSV
const exportToCSV = () => {
    if (!tripidkards.value.length) {
        toastr.info('No data to export.');
        return;
    }
    const headers = ['#', 'Card Types', 'Card Code'];
    const data = tripidkards.value.map((item, index) => [
        index + 1,
        item.card_types,
        item.card_number,
    ]);
    const csv = [headers, ...data].map(row => row.join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'Tripidkards.csv';
    link.click();
};

// Print the table
const printTable = () => {
    const printContents = document.getElementById('tripidkardlist').outerHTML;
    const newWin = window.open('');
    newWin.document.write(`
      <html>
        <head>
          <title>Print Tripidkard</title>
          <style>
            table {
              width: 100%;
              border-collapse: collapse;
            }
            th, td {
              border: 1px solid #ddd;
              padding: 8px;
            }
            th {
              background-color: #f2f2f2;
            }
              h1 {
              text-align:center;
              }
          </style>
        </head>
        <body onload="window.print()">
          <h1>Tripidkard List</h1>

          ${printContents}
        </body>
      </html>
    `);
    newWin.document.close();
};

</script>

<style scoped>
.responsive-table .data-card {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
}

.responsive-table .label {
    font-weight: bold;
    margin-right: 5px;
}

.pagination {
    margin-top: 15px;
    justify-content: flex-start;
    /* Align to the left */

}
</style>
