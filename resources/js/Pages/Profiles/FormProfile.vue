<template>
    <!-- Start Profile -->
    <div class="tab-pane fade show active" id="pills-timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
        <div class="card-body">

            <form class="form-horizontal form-material" @submit.prevent="updateUsers" method="PUT">
                <!--  Profile Details  -->
                <div class="form-group">
                    <label class="col-md-2 text-left control-label col-form-label text-muted">
                        First Name
                    </label>
                    <div class="col-md-12">
                        <input type="text" placeholder="Enter First Name" class="form-control form-control-line"
                            name="fname" v-model="form.fname" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 text-left control-label col-form-label text-muted">
                        Middle Name
                    </label>
                    <div class="col-md-12">
                        <input type="text" placeholder="Enter Last Name" class="form-control form-control-line"
                            name="mname" v-model="form.mname">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 text-left control-label col-form-label text-muted">
                        Last Name
                    </label>
                    <div class="col-md-12">
                        <input type="text" placeholder="Enter Last Name" class="form-control form-control-line"
                            name="lname" v-model="form.lname" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 text-left control-label col-form-label text-muted">Email</label>
                    <div class="col-md-12">
                        <input type="email" placeholder="Enter Email" class="form-control form-control-line"
                            name="email" v-model="form.email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 text-left control-label col-form-label text-muted">Contact</label>
                    <div class="col-md-12">
                        <input type="text" placeholder="Enter Contact Number" class="form-control form-control-line"
                            name="contact" v-model="form.contact" required>
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-sm-12">
                        <button class="btn btn-dark wave-light">Reset</button>
                        <button class="btn btn-primary wave-light ml-2" type="submit" name="update_profile">Update
                            Profile</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- End Profile -->
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';
import axios from 'axios';
import { onMounted, reactive, watch } from 'vue';
import { useToastr } from '@/toastr';

const authUser = useAuthUserStore();
const toastr = useToastr();
const form = reactive({
    fname: '',
    mname: '',
    lname: '',
    email: '',
    contact: ''
});

// I-update ang form kapag may pagbabago sa authUser.users
watch(() => authUser.users, (newValue) => {
    form.fname = newValue.fname;
    form.mname = newValue.mname;
    form.lname = newValue.lname;
    form.email = newValue.email;
    form.contact = newValue.contact;
});


let updateUsers = async () => {
    try {
        const response = await axios.put('/api/profile-information/edit', form);
        const message = response.data.message; // Kunin ang mensahe mula sa response
        toastr.success(message); // Ipakita ang mensahe gamit ang toastr
    } catch (error) {
        console.error(error);
    }
}
</script>
