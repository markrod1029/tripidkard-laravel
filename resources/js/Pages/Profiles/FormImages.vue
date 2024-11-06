<template>
    <!-- Start Change Images -->
    <div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
        <div class="card-body">
            <form class="form-horizontal form-material" @submit.prevent="uploadImages">
                <!-- Profile/Update Images -->

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 1</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo1" @change="previewImage($event, 'photo1')">
                        <img v-if="imagePreview.photo1" :src="imagePreview.photo1" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo1" :src="`/storage/${authUser.users.photo1}`" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 2</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo2" @change="previewImage($event, 'photo2')">
                        <img v-if="imagePreview.photo2" :src="imagePreview.photo2" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo2" :src="`/storage/${authUser.users.photo2}`" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 3</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo3" @change="previewImage($event, 'photo3')">
                        <img v-if="imagePreview.photo3" :src="imagePreview.photo3" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo3" :src="`/storage/${authUser.users.photo3}`" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
        </div>
    </div>
    <!-- End Change Images -->
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

const authUser = useAuthUserStore();
const imagePreview = reactive({
    photo1: null,
    photo2: null,
    photo3: null,
});

const previewImage = (event, photoKey) => {
    const file = event.target.files[0];
    if (file) {
        imagePreview[photoKey] = URL.createObjectURL(file);
    }
};

const uploadImages = async () => {
    try {
        const formData = new FormData();
        const photo1 = document.querySelector('[name="photo1"]').files[0];
        const photo2 = document.querySelector('[name="photo2"]').files[0];
        const photo3 = document.querySelector('[name="photo3"]').files[0];

        if (photo1) formData.append('photo1', photo1);
        if (photo2) formData.append('photo2', photo2);
        if (photo3) formData.append('photo3', photo3);

        if (formData.has('photo1') || formData.has('photo2') || formData.has('photo3')) {
            const response = await axios.post('/api/profile/upload-background-image', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            toastr.success(response.data.message);
            fetchExistingImages();
        } else {
            toastr.warning('Please select at least one image to upload.');
        }
    } catch (error) {
        toastr.error('Error uploading images.');
        console.error('Error uploading images:', error);
    }
};

const fetchExistingImages = async () => {
    try {
        const response = await axios.get('/api/profile/get-existing-images');
        Object.assign(authUser.users, response.data);  // Update authUser's images
    } catch (error) {
        toastr.error('Error fetching existing images.');
        console.error('Error fetching existing images:', error);
    }
};

onMounted(fetchExistingImages);
</script>
