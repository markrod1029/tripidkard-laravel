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
                    <table id="enterpriselist" class="display dataTable table-bordered" style="width:100%;">
                      <thead>
                        <tr>
                          <th>Select</th>
                          <th>#</th>
                          <th>Card Number</th>
                          <th>Customer Name</th>
                          <th>Contact No.</th>
                          <th>Email Address</th>
                          <th>Address</th>
                          <!-- Excluded Action from export -->
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="customers.length > 0">
                        <tr v-for="(customer, index) in customers" :key="customer.id">
                          <td>
                            <input type="checkbox" v-model="selectedRows" :value="customer" />
                          </td>
                          <td>{{ index + 1 }}</td>
                          <td>{{ customer.customer_card_num }}</td>
                          <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                          <td>{{ customer.contact }}</td>
                          <td>{{ customer.email }}</td>
                          <td>
                            {{ customer.zip }} {{ customer.street }} {{ customer.city }} {{ customer.province }}
                          </td>
                          <td>
                            <div style="display: flex; justify-content: center;">
                              <router-link
                                :to="`/admin/customer/${customer.id}/edit`"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 5px;"
                                ><i class="fa fa-edit"></i
                              ></router-link>

                              <a
                                class="btn btn-danger btn-sm text-white"
                                @click.prevent="deleteCustomer(customer.id)"
                                style="margin-right: 5px;"
                                ><i class="fa fa-redo"></i
                              ></a>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="8" class="text-center">No Customer Found</td>
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
  import * as XLSX from 'xlsx'; // Import XLSX for Excel/CSV export

  const toastr = useToastr();
  const customers = ref([]);
  const searchQuery = ref('');
  const selectedRows = ref([]); // Track selected rows

  const getCustomers = async () => {
    try {
      const response = await axios.get('/api/customers', {
        params: {
          query: searchQuery.value,
        },
      });
      customers.value = response.data;
    } catch (error) {
      console.error('Error fetching customers:', error);
    }
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

  // Function to format rows excluding the "Action" column
  const formatRows = (rows) => {
    return rows.map((customer, index) => [
      index + 1,
      customer.customer_card_num,
      `${customer.fname} ${customer.mname} ${customer.lname}`,
      customer.contact,
      customer.email,
      `${customer.zip} ${customer.street} ${customer.city} ${customer.province}`,
    ]);
  };

  // Export to Excel
  const exportToExcel = () => {
    try {
      if (selectedRows.value.length === 0) {
        toastr.info('Please select rows to export.');
        return;
      }
      const formattedRows = [['#', 'Card Number', 'Customer Name', 'Contact No.', 'Email Address', 'Address']];
      formattedRows.push(...formatRows(selectedRows.value));
      const worksheet = XLSX.utils.aoa_to_sheet(formattedRows);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, 'Customers');
      XLSX.writeFile(workbook, 'customers.xlsx');
    } catch (error) {
      console.error('Error exporting to Excel:', error);
      toastr.error('Failed to export to Excel.');
    }
  };

  // Export to CSV
  const exportToCSV = () => {
    try {
      if (selectedRows.value.length === 0) {
        toastr.info('Please select rows to export.');
        return;
      }
      const formattedRows = [['#', 'Card Number', 'Customer Name', 'Contact No.', 'Email Address', 'Address']];
      formattedRows.push(...formatRows(selectedRows.value));
      const worksheet = XLSX.utils.aoa_to_sheet(formattedRows);
      const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
      const blob = new Blob([csvOutput], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.setAttribute('href', url);
      a.setAttribute('download', 'customers.csv');
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    } catch (error) {
      console.error('Error exporting to CSV:', error);
      toastr.error('Failed to export to CSV.');
    }
  };

  // Print Table
  const printTable = () => {
    try {
      const printContents = document.getElementById('enterpriselist').outerHTML;
      if (!printContents) {
        toastr.info('No data to print.');
        return;
      }
      const printWindow = window.open('', '', 'width=800,height=600');
      printWindow.document.write('<html><head><title>Print</title><style>table { width: 100%; border-collapse: collapse; } th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }</style></head><body>');
      printWindow.document.write(printContents);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    } catch (error) {
      console.error('Error printing table:', error);
      toastr.error('Failed to print.');
    }
  };
  </script>

  <style scoped>
  /* Add custom styles if needed */
  </style>
