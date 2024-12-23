<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="mb-1 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-2 btn-group col-12 col-md-2 mb-md-0">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id='starslist' class='display dataTable table-bordered table-hover d-none d-lg-table'>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Number</th>
                                                <th>Customer Name</th>
                                                <th>Product Price</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedPoints.length > 0">
                                            <tr v-for="(point, index) in paginatedPoints" :key="point.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ point.card_number }}</td>
                                                <td>{{ point.fname }} {{ point.mname }} {{ point.lname }}</td>
                                                <td>{{ point.product_price }}</td>

                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="7" class="text-center">No Loyalty Stars Found</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Card Layout for Smaller Screens -->
                                    <div class="responsive-table mt-4 d-block d-lg-none">
                                        <div v-if="paginatedPoints.length > 0">
                                            <div v-for="point in paginatedPoints" :key="point.id" class="data-card mb-3 p-3 border">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <strong>#{{ point.card_number }}</strong>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Customer Name:</span>
                                                            <span class="value">{{ point.fname }} {{ point.mname }} {{ point.lname }}</span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Product Price:</span>
                                                            <span class="value">{{ point.product_price }}</span>
                                                        </div>
                                                    </div>


                                                    <div class="mt-3 d-md-none border-top pt-2"></div>


                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="text-center mt-4">
                                            No Loyalty Stars Found
                                        </div>
                                    </div>

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
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useToastr } from '@/toastr.js';

import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';

const toastr = useToastr();
const points = ref([]);
const searchQuery = ref([]);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const maxVisiblePages = ref(10); // Maximum number of pages to show in the pagination controls

const getPoints = async () => {
    try {
        const response = await axios.get('/api/merchant/discounts', {
            params: {
                query: searchQuery.value
            }
        });
        points.value = response.data;
    } catch (error) {
        console.error('Error fetching points:', error);
    }
}

// Computed properties for pagination
const paginatedPoints = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return points.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => {
    return Math.ceil(points.value.length / itemsPerPage.value);
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

const formatRows = (rows) => {
    return rows.map((point, index) => [
        index + 1,
        point.card_number,
        `${point.fname} ${point.mname} ${point.lname}`,
        point.product_price,
    ]);
}

const exportToExcel = () => {
    try {
        if (points.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }

        const title = ['Loyalty Stars List'];
        const headers = ['#', 'Card Number', 'Customer Name', 'Price'];
        const formattedRows = formatRows(points.value);

        // merge Title and all columns
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Points');
        XLSX.writeFile(workbook, 'LoyaltyStars.xlsx');
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        toastr.error('Failed to export to Excel.');
    }
}

const exportToCSV = () => {
    try {
        if (points.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }

        const headers = ['#', 'Card Number', 'Customer Name', 'Price'];
        const formattedRows = formatRows(points.value);

        const csvContent = [
            headers.join(','),
            ...formattedRows.map(row => row.join(','))
        ].join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'LoyaltyStars.csv';
        link.click();
    } catch (error) {
        console.error('Error exporting to CSV:', error);
        toastr.error('Failed to export to CSV.');
    }
}

const printTable = () => {
    try {
        const tableClone = document.getElementById('starslist').cloneNode(true);

        // Remove the Action Column using Clone Table
        tableClone.querySelectorAll('th:nth-child(5), td:nth-child(5)').forEach(el => el.remove());

        const printContents = tableClone.outerHTML;
        if (!printContents) {
            toastr.info('No data to print.');
            return;
        }

        const printWindow = window.open('', '', 'width = 800, height=600');
        printWindow.document.write(`
           <html>
          <head>
            <title>Print Discount List</title>
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
            <h2>Loyalty Stars List</h2>
            ${printContents}
          </body>
        </html>
        `);

        printWindow.document.close();
        printWindow.print();

    } catch (error) {

    }
}


onMounted(() => {
    getPoints();
});

watch(searchQuery, debounce(() => {
    getPoints();
}, 500));
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
