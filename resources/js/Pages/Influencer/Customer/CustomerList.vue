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
                            {{ customer.zip }} {{ customer.street }} {{ customer.city }} {{ customer.province }}
                          </td>
                          <td>{{ customer.validity }}</td>
                          <td>
                            <div style="display: flex; justify-content: center;">
                              <router-link
                                :to="`/influencer/customer/${customer.id}/edit`"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 5px;"
                              ><i class="fa fa-edit"></i></router-link>
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

                    <!-- Pagination Controls -->
                    <nav aria-label="Page navigation">
                      <ul class="pagination">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                          <a class="page-link" @click="goToPage(currentPage - 1)">Previous</a>
                        </li>
                        <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
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
  import Sidebar from '@/Components/Organisims/Influencer/Sidebar.vue';
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
    const printContents = document.getElementById('customerlist').outerHTML;
    const newWin = window.open('');
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
          </style>
        </head>
        <body onload="window.print()">
          ${printContents}
        </body>
      </html>
    `);
    newWin.document.close();
  };

  </script>

  <style scoped>
  /* Add any additional styles here */
  .pagination {
    justify-content: flex-start; /* Align to the left */
  }
  </style>
