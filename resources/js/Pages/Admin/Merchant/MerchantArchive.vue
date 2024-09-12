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
                                    <table id='merchantlist' class='display dataTable table-bordered'
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
                                                        <router-link
                                                            to="enterprise-merchant?enterprise_id=<?php echo $row['id']?>"
                                                            class="btn btn-success btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-eye"></i>
                                                        </router-link>

                                                        <router-link :to="`/admin/merchant/${merchant.id}/edit`"
                                                            class="btn btn-primary btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-edit"></i>
                                                        </router-link>

                                                        <router-link
                                                            to="class/enterprise_crud.php?action=archive&&enterprise_id=<?php echo $row['id']?>"
                                                            onclick="return confirm('Are you sure you want to remove Archive this Enterprise Account?')"
                                                            class="btn btn-danger btn-sm  "><i class="fa fa-redo"></i>
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
const searchQuery = ref([]);

const getMerchants = async () => {
    try {
        const response = await axios.get('/api/merchants', {
            params: {
                query: searchQuery.value,
            }
        });
        merchants.value = response.data;
    } catch (error) {
        console.error('Error fetching merchant:', error);
    }
}



watch(searchQuery, debounce(() => {
    getMerchants();
}, 100));



onMounted(() => {
    getMerchants();


});

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
        // Define headers and format rows without "Action" column
        const title = ['Merchant List']; // Title row
        const headers = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
        const formattedRows = formatRows(merchants.value);

        // Add title row centered across all columns
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: headers.length - 1 } }]; // Merge title row cells

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
        // Define title and headers for the CSV
        const title = ['Merchant List']; // Title row
        const columnHeaders = ['#', 'Card Code', 'Store Code', 'Merchant Name', 'Business Name', 'Business Category', 'Contact No.', 'Email Address', 'Address'];
        const formattedRows = formatRows(merchants.value);

        // Create worksheet with a centered title row
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, columnHeaders, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: columnHeaders.length - 1 } }]; // Merge title row cells

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

        // Remove the "Action" column from the cloned table
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
</script>