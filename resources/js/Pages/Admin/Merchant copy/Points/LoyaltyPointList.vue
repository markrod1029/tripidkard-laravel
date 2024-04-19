<template>
    <MenuBar/>
    <Sidebar/>

    <div class="content-wrapper">
        
      <Breadcrumb/>


        <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body mt-3 mb-3 ml-2 mr-2">
              <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"></div>
                <div class="row">
                  <div class="col-sm-12">
                    <table id='enterpriselist' class='display dataTable table-bordered' style="width:100%;">
                            <thead>
                                <tr>
                                    <th> Code</th>
                                    <th>Card Number</th>
                                    <th>Customer Name</th>
                                    <th>Business Name</th>
                                    <th>Contact No.</th>
                                    <th>Email Address</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- <?php // SQL query
                                $sql = "SELECT * FROM enterprise WHERE status = '1'";
                                $query = $conn->query($sql);
                                // I-fetch ang result set at ilagay sa loob ng HTML table
                                while ($row = $query->fetch_assoc()) {?> -->


                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                    <td>
                                        <div style="display: flex; justify-content: center;">
                                            <a href="enterprise-merchant?enterprise_id=<?php echo $row['id']?>"
                                                class="btn btn-success btn-sm  " style="margin-right: 5px;"><i
                                                    class="fa fa-eye"></i> </a>
                                            <a href="enterprise-register?action=update&&enterprise_id=<?php echo $row['id']?>"
                                                class="btn btn-primary btn-sm  " style="margin-right: 5px;"><i
                                                    class="fa fa-edit"></i> </a>
                                            <a href="class/enterprise_crud.php?action=archive&&enterprise_id=<?php echo $row['id']?>"
                                                onclick="return confirm('Are you sure you want to remove Archive this Enterprise Account?')"
                                                class="btn btn-danger btn-sm  "><i class="fa fa-redo"></i> </a>
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
    <Footer/>

</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
</script>