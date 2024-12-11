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
                                    <table id="customerlist"
                                        class="display dataTable table-bordered table-hover d-none d-lg-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Number</th>
                                                <th>Customer Name</th>
                                                <th>Loyalty Points</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedCustomers.length > 0">
                                            <tr v-for="(customer, index) in paginatedCustomers" :key="customer.id">
                                                <td>{{ index + 1 + (currentPage - 1) * customersPerPage }}</td>
                                                <td>{{ customer.customer_card_num }}</td>
                                                <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                                                <td>{{ customer.points }} Star Points</td>
                                                <td>{{ formatDate(customer.point_created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right font-weight-bold">Total Star Points:
                                                </td>
                                                <td colspan="2" class="font-weight-bold">{{ totalStarPoints }} Points
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5" class="text-center">No Customer Points Found</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Card Layout for Smaller Screens -->
                                    <div class="responsive-table mt-4 d-block d-lg-none">
                                        <div v-if="paginatedCustomers.length > 0">
                                            <!-- Total Star Points -->
        <div class="data-card mb-3 p-3 border">
            <div class="row">
                <div class="col-12 d-flex justify-content-between font-weight-bold">
                    <span>Total Star Points:</span>
                    <span>{{ totalStarPoints }} Points</span>
                </div>
            </div>
        </div>
                                            <div v-for="customer in paginatedCustomers" :key="customer.id"
                                                class="data-card mb-3 p-3 border">


                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <strong>#{{ customer.customer_card_num }}</strong>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <strong>{{ formatDate(customer.point_created_at) }}</strong>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Customer Name:</span>
                                                            <span class="value">{{ customer.fname }} {{ customer.mname
                                                                }} {{ customer.lname }}</span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Loyalty Points:</span>
                                                            <span class="value">{{ customer.points }} Points</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>



                                                    <div class="mt-3 d-md-none border-top pt-2"></div>




                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="text-center mt-4">
                                            No Customer Found
                                        </div>
                                    </div>

                                    <!-- Pagination Controls -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <a class="page-link" @click="goToPage(currentPage - 1)">Previous</a>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page"
                                                :class="{ active: currentPage === page }">
                                                <a class="page-link" @click="goToPage(page)">{{ page }}</a>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <a class="page-link" @click="goToPage(currentPage + 1)">Next</a>
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
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx'; // Import XLSX for Excel/CSV export
import { useRoute } from 'vue-router';

const toastr = useToastr();
const customers = ref([]);
const searchQuery = ref('');
const route = useRoute();
const currentPage = ref(1);
const customersPerPage = 10;
const getCustomers = async () => {
    try {
        const response = await axios.get(`/api/customer/${route.params.id}/points`, {
            params: {
                query: searchQuery.value,
            },
        });
        customers.value = response.data;
    } catch (error) {
        console.error('Error fetching customers:', error);
    }
};

// Calculate total star points
const totalStarPoints = computed(() => {
    return customers.value.reduce((total, customer) => total + (customer.points || 0), 0);
});

// Format date and time
const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
};

watch(
    searchQuery,
    debounce(() => {
        currentPage.value = 1; // Reset to first page on search
        getCustomers();
    }, 100)
);

onMounted(() => {
    getCustomers();
});

// Computed property for paginated customers
const paginatedCustomers = computed(() => {
    const start = (currentPage.value - 1) * customersPerPage;
    return customers.value.slice(start, start + customersPerPage);
});

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(customers.value.length / customersPerPage);
});

// Function to go to a specific page
const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};


// Format rows for export excluding the "Action" column
const formatRows = (rows) => {
    return rows.map((customer, index) => [
        index + 1,
        customer.customer_card_num,
        `${customer.fname} ${customer.mname} ${customer.lname}`,
        customer.contact,
        customer.email,
        `${customer.zip} ${customer.street} ${customer.city} ${customer.province}`,
        customer.validity,
    ]);
};

// Export to Excel
const exportToExcel = () => {
    try {
        if (customers.value.length === 0) {
            return;
        }
        // Define headers and format rows without "Action" column
        const title = ['Customer List']; // Title row
        const headers = ['#', 'Card Number', 'Customer Name', 'Contact No.', 'Email Address', 'Address', 'Validity'];
        const formattedRows = formatRows(customers.value);

        // Create worksheet with a centered title row
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Customers');
        XLSX.writeFile(workbook, 'Customers.xlsx');
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        toastr.error('Failed to export to Excel.');
    }
};

// Export to CSV
const exportToCSV = () => {
    try {
        if (customers.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }
        // Define title and headers for the CSV
        const title = ['Customer List']; // Title for the CSV file
        const columnHeaders = ['#', 'Card Number', 'Customer Name', 'Contact No.', 'Email Address', 'Address', 'Validity'];
        const formattedRows = formatRows(customers.value);

        // Create worksheet with a centered title row
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, columnHeaders, ...formattedRows]);

        const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvOutput], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'Customers.csv');
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
        const tableClone = document.getElementById('customerlist').cloneNode(true);

        // Remove the "Action" column from the cloned table
        tableClone.querySelectorAll('th:nth-child(8), td:nth-child(8)').forEach(el => el.remove());

        const printContents = tableClone.outerHTML;
        if (!printContents) {
            toastr.info('No data to print.');
            return;
        }

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
          <head>
            <title>Print Customer Points List</title>
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
            <h2>Customer List</h2>
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
