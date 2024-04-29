<template>
    <!-- Start Business -->
    <div class="tab-pane fade " id="pills-business" role="tabpanel" aria-labelledby="pills-business-tab">
        <div class="card-body">

            <form class="form-horizontal form-material" @submit.prevent="updateBusiness" method="POST">
                <!--  Update Business -->


                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Name</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_name"
                            v-model="form.business_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Category</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_category"
                            v-model="form.business_category" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Business Sub
                        Category</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="business_sub_category"
                            v-model="form.business_sub_category" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">City</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="city"
                            v-model="form.zip" required>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Street</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="street"
                            v-model="form.street" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">City</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="city"
                            v-model="form.city" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Province</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="province"
                            v-model="form.province" required>
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
import axios from 'axios';
import { onMounted, reactive, watch, ref } from 'vue';
import { useToastr } from '@/toastr';

const authUser = useAuthUserStore();
const toastr = useToastr();
const form = reactive({
    business_name: '',
    business_category: '',
    business_sub_category: '',
    zip: '',
    street: '',
    city: '',
    province: '',
});

// I-update ang form kapag may pagbabago sa authUser.users
watch(() => authUser.users, (newValue) => {
    form.business_name = newValue.business_name;
    form.business_category = newValue.business_category;
    form.business_sub_category = newValue.business_sub_category;
    form.zip = newValue.zip;
    form.street = newValue.street;
    form.city = newValue.city;
    form.province = newValue.province;
});


let updateBusiness = async () => {
    try {
        const response = await axios.put('/api/profile-business/edit', form);
         const message = response.data.message; // Kunin ang mensahe mula sa response
        toastr.success(message); // Idisplay success
    } catch (error) {
        console.error(error);
        toastr.success(error); // dispaly error

    }
}
</script>
