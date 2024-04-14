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


              <div  class="col-3">
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
                    <tbody v-if="customers.length > 0">

                      <tr v-for="(customer, index) in customers " :key="customer.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ customer.customer_card_num }}</td>
                        <td>{{ customer.fname }} {{ customer.mname }} {{ customer.lname }}</td>
                        <td>{{ customer.contact }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.zip }} {{ customer.street }} {{ customer.city }} {{ customer.province }}</td>

                        <td>
                          <div style="display: flex; justify-content: center;">
                            <router-link :to="`/admin/customer/${customer.id}/edit`" class="btn btn-primary btn-sm  "
                              style="margin-right: 5px;"><i class="fa fa-edit"></i>
                            </router-link>

                            <a class="btn btn-danger btn-sm text-white" @click.prevent="(deleteCustomer(customer.id))"
                              style="margin-right: 5px;"><i class="fa fa-redo"></i>
                            </a>



                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>

                      <tr>
                        <td colspan="7" class="text-center"> No Customer Found</td>
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

const toastr = useToastr();
const customers = ref([]);
const searchQuery = ref([]);

const getCustomers = async () => {
  try {
    const response = await axios.get('/api/customers', {
      params: {
        query: searchQuery.value
      }
    });
    customers.value = response.data;
  } catch (error) {
    console.error('Error fetching services:', error);
  }
}



watch(searchQuery, debounce(() => {
  getCustomers();
}, 100));



onMounted(() => {
  getCustomers();


});

// let deleteCustomer = () => {
//   axios.post('/api/')
// }
</script>