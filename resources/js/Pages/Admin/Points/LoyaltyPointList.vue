<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />


        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id='enterpriselist' class='display dataTable table-bordered'
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
                                        <tbody v-if="merchants.length > 0">
                                            <tr v-for="(merchant, index) in merchants" :key="merchant.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ merchant.fname }} {{ merchant.mname }} {{ merchant.lname }}</td>
                                                <td>{{ merchant.business_name }}</td>
                                                <td>{{ merchant.stars_points }} Stars Points</td>

                                                <td>
                                                    <div style="display: flex; justify-content: center;">
                                                        <router-link  class="btn btn-success btn-sm" :to="`/admin/loyalty-stars/${merchant.id}/customer`"
                                                            style="margin-right: 5px;"><i class="fa fa-eye"></i> </router-link>
                                                        <router-link :to="`/admin/loyalty-stars/${merchant.merchant_id}/edit`" class="btn btn-primary btn-sm  "
                                                            style="margin-right: 5px;"><i class="fa fa-edit"></i> </router-link>
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
import { onMounted, ref } from 'vue';
import axios from 'axios';

const merchants = ref([]);

const getMerchants = async () => {
  try {
    const response = await axios.get('/api/merchants');
    if (!response.data) {
      throw new Error('No data received from API');
    }

    merchants.value = response.data;
  } catch (error) {
    console.error('Error fetching merchants:', error);
  }
}

onMounted(() => {
    getMerchants();
});

</script>
