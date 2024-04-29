<template>
    <!-- Start Change Password -->

    <div class="tab-pane fade" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
        <div class="card-body">
            <form class="form-horizontal form-material" @submit.prevent="changePassword" method="PUT">
                <!-- Profile Security-->
                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Old Password</label>
                    <div class="col-md-12">
                        <input type="password" v-model="form.currentPassword" placeholder="Enter New Password"
                            class="form-control form-control-line" name="old" required>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">New Password</label>
                    <div class="col-md-12">
                        <input type="password" v-model="form.password" placeholder="Enter New Password"
                            class="form-control form-control-line" name="new" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Confirm Password</label>
                    <div class="col-md-12">
                        <input type="password" v-model="form.passwordConfirmation" placeholder="Confirm Password"
                            class="form-control form-control-line" name="confirm" required>
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-line" name="merchant_id"
                            value="<?php echo $merchant_id; ?>" hidden>
                        <button class="btn btn-dark wave-light">Reset</button>
                        <button class="btn btn-primary ml-2" type="submit" name="update_password">Update
                            Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Change Password -->


</template>


<script setup>
import axios from "axios";
import { reactive } from "vue";


const form = reactive({
    currentPassword: '',
    password: '',
    passwordConfirmation: '',
});


let changePassword = async () => {
    try {
        const response = await axios.put('/api/profile-password/change', form);
    } catch (error) {
        console.error(error);

    }
}


</script>
