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
                                    <table id='tripidkardlist' class='display dataTable table-bordered'
                                        style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Name/Blog Name</th> <!-- Updated heading -->
                                                <th>Card type</th>
                                                <th>Card Code</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="tripidkards.length > 0">

                                            <tr v-for="(tripidkard, index) in tripidkards" :key="tripidkard.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ tripidkard.business_or_blog_name }}</td> <!-- Updated field -->
                                                <td>{{ tripidkard.card_types }}</td> <!-- Updated field -->
                                                <td>{{ tripidkard.card_number }}</td>
                                            </tr>
                                        </tbody>

                                        <tbody v-else>

                                            <tr>
                                                <td colspan="5" class="text-center"> No Tripidkards Found</td>
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

const tripidkards = ref([]);
const searchQuery = ref([]);

const toastr = useToastr();
const gettripidkards = async () => {
    try {
        const response = await axios.get('/api/merchant/tripidkards', {
            params: {
                query: searchQuery.value,
            }
        });
        tripidkards.value = response.data;
    } catch (error) {
        console.error('Error fetching Tripidkards:', error);
    }
}

watch(searchQuery, debounce(() => {
    gettripidkards();
}, 100));

onMounted(() => {
    gettripidkards();
});



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
        // Define headers and format rows without "Action" column
        const title = ['Tripidkard List']; // Title row
        const headers = ['#', 'Business Code', 'Card Code', 'Card Types'];
        const formattedRows = formatRows(tripidkards.value);

        // Add title row centered across all columns
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: headers.length - 1 } }]; // Merge title row cells

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
        // Define title and headers for the CSV
        const title = ['Tripidkard List']; // Title row
        const headers = ['#', 'Business Code', 'Card Code', 'Card Types'];
        const formattedRows = formatRows(tripidkards.value);

        // Create worksheet with a centered title row
        const worksheet = XLSX.utils.aoa_to_sheet([[], title, headers, ...formattedRows]);
        //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: columnHeaders.length - 1 } }]; // Merge title row cells

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
        printWindow.print();
    } catch (error) {
        console.error('Error printing table:', error);
        toastr.error('Failed to print.');
    }
};

</script>
