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
                    <button
                      type="button"
                      class="btn btn-primary dropdown-toggle"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
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
                  <input
                    type="text"
                    v-model="searchQuery"
                    class="form-control"
                    placeholder="Search..."
                  />
                </div>
              </div>

              <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="customerlist" class="display dataTable table-bordered" style="width:100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Card Number</th>
                          <th>Customer Name</th>
                          <th>Star Points</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody v-if="customers.length > 0">
                        <tr v-for="(customer, index) in customers" :key="customer.id">
                          <td>{{ index + 1 }}</td>
                          <td>{{ customer.customer_card_num }}</td>
                          <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                          <td>{{ customer.points }} Star Points</td>
                          <td>{{ formatDate(customer.point_created_at) }}</td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right font-weight-bold">Total Star Points:</td>
                          <td colspan="2" class="font-weight-bold">{{ totalStarPoints }} Star Points</td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="5" class="text-center">No Customer Found</td>
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
  import { ref, onMounted, watch, computed } from 'vue';
  import { debounce } from 'lodash';
  import * as XLSX from 'xlsx'; // Import XLSX for Excel/CSV export
  import Swal from 'sweetalert2';
  import { useRoute } from 'vue-router';

  const toastr = useToastr();
  const customers = ref([]);
  const searchQuery = ref('');
  const route = useRoute();

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
      getCustomers();
    }, 100)
  );

  onMounted(() => {
    getCustomers();
  });

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
  /* Add any additional styling here if needed */
  </style>
