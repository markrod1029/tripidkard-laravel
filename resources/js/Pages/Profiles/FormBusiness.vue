<template>
    <!-- Start Business -->
    <div class="tab-pane fade " id="pills-business" role="tabpanel" aria-labelledby="pills-business-tab">
        <div class="card-body">

            <form class="form-horizontal form-material" action="class/profile_crud.php" method="POST">
                <!--  Update Business -->


                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Name</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_name"
                            v-model="authUser.users.business_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Category</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_category"
                            v-model="authUser.users.business_category" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Sub
                        Category</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_sub_category"
                            v-model="authUser.users.business_sub_category" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">City</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="city"
                            v-model="authUser.users.zip" required>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Street</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="street"
                            v-model="authUser.users.street" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">City</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="city"
                            v-model="authUser.users.city" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Province</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="province"
                            v-model="authUser.users.province" required>
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-line" name="merchant_id"
                            value="<?php echo $merchant_id; ?>" hidden>
                        <button class="btn btn-dark wave-light" >Reset</button>
                        <button class="btn btn-primary ml-2" type="submit" name="update_business">Update Business</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <!-- End Business -->

</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';

const authUser = useAuthUserStore();
</script>
