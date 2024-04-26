<template>
    <!-- Start Business Discount-->
    <div class="tab-pane fade " id="pills-business-discount" role="tabpanel"
        aria-labelledby="pills-business-discount-tab">
        <div class="card-body">

            <form class="form-horizontal form-material" action="class/profile_crud.php" method="POST">
                <!--  profile/update_business.php -->

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Discount</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_discount"
                            value="<?php echo $user['business_discount']; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Temporary
                        Discount</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="temporary_discount"
                            value="<?php echo $temporary_discount; ?>">
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Temporary Discount
                        Start</label>
                    <div class="col-md-12">
                        <input type="date" class="form-control form-control-line" name="start_date"
                            value="<?php echo $start_discount; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Temporary Discount
                        End</label>

                    <div class="col-md-12">
                        <input type="date" class="form-control form-control-line" name="end_date"
                            value="<?php echo $end_discount; ?>">
                    </div>
                </div>


                <!-- <div class="form-group">
    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Discount</label>
    <div class="col-md-12">
        <input type="text"  class="form-control form-control-line" name="discount" value="<?php
           if($enterprise_id == 0):
            echo $user['discount'];
        else:
            echo $business_user['enterprise_discount'];

        endif;
        ?>"required

        <?php
           if($enterprise_id == 0):
            echo '';
           else:
            echo 'readonly';
           endif;
        ?>
        >
    </div>
</div> -->


                <div class="form-group text-right">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-line" name="merchant_id"
                            value="<?php echo $merchant_id; ?>" hidden>
                        <button class="btn btn-dark wave-light" >Reset</button>
                        <button class="btn btn-primary ml-2" type="submit" name="update_business_discount">Update
                            Discount</button>
                    </div>
                </div>



            </form>

        </div>
    </div>

    <!-- End Business -->

</template>
