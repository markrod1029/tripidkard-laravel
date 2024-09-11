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
                                        <button class="dropdown-item" @click="exportToCSV"  type="button">CSV</button>
                                        <button class="dropdown-item" @click="printTable"  type="button">Print</button>
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
                                    <table id='starslist' class='display dataTable table-bordered' style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Number</th>
                                                <th>Customer Name</th>
                                                <th>Product Price</th>
                                                <th>Loyalty Stars</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="points.length > 0">

                                            <tr v-for="(point, index) in points " :key="point.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ point.card_number }}</td>
                                                <td>{{ point.fname }} {{ point.mname }} {{ point.lname }}</td>
                                                <td>{{ point.product_price }}</td>
                                                <td>{{ point.points }}</td>
                                                <td>
                                                    <div style="display: flex; justify-content: center;">
                                                        <router-link
                                                            :to="`/merchant/loyalty-stars/${point.point_id}/edit`"
                                                            class="btn btn-primary btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-edit"></i>
                                                        </router-link>


                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>

                                            <tr>
                                                <td colspan="7" class="text-center"> No Loyalty Stars Found</td>
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
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useToastr } from '@/toastr.js';

import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';


const toastr = useToastr();
const points = ref([]);
const searchQuery = ref([]);

const getPoints = async () => {
    try {
        const response = await axios.get('/api/merchant/points', {
            params: {
                query: searchQuery.value
            }
        });
        points.value = response.data;
    } catch (error) {
        console.error('Error fetching services:', error);
    }
}

const formatRows = (rows) => {
    return rows.map((point, index) => [
        index + 1,
        point.card_number,
        `${point.fname} ${point.mname} ${point.lname}`,
        point.product_price,
        point.points
    ])
}


const exportToExcel = () => {
    try {
        if (points.value.length === 0) {
            toastr.info('No data to export.');
        }

        const title = ['Loyalty Stars List'] // Excel Row Title
        const headers = ['#', 'Card Number', 'Customer Name', 'Price', 'Loyalty Stars'];
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

const exportToCSV = (rows) => {
    try {
        if (points.value.length === 0) {
            toastr.info('No data to export.');
        }

        const title = ['Loyalty Stars List'] // Excel Row Title
        const headers = ['#', 'Card Number', 'Customer Name', 'Price', 'Loyalty Stars'];
        const formattedRows = formatRows(points.value);


        // merge Title and all columns
        const worksheet = XLSX.utils.aoa_to_sheet([[], title,  headers, ...formattedRows]);
    //   worksheet['!merges'] = [{ s: { r: 1, c: 0 }, e: { r: 1, c: headers.length - 1 } }]; // Merge title row cells

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


}

const printTable = () => {
    try {
        const tableClone = document.getElementById('starslist').cloneNode(true);

        // Remove the Action Column using Clone Table
        tableClone.querySelectorAll('th:nth-child(6), td:nth-child(6)').forEach(el => el.remove());

        const printContents =tableClone.outerHTML;
        if(!printContents) {
        toastr.info('No data to print.');
        return;
        }

        const printWindow = window.open('', '', 'width = 800, height=600');
        printWindow.document.write(`
           <html>
          <head>
            <title>Print Customer List</title>
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


watch(searchQuery, debounce(() => {
    getPoints();
}, 100));



onMounted(() => {
    getPoints();


});

</script>
