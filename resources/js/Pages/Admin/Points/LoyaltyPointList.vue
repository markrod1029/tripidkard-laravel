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
                            <div class="row"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id='loyaltystarlist' class='display dataTable table-bordered'
                                        style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant Name</th>
                                                <th>Business Name</th>
                                                <th>Total of Loyalty Stars</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedMerchants.length > 0">
                                            <tr v-for="(merchant, index) in paginatedMerchants" :key="merchant.id">
                                                <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                                                <td>{{ merchant.fname }} {{ merchant.mname }} {{ merchant.lname }}</td>
                                                <td>{{ merchant.business_name }}</td>
                                                <td>{{ merchant.stars_points }} Stars Points</td>

                                                <td>
                                                    <div style="display: flex; justify-content: center;">
                                                        <router-link class="btn btn-success btn-sm"
                                                            :to="`/admin/loyalty-stars/${merchant.id}/customer`"
                                                            style="margin-right: 5px;"><i class="fa fa-eye"></i>
                                                        </router-link>
                                                        <router-link
                                                            :to="`/admin/loyalty-stars/${merchant.merchant_id}/edit`"
                                                            class="btn btn-primary btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-edit"></i>
                                                        </router-link>
                                                        <a href="class/enterprise_crud.php?action=archive&&enterprise_id=<?php echo $row['id']?>"
                                                            onclick="return confirm('Are you sure you want to remove Archive this Enterprise Account?')"
                                                            class="btn btn-danger btn-sm  "><i class="fa fa-redo"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody v-else>

                                            <td colspan="5" class="text-center"> No Loyalty Stars Registers Found</td>

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
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import { useToastr } from '@/toastr.js';
import * as XLSX from 'xlsx';
import { debounce } from 'lodash';
import { computed } from 'vue';

const merchants = ref([]);
const searchQuery = ref([]);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const maxVisiblePages = ref(10); // Maximum number of pages to show in the pagination controls

const toastr = useToastr();

const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants', {
            params: {
                query: searchQuery.value
            }
        });
        if (!response.data) {
            throw new Error('No data received from API');
        }

        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchants:', error);
    }
}

watch(searchQuery, debounce( async () => {
    await getMerchants();
}, 100));


onMounted(async () => {
   await getMerchants();
});


// Computed properties for pagination
const paginatedMerchants = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return merchants.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => {
    return Math.ceil(merchants.value.length / itemsPerPage.value);
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
    return rows.map((merchant, index) => [
        index + 1,
        `${merchant.fname} ${merchant.mname} ${merchant.lname}`,
        merchant.business_name,
        merchant.stars_points + ' Stars Points',
        merchant.validity,
    ]);
};

// Export to Excel
const exportToExcel = () => {
    try {
        if (merchants.value.length === 0) {
            return;
        }
        // Define headers and format rows without "Action" column
        const title = ['Loyalty Stars List']; // Title row
        const headers = ['#', 'Merchant Name', 'Business Name', 'Total of Loyalty Stars'];
        const formattedRows = formatRows(merchants.value);

        // Add title row centered across all columns
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: headers.length - 1 } }]; // Merge title row cells

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'LoyaltyStars');
        XLSX.writeFile(workbook, 'LoyaltyStars.xlsx');
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
        // Define title and headers for the CSV
        const title = ['Loyalty Stars List']; // Title row
        const headers = ['#', 'Merchant Name', 'Business Name', 'Total of Loyalty Stars'];
        const formattedRows = formatRows(merchants.value);

        // Create worksheet with a centered title row
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: columnHeaders.length - 1 } }]; // Merge title row cells

        const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvOutput], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'LoyaltyStars.csv');
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
        const tableClone = document.getElementById('loyaltystarlist').cloneNode(true);

        tableClone.querySelectorAll('th:nth-child(5), td:nth-child(5)').forEach(el => el.remove());
        const printContents = tableClone.outerHTML;
        if (!printContents) {
            toastr.info('No data to print.');
            return;
        }

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
          <head>
            <title>Print Loyalty Stars List</title>
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
        console.error('Error printing table:', error);
        toastr.error('Failed to print.');
    }
};



</script>
