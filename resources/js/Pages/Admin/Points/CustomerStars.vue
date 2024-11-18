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
                          <th>Product Code</th>
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
                          <td>{{ point.product_code }}</td>
                          <td>{{ point.product_price }}</td>
                          <td>{{ point.points }}</td>
                          <td>
                            <div style="display: flex; justify-content: center;">
                              <router-link :to="`/merchant/loyalty-points/${point.point_id}/edit`" class="btn btn-primary btn-sm  "
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
  import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
  import Footer from '@/Components/Organisims/Footer.vue';
  import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
  import { useToastr } from '@/toastr.js';

  import axios from 'axios';
  import { ref, onMounted, watch } from 'vue';
  import { debounce } from 'lodash';

  const toastr = useToastr();
  const points = ref([]);
  const searchQuery = ref([]);
  const merchantId = ref(null);
  const getPoints = async () => {
    try {
      const response = await axios.get('/api/merchant/points/${merchantId.value}', {
        params: {
          query: searchQuery.value
        }
      });
      points.value = response.data;
    } catch (error) {
      console.error('Error fetching services:', error);
    }
  }



  watch(searchQuery, debounce(() => {
    getPoints();
  }, 100));



  onMounted(() => {
    getPoints();


  });

  </script>
