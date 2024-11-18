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
                                        <button class="dropdown-item" @click="exportToExcel" type="button">Excel</button>
                                        <button class="dropdown-item" @click="exportToCSV" type="button">CSV</button>
                                        <button class="dropdown-item" @click="printTable" type="button">Print</button>
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
                                    <table id="tripidkardlist" class="display dataTable table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Name/Blog Name</th>
                                                <th>Card Types</th>
                                                <th>Card Code</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedTripidkards.length > 0">
                                            <tr v-for="(tripidkard, index) in paginatedTripidkards" :key="tripidkard.id">
                                                <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                                                <td>{{ tripidkard.business_or_blog_name }}</td>
                                                <td>{{ tripidkard.card_types }}</td>
                                                <td>{{ tripidkard.card_number }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="4" class="text-center"> No Tripidkards Found</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Pagination Controls -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-start">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
                                            </li>

                                            <!-- Show only up to 10 page numbers -->
                                            <li v-for="page in visiblePages" :key="page" class="page-item" :class="{ active: currentPage === page }">
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

const tripidkards = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);
const maxVisiblePages = ref(10); // Maximum number of pages to show in the pagination controls

const toastr = useToastr();

// Fetch data function
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

// Watch search query with debounce
watch(searchQuery, debounce(() => {
    gettripidkards();
}, 100));

// Fetch data on component mount
onMounted(() => {
    gettripidkards();
});

// Computed properties for pagination
const paginatedTripidkards = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return tripidkards.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => {
    return Math.ceil(tripidkards.value.length / itemsPerPage.value);
});

// Get the visible page numbers, limiting to 10
const visiblePages = computed(() => {
    const startPage = Math.max(currentPage.value - Math.floor(maxVisiblePages.value / 2), 1);
    const endPage = Math.min(startPage + maxVisiblePages.value - 1, totalPages.value);
    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
});

// Change page function
const changePage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
};

// Format rows for export excluding the "Action" column
const formatRows = (rows) => {
    return rows.map((tripidkard, index) => [
        index + 1,
        tripidkard.business_name,
        tripidkard.card_number,
        tripidkard.card_types,
    ]);
};

// Export to Excel
const exportToExcel = () => {
    try {
        if (tripidkards.value.length === 0) {
            return;
        }
        const title = ['Tripidkard List']; // Title row
        const headers = ['#', 'Business Name/Blog Name', 'Card Code', 'Card Types'];
        const formattedRows = formatRows(tripidkards.value);
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Tripidkard');
        XLSX.writeFile(workbook, 'Tripidkard.xlsx');
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        toastr.error('Failed to export to Excel.');
    }
};

// Export to CSV
const exportToCSV = () => {
    try {
        if (tripidkards.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }
        const title = ['Tripidkard List']; // Title row
        const headers = ['#', 'Business Name/Blog Name', 'Card Code', 'Card Types'];
        const formattedRows = formatRows(tripidkards.value);
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvOutput], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'Tripidkard.csv');
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
        const tableClone = document.getElementById('tripidkardlist').cloneNode(true);
        const printContents = tableClone.outerHTML;
        if (!printContents) {
            toastr.info('No data to print.');
            return;
        }

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
          <head>
            <title>Print Tripidkard List</title>
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
            <h2>Tripidkard List</h2>
            ${printContents}
          </body>
        </html>
      `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    } catch (error) {
        console.error('Error printing table:', error);
        toastr.error('Failed to print the table.');
    }
};
</script>

<style scoped>
/* You can style the table and pagination here if needed */
</style>
