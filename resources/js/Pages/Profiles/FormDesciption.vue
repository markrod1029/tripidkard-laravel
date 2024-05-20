<template>
    <div class="tab-pane fade" id="pills-business-discount" role="tabpanel"
        aria-labelledby="pills-business-discount-tab">
        <div class="card-body">
            <form class="form-horizontal form-material" @submit.prevent="updateBusiness">
                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">
                        Temporary Discount <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-12">
                        <input type="number" class="form-control form-control-line" name="temporary_discount"
                            v-model="form.discount" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">
                        Temporary Tagline <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="temporary_tagline"
                            v-model="form.tagline" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">
                        Description <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-12">
                        <textarea  class="form-control" rows="20" cols="10" v-model="form.description" />
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-line" name="access" v-model="form.access"
                            hidden>
                        <button class="btn btn-dark wave-light" type="reset">Reset</button>
                        <button class="btn btn-primary ml-2" type="submit">Update Description</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';
import axios from 'axios';
import { onMounted, reactive, watch } from 'vue';
import { useToastr } from '@/toastr';
import QuillEditor from './QuillEditor.vue';

const authUser = useAuthUserStore();
const toastr = useToastr();
const form = reactive({
    access: 'description',
    discount: '',
    description: '',
    tagline: '',
});

// Update the form when authUser.users changes
watch(() => authUser.users, (newValue) => {
    form.discount = newValue.discount;
    form.description = newValue.description;
    form.tagline = newValue.tagline;
}, { immediate: true });

const updateBusiness = async () => {
    try {
        const response = await axios.put('/api/profile-business/edit', form);
        const message = response.data.message; // Get the message from the response
        toastr.success(message); // Display success message
    } catch (error) {
        console.error(error);
        toastr.error(error.response.data.message || 'An error occurred'); // Display error message
    }
};
</script>

<style scoped>
.text-gray {
    color: gray;
}
</style>
