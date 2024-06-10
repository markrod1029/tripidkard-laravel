<template>
    <!-- Start Change Images -->
    <div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
        <div class="card-body">
            <form class="form-horizontal form-material">
                <!--  profile/update_business.php -->

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 1 </label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" @change="(event) => handleFileChange(event, 'photo1')" name="photo1">
                        <!-- Display selected image -->
                        <img v-if="file.photo1Url" :src="file.photo1Url" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 2 </label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" @change="(event) => handleFileChange(event, 'photo2')" name="photo2">
                        <!-- Display selected image -->
                        <img v-if="file.photo2Url" :src="file.photo2Url" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 3 </label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" @change="(event) => handleFileChange(event, 'photo3')" name="photo3">
                        <!-- Display selected image -->
                        <img v-if="file.photo3Url" :src="file.photo3Url" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Change Images -->
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';
import { ref, watch } from 'vue';
import axios from 'axios';
import { useToastr } from '@/toastr.js';

const authUser = useAuthUserStore();
const toastr = useToastr();


const file = ref({
    photo1: null,
    photo1Url: null,
    photo2: null,
    photo2Url: null,
    photo3: null,
    photo3Url: null,
});

const handleFileChange = async (event, field) => {
    const selectedFile = event.target.files[0];

    file.value[field] = selectedFile;
    file.value[`${field}`] = URL.createObjectURL(selectedFile);

    const formData = new FormData();
    formData.append(field, selectedFile);

    try {
        const response = await axios.post('/api/profile/upload-background-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        toastr.success(response.data.message);
    } catch (error) {
        toastr.error('An error occurred while uploading the image');
        console.error(error);
    }
}

// Watch for changes in authUser to update the image URLs
watch(() => authUser.users.photo1, (newValue, oldValue) => {
        file.value.photo1Url = newValue;
});

watch(() => authUser.users.photo2, (newValue, oldValue) => {
        file.value.photo2Url = newValue;
});

watch(() => authUser.users.photo3, (newValue, oldValue) => {
        file.value.photo3Url = newValue;
});



</script>
