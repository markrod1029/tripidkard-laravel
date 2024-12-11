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

                        <div  class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="customerlist"
                                        class="display dataTable table-bordered table-hover d-none d-lg-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Number</th>
                                                <th>Customer Name</th>
                                                <th>Contact No.</th>
                                                <th>Email Address</th>
                                                <th>Address</th>
                                                <th>Validity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedCustomers.length > 0">
                                            <tr v-for="(customer, index) in paginatedCustomers" :key="customer.id">
                                                <td>{{ index + 1 + (currentPage - 1) * customersPerPage }}</td>
                                                <td>{{ customer.customer_card_num }}</td>
                                                <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                                                <td>{{ customer.contact }}</td>
                                                <td>{{ customer.email }}</td>
                                                <td>
                                                    {{ customer.zip }} {{ customer.street }} {{ customer.city }} {{
                                                        customer.province }}
                                                </td>
                                                <td>{{ customer.validity }}</td>
                                                <td>
                                                    <div style="display: flex; justify-content: center;">
                                                        <router-link :to="`/merchant/customer/${customer.id}/points`"
                                                            class="btn btn-success btn-sm" style="margin-right: 5px;"><i
                                                                class="fa fa-eye"></i></router-link>
                                                        <router-link :to="`/merchant/customer/${customer.id}/edit`"
                                                            class="btn btn-primary btn-sm" style="margin-right: 5px;"><i
                                                                class="fa fa-edit"></i></router-link>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                         <tbody v-else>

                                            <tr>
                                                <td colspan="7" class="text-center"> No Customers Found</td>
                                            </tr>

                                        </tbody>

                                    </table>

                                    <!-- Card Layout for Smaller Screens -->
                                    <div class="responsive-table mt-4 d-block d-lg-none">
                                        <div v-if="paginatedCustomers.length > 0">
                                            <div v-for="customer in paginatedCustomers" :key="customer.id"
                                                class="data-card mb-3 p-3 border">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <strong>#{{ customer.customer_card_num }}</strong>
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
                                                            <span class="label">Contact No:</span>
                                                            <span class="value">{{ customer.contact }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Email Address:</span>
                                                            <span class="value">{{ customer.email }}</span>
                                                        </div>

                                                        <div class="mt-3 d-md-none border-top pt-2"></div>

                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Address:</span>
                                                            <span class="value">{{ customer.zip }}, {{ customer.street
                                                                }}, {{ customer.city }}, {{ customer.province }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>


                                                    <div class="row mb-2">
                                                        <div
                                                            class="col-12 col-md-6 d-flex justify-content-between d-md-block">
                                                            <span class="label">Validatiy:</span>
                                                            <span class="value">{{ customer.validity }}</span>
                                                        </div>

                                                    </div>

                                                    <div class="mt-3 d-md-none border-top pt-2"></div>

                                                    <div class="row mb-2">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <router-link
                                                                :to="`/merchant/customer/${customer.id}/points`"
                                                                class="btn btn-success btn-sm"
                                                                style="margin-right: 5px;">
                                                                <i class="fa fa-eye"></i>
                                                            </router-link>
                                                            <router-link :to="`/merchant/customer/${customer.id}/edit`"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </router-link>
                                                        </div>
                                                    </div>


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
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx'; // Import XLSX for Excel/CSV export

const toastr = useToastr();
const customers = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const customersPerPage = 10;

// Fetch customers from the API
const getCustomers = async () => {
    try {
        const response = await axios.get('/api/user/customers', {
            params: {
                query: searchQuery.value,
            },
        });
        customers.value = response.data;
    } catch (error) {
        console.error('Error fetching customers:', error);
    }
};


// Watch for search query changes and fetch customers
watch(
    searchQuery,
    debounce(() => {
        currentPage.value = 1; // Reset to first page on search
        getCustomers();
    }, 100)
);

// Get customers on component mount
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

        // Create worksheet
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
        const title = ['Customer List']; // Title for the CSV file
        const columnHeaders = ['#', 'Card Number', 'Customer Name', 'Contact No.', 'Email Address', 'Address', 'Validity'];
        const formattedRows = formatRows(customers.value);

        // Create CSV content
        let csvContent = title.join(',') + '\n';
        csvContent += columnHeaders.join(',') + '\n';
        formattedRows.forEach(row => {
            csvContent += row.join(',') + '\n';
        });

        // Create a blob for the CSV file and trigger download
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'Customers.csv');
        a.style.visibility = 'hidden';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } catch (error) {
        console.error('Error exporting to CSV:', error);
        toastr.error('Failed to export to CSV.');
    }
};

// Print the table
const printTable = () => {
    const tableClone = document.getElementById('customerlist').cloneNode(true);

// Remove the "Action" column from the cloned table
tableClone.querySelectorAll('th:nth-child(8), td:nth-child(8)').forEach(el => el.remove());

const printContents = tableClone.outerHTML;
if (!printContents) {
    toastr.info('No data to print.');
    return;
}

const newWin = window.open('', '', 'width=800,height=600');
    newWin.document.write(`
      <html>
        <head>
          <title>Print Customers</title>
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
          <h1>Customer List</h1>

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
