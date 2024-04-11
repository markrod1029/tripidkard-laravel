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
                    <button class="dropdown-item" type="button">Copy</button>
                    <button class="dropdown-item" type="button">Excel</button>
                    <button class="dropdown-item" type="button">CSV</button>
                    <button class="dropdown-item" type="button">Print</button>
                  </div>
                </div>
              </div>


              <div>
                <input type="text" name="" v-model="searchQuery" class="form-control" placeholder="Search..." id="">

              </div>
            </div>
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">

                <div class="col-sm-12">
                  <table id='enterpriselist' class='display dataTable table-bordered' style="width:100%;">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Card Number</th>
                        <th>Customer Name</th>
                        <th>Contact No.</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr v-for="(customer, index) in customers " :key="customer.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ customer.customer_card_num }}</td>
                        <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                        <td>{{ customer.contact }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.zip }} {{ customer.street }} {{ customer.city }} {{ customer.province }}</td>

                        <td>
                          <div style="display: flex; justify-content: center;">
                            <router-link :to="`/admin/customer/${customer.id}/edit`"
                              class="btn btn-primary btn-sm  " style="margin-right: 5px;"><i class="fa fa-edit"></i>
                            </router-link>

                            <router-link class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </router-link>


                          </div>
                        </td>
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
import { ref, onMounted } from 'vue';

const toastr = useToastr();

// const customers = ref([
//   {
//     'code': '001',
//     'cardNumber': '1234567890',
//     'fname': 'John',
//     'mname': 'C',
//     'lname': 'Doe',
//     'businessName': 'ABC Inc.',
//     'contactNumber': '123-456-7890',
//     'email': 'john@example.com',
//     'address': '123 Main St, City, Country',
//     'id': 1 // Assuming you have an ID for each customer
//   },

// ]);

const customers = ref([]);


const getCustomers = () => {
  axios.get('/api/customers')
    .then((response) => {
      customers.value = response.data;

      console.log(customers.value)
    })
    .catch((error) => {
      console.error('Error fetching services:', error);
    });
}

onMounted(() => {
  getCustomers();


});

</script>